<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends BaseController
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

        $activitys = Activity::all();
        $menu = 'activity';
        return view('admin.activity.index',compact('activitys','username','menu'));
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
        $menu = 'activity';
        return view('admin.activity.create',compact('username','menu'));
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
            'url'=>$request->get('url'),
            'picture'=>$request->get('picture'),
            'type'=>$request->get('type')
        ];

        Activity::create($data);
        return alert(route('activitys.index'),1);
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
        $menu = 'activity';

        $activity = Activity::findOrFail($id);
        return view('admin.activity.edit',compact('username','menu','activity'));
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
            'url'=>$request->get('url'),
            'picture'=>$request->get('picture'),
            'type'=>$request->get('type')
        ];

        Activity::where('id',$id)->update($data);
        return alert(route('activitys.index'),1);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Activity::destroy($id);
        return alert('',1);
    }
}
