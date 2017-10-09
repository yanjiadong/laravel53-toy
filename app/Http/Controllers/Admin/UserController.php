<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\VipCardPay;
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

        $users = User::paginate(30);
        $menu = 'user';
        //print_r($orders);

        return view('admin.user.index',compact('users','username','menu'));
    }

    public function action(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');

        $ret = User::where('id',$id)->update(['is_vip'=>$status]);
        if($ret)
        {
            VipCardPay::where('user_id',$id)->where('status',1)->where('pay_status',1)->update(['status'=>-1]);
        }
        alert('',1);
    }
}
