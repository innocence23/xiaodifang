<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\User;
use Illuminate\Http\Request;
use Auth;

class PostController extends Controller
{
    /**
     * @param Request $request
     * @return string
     */
    public function getLists(Request $request)
    {
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'desc');
        $name = $request->input('name', '');
        $status = $request->input('status', '');
        $cate_id = $request->input('cate_id', '');

//        $tags = $request->input('tags', '');
//        $tags = explode(':', $tags)[1];

        $where = [];
        if(!empty($name)) {
            $where[] = ['name', 'like', '%'.$name.'%'];
        }
        if(strlen($status) != 0) {
            $where[] = ['status', '=', $status];
        }
        if(!empty($cate_id)) {
            $cate_id = explode(':', $cate_id)[1];
            $where[] = ['cate_id', '=', $cate_id];
        }
//        if(!empty($name)) {
//            $where[] = ['name', 'like', '%'.$name.'%'];
//        }
        $curpage = ($offset / $limit) + 1;

        //\DB::enableQueryLog();
        //$res = Post::where($where)->orderby($sort, $order)->paginate($limit, $columns = ['*'], $pageName = 'page', $page = null);
        $res = Post::where($where)->orderby($sort, $order)->paginate($limit, ['*'], 'page', $curpage);
        //echo  response()->json(\DB::getQueryLog()); die;
        $total = $res->total();
        $rows = $res->items();

        $categories = Category::cateList();
        $users = User::userList();
        $tags = Tag::tagList();
        foreach ($rows as $k=>$v) {
            $rows[$k]['cate_name'] = $categories[$v['cate_id']];
            $rows[$k]['created_by_name'] = $users[$v['created_by']];
//            $rows[$k]['tag_name'] = $tags[$v['cate_id']];
        }
//        dd($rows);
        $response = [
            'total' => $total,
            'rows' => $rows
        ];
        return json_encode($response);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function cateAndTag()
    {
        $data['categories'] = Category::all(['id','name']);
        $data['tags'] = Tag::all(['id','name']);
        return response()->json($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index');
    }

    /**
     * Display the specified resource.
     * @param Post $post
     * @return mixed
     */
    public function show(Post $post)
    {
        $tags = [];
        foreach ($post->tags as $v) {
            $tags[] = $v['id'];
        }
        unset($post->tags);
        $post->tags = $tags;
        return $post;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:posts,title',
            'keyword' => 'required',
            'desc' => 'required',
            'cate_id' => 'required',
//            'pic' => 'required',
            'content' => 'required',
            'slug' => 'required|unique:posts,slug',
        ]);

        $model = new Post();
        foreach ($request->input() as $k => $v) {
            $model->$k = $v;
        }
        $tags = $model->tags;
        unset($model->tags);
        $id = Auth::id();
        $model->created_by = $id;
        $model->updated_by = $id;
        $model->save();
        $model->tags()->sync($tags);
        return response($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', ['id'=>$post->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {

        $this->validate($request, [
            'title' => 'required|unique:posts,title,'.$post->id,
            'keyword' => 'required',
            'desc' => 'required',
            'cate_id' => 'required',
//            'pic' => 'required',
            'content' => 'required',
            'slug' => 'required|unique:posts,slug,'.$post->id,
        ]);

        $model = $post;
        foreach ($request->input() as $k => $v) {
            $model->$k = $v;
        }
        $tags = $model->tags;
        unset($model->tags);
        unset($model->_method);
        $id = Auth::id();
        $model->created_by = $id;
        $model->updated_by = $id;
        $model->save();
        $model->tags()->sync($tags);
        return response($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request, Post $post)
    {
        $model = $post;
        $status = $request->input('status', 0) ;
        $model->updated_by = Auth::id();
        $model->status = $status ? 0 : 1 ;
        $model->save();
        return response()->json(['errorCode' => '0', 'errorMsg' => 'success']);
    }
}
