<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends BaseController
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

        $brands = Brand::with('category')->get();
        $menu = 'brand';
        return view('admin.brand.index',compact('brands','username','menu'));
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
        $menu = 'brand';

        $categorys = Category::all();
        return view('admin.brand.create',compact('username','menu','categorys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Brand::create(['title'=>$request->get('title'),'category_id'=>$request->get('category_id')]);
        return alert(route('brands.index'),1);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $menu = 'tag';

        $brand = Brand::findOrFail($id);
        $categorys = Category::all();
        return view('admin.brand.edit',compact('username','menu','brand','categorys'));
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
        Brand::where('id',$id)->update(['title'=>$request->get('title'),'category_id'=>$request->get('category_id')]);
        return alert(route('brands.index'),1);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Brand::destroy($id);
        return alert('',1);
    }

    public function get_brands_by_id(Request $request)
    {
        $brands = Brand::where('category_id',$request->get('category_id'))->get();
        $option = '<option value="0">--请选择--</option>';
        foreach ($brands as $brand)
        {
            $option .= '<option value="'.$brand->id.'">'.$brand->title.'</option>';
        }

        return alert(array('html' => $option), 1);
    }
}
