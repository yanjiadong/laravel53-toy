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
use DB;

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

        $is_zhima = $request->get('is_zhima');
        if(empty($is_zhima))
        {
            $users = User::orderBy('id','desc')->paginate(30);
        }
        else
        {
            if(!empty($is_zhima))
            {
                $where['is_zhima'] = $is_zhima - 1;
            }
            $users = User::where($where)->orderBy('id','desc')->paginate(30);
        }

        //分页需要的参数
        $users->appends([
            'is_zhima'=>$is_zhima
        ]);
        $menu = 'user';
        //print_r($orders);

        return view('admin.user.index',compact('users','username','menu','is_zhima'));
    }

    public function recommend(Request $request)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];



        $from_users = DB::table('user_recommends')
            ->select("user_recommends.from_user_id")
            //->leftJoin('users', 'users.id', '=', 'user_recommends.from_user_id')
            ->groupBy('from_user_id')
            ->paginate(30);

        //print_r($from_users);
        $users = [];
        if(!empty($from_users))
        {
            foreach ($from_users as $from)
            {
                //print_r($from);
                $user = DB::table('users')->select('name','award_num','telephone')->where('id',$from->from_user_id)->first();

                //print_r($user);
                $user->user_recommends_count = DB::table('user_recommends')->where('from_user_id',$from->from_user_id)->count();
                $user->user_recommends_order_count = DB::table('user_recommends')->where('from_user_id',$from->from_user_id)->where('is_order',1)->count();
                $user->exchange_coupon_count = DB::table('user_coupons')->where('coupon_type',3)->where('user_id',$from->from_user_id)->count();

                $users[] = $user;
            }
        }
        $menu = 'user';
        return view('admin.user.recommend',compact('users','username','menu','from_users'));
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
        UserOpenTime::where('user_id',$id)->delete();
        DB::table('user_recommends')->where('to_user_id',$id)->delete();
        alert('',1);
    }
}
