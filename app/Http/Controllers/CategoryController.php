<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Auth;

class CategoryController extends Controller
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
        //$res = Category::where($where)->orderby($sort, $order)->paginate($limit, $columns = ['*'], $pageName = 'page', $page = null);
        $res = Category::where($where)->orderby($sort, $order)->paginate($limit, ['*'], 'page', $curpage);
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
        return view('categories.index');
    }

    /**
     * Display the specified resource.
     * @param Category $category
     * @return mixed
     */
    public function show(Category $category)
    {
        return $category;
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
            'name' => 'required|unique:categories,name',
        ]);
        $name = $request->input('name', '');
        $model = new Category();
        $model->name = $name;
        $id = Auth::id();
        $model->created_by = $id;
        $model->updated_by = $id;
        $model->save();
        return response($model);
    }

    /**
    /**
     * Show the form for editing the specified resource
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('categories.edit', ['id'=>$category->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name,'.$category->id,
        ]);
        $model = $category;
        $model->name = $request->input('name', '') ;
        $model->updated_by = Auth::id();
        $model->save();
        return response($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request, Category $category)
    {
        $model = $category;
        $status = $request->input('status', 0) ;
        $model->updated_by = Auth::id();
        $model->status = $status ? 0 : 1 ;
        $model->save();
        return response()->json(['errorCode' => '0', 'errorMsg' => 'success']);
    }
}
