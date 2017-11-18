<?php

namespace App\Http\Controllers\Wechat;

use App\Cart;
use App\Order;
use App\SystemConfig;
use App\User;
use App\VipCardPay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends BaseController
{
    public function center()
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

        $user_id = session('user_id');
        $openid = session('open_id');
        $menu = 'center';

        //计算玩具箱数量
        $cart_num = Cart::where('user_id',$user_id)->count();

        //客服电话
        $config = SystemConfig::where('type',1)->first();
        $content = json_decode($config->content,true);
        $phone = '';
        if(isset($content[7]))
        {
            $phone = $content[7];
        }

        //正在租用中的玩具数量
        $order_num = Order::where('user_id',$user_id)->whereIn('status',[Order::STATUS_WAITING_SEND,Order::STATUS_SEND,Order::STATUS_DOING])->count();

        return view('wechat.user.center1',compact('user_id','menu','cart_num','phone','order_num'));
    }

    public function share()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        $user = User::find($user_id);
        $count = Order::where('user_id',$user_id)->count();

        $signPackage = getJssdk();

        return view('wechat.user.share',compact('user_id','user','count','signPackage'));
    }

    public function share_open($user_id)
    {
        $user = User::find($user_id);
        $count = Order::where('user_id',$user_id)->count();
        return view('wechat.user.share_open',compact('user_id','user','count'));
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
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deposit_list()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        return view('wechat.user.deposit_list',compact('user_id'));
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
