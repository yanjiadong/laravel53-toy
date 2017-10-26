<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Category;
use App\Good;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $categorys = Category::all();
        $menu = 'category';
        return view('admin.category.index',compact('categorys','username','menu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];
        $menu = 'category';
        return view('admin.category.create',compact('username','menu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Category::create(['title'=>$request->get('title'),'picture'=>$request->get('picture'),'desc'=>$request->get('desc')]);
        return alert(route('categorys.index'),1);
        //return response()->json(['success'=>1,'url'=>route('categorys.index')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];
        $menu = 'category';

        $category = Category::findOrFail($id);
        return view('admin.category.edit',compact('username','menu','category'));
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
        //print_r($request->all());
        Category::where('id',$id)->update(['title'=>$request->get('title'),'picture'=>$request->get('picture'),'desc'=>$request->get('desc')]);
        return alert(route('categorys.index'),1);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //删除分类的时候同时也判断商品和品牌是否有相关的
        $goods = Good::where('category_id',$id)->get();
        if(count($goods) > 0)
        {
            alert('无法删除分类，由于存在商品关联该分类');
        }

        $brands = Brand::where('category_id',$id)->get();
        if(count($brands) > 0)
        {
            alert('无法删除分类，由于存在品牌关联该分类');
        }

        Category::destroy($id);
        return alert('',1);
    }
}
