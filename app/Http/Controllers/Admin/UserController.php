<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $users = User::paginate(5);
        $menu = 'user';
        //print_r($orders);

        return view('admin.user.index',compact('users','username','menu'));
    }

    public function action(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');

        User::where('id',$id)->update(['status'=>$status]);
        alert('',1);
    }
}
