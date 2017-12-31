<?php

namespace App\Http\Controllers\Admin;

use App\Cart;
use App\Order;
use App\User;
use App\UserAddress;
use App\UserCoupon;
use App\UserOpenTime;
use App\UserPayRecord;
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
            $users = User::orderBy('id','desc')->paginate(30);
        }
        else
        {
            if(!empty($is_vip))
            {
                $where['is_vip'] = $is_vip - 1;
            }
            $users = User::where($where)->orderBy('id','desc')->paginate(30);
        }

        //分页需要的参数
        $users->appends([
            'is_vip'=>$is_vip
        ]);
        $menu = 'user';
        //print_r($orders);

        return view('admin.user.index',compact('users','username','menu','is_vip'));
    }

    public function get_user_open_times()
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $list = UserOpenTime::with('user')->orderBy('id','desc')->paginate(30);
        $menu = 'crontab';
        return view('admin.user.user_open_times',compact('users','username','menu','list'));
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

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        User::destroy($id);
        Order::where('user_id',$id)->delete();
        UserCoupon::where('user_id',$id)->delete();
        Cart::where('user_id',$id)->delete();
        UserAddress::where('user_id',$id)->delete();
        UserPayRecord::where('user_id',$id)->delete();
        alert('',1);
    }
}
