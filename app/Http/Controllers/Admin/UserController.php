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

    public function index(Request $request)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $is_vip = $request->get('is_vip');
        if(empty($is_vip))
        {
            $users = User::paginate(30);
        }
        else
        {
            if(!empty($is_vip))
            {
                $where['is_vip'] = $is_vip - 1;
            }
            $users = User::where($where)->paginate(30);
        }


        $menu = 'user';
        //print_r($orders);

        return view('admin.user.index',compact('users','username','menu','is_vip'));
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
