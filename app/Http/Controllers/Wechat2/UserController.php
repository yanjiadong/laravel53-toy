<?php

namespace App\Http\Controllers\Wechat2;

use App\Cart;
use App\Order;
use App\SystemConfig;
use App\User;
use App\VipCardPay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends BaseController
{
    /**
     * 用户中心
     * time 2017-12-20
     */
    public function user_center()
    {
        if(config('app.env')=='local')
        {
            session(['open_id'=>'o2xFAw7K6g1yHtZ-MvYFX2gYRzpI']);
            session(['user_id'=>29]);
        }
        else
        {
            $this->check_oauth();
        }

        $menu = 'user_center';

        $user_id = session('user_id');
        $openid = session('open_id');

        return view('wechat2.user.user_center',compact('user_id','menu'));
    }

    /**
     * 我的押金
     * time 2017-12-20
     */
    public function my_deposit()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        return view('wechat2.user.my_deposit',compact('user_id','openid'));
    }

    /**
     * 押金明细
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deposit_list()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        return view('wechat2.user.deposit_list',compact('user_id','openid'));
    }

    /**
     * 分享页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function share()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        $user = User::select('wechat_nickname')->first();
        //$user = User::find($user_id);
        $count = Order::where('user_id',$user_id)->where('status','>',Order::STATUS_UNPAY)->count();

        $signPackage = getJssdk();

        return view('wechat2.user.share',compact('user_id','user','count','signPackage','app'));
    }

    /**
     * 分享后打开的页面
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function share_open()
    {
        return view('wechat2.user.share_open');
    }

    public function help()
    {
        if(config('app.env')=='local')
        {
            session(['open_id'=>'o2xFAw7K6g1yHtZ-MvYFX2gYRzpI']);
            session(['user_id'=>29]);
        }
        else
        {
            $this->check_user();
        }

        return view('wechat.user.help');
    }

    /**
     * 会员押金详情
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deposit()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        $user = User::find($user_id);
        return view('wechat.user.deposit1',compact('user_id','user'));
    }

    public function deposit_success($vip_card_pay_id)
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        $vip_card_pay = VipCardPay::find($vip_card_pay_id);
        return view('wechat.user.deposit_success',compact('user_id','user','vip_card_pay'));
    }

    public function cash()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        $user = User::find($user_id);
        return view('wechat.user.cash',compact('user_id','user'));
    }


    public function choose_coupon()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        return view('wechat.user.choose_coupon',compact('user_id'));
    }

    public function user_coupon()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        return view('wechat.user.user_coupon',compact('user_id'));
    }
}
