<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\CategoryTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryTagController extends BaseController
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

        $tags = CategoryTag::with('category')->get();
        $menu = 'tag';

        return view('admin.category_tag.index',compact('tags','username','menu'));
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
        $menu = 'tag';

        $categorys = Category::all();
        return view('admin.category_tag.create',compact('username','menu','categorys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CategoryTag::create(['title'=>$request->get('title'),'category_id'=>$request->get('category_id')]);
        return alert(route('category_tags.index'),1);
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

        $tag = CategoryTag::findOrFail($id);
        $categorys = Category::all();
        return view('admin.category_tag.edit',compact('username','menu','tag','categorys'));
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
        CategoryTag::where('id',$id)->update(['title'=>$request->get('title'),'category_id'=>$request->get('category_id')]);
        return alert(route('category_tags.index'),1);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CategoryTag::destroy($id);
        return alert('',1);
    }

    public function get_tags_by_id(Request $request)
    {
        $tags = CategoryTag::where('category_id',$request->get('category_id'))->get();
        $option = '<option value="0">--请选择--</option>';
        foreach ($tags as $tag)
        {
            $option .= '<option value="'.$tag->id.'">'.$tag->title.'</option>';
        }

        return alert(array('html' => $option), 1);
    }
}
