<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
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
        $where = [];
        if(!empty($name)) {
            $where[] = ['name', 'like', '%'.$name.'%'];
        }
        if(strlen($status) != 0) {
            $where[] = ['status', '=', $status];
        }
        $curpage = ($offset / $limit) + 1;

        //\DB::enableQueryLog();
        //$res = Post::where($where)->orderby($sort, $order)->paginate($limit, $columns = ['*'], $pageName = 'page', $page = null);
        $res = Post::where($where)->orderby($sort, $order)->paginate($limit, ['*'], 'page', $curpage);
        //echo  response()->json(\DB::getQueryLog()); die;
        $total = $res->total();
        $rows = $res->items();
        $response = [
            'total' => $total,
            'rows' => $rows
        ];
        return json_encode($response);
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::cateList();
        $tags = Tag::tagList();
        $categories = json_encode($categories);
        return view('posts.create', ['categories'=>$categories, 'tags'=>$tags ]);
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
        return response($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Post::find($id);
        return view('posts.edit', ['model'=>$model]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:posts,name,'.$id,
        ]);
        $model = Post::find($id);
        $model->name = $request->input('name', '') ;
        $model->updated_by = Auth::id();
        $model->save();
        return response($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request, $id)
    {
        $model = Post::find($id);
        $status = $request->input('status', 0) ;
        $model->updated_by = Auth::id();
        $model->status = $status ? 0 : 1 ;
        $model->save();
        return response()->json(['errorCode' => '0', 'errorMsg' => 'success']);
    }
}
