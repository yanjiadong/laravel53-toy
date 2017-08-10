<?php

namespace App\Http\Controllers\Admin;

use App\Express;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpressController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $expresses = Express::all();
        $menu = 'dictionary';
        return view('admin.express.index',compact('expresses','username','menu'));
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
        $menu = 'dictionary';
        return view('admin.express.create',compact('username','menu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'title'=>$request->get('title'),
            'com'=>$request->get('com')
        ];

        Express::create($data);
        return alert(route('expresses.index'),1);
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
        $menu = 'dictionary';

        $express = Express::findOrFail($id);
        return view('admin.express.edit',compact('username','menu','express'));
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
        $data = [
            'title'=>$request->get('title'),
            'com'=>$request->get('com'),
        ];

        Express::where('id',$id)->update($data);
        return alert(route('expresses.index'),1);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Express::destroy($id);
        return alert('',1);
    }
}
