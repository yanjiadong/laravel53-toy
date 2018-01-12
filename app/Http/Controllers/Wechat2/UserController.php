<?php

namespace App\Http\Controllers\Wechat2;

use App\Cart;
use App\Order;
use App\SystemConfig;
use App\User;
use App\VipCardPay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\Factory;

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
    public function share_open(Request $request)
    {
        $from_user_id = $request->get('user_id');  //推荐人id
        session(['from_user_id'=>$from_user_id]);

        $openid = session('open_id');
        if(empty($openid))
        {
            $config = [
                'app_id' => env('WECHAT_OFFICIAL_ACCOUNT_APPID', 'wxdd1dd7306d6662cf'),         // AppID
                'secret' => env('WECHAT_OFFICIAL_ACCOUNT_SECRET', 'a16015c011af53215d2a885d1c1400af'),    // AppSecret
                'token' => env('WECHAT_OFFICIAL_ACCOUNT_TOKEN', 'ZuZhUsk6zE3cjNdwXRP6t1bKogOa5WGh'),           // Token
            ];
            $app = Factory::officialAccount($config);
            $response = $app->oauth->scopes(['snsapi_userinfo'])->redirect(route('wechat2.index.share_open_oauth_callback'));
            return $response;
        }

        return view('wechat2.user.share_open');
    }

    public function share_open_oauth_callback(Request $request)
    {
        $config = [
            'app_id' => env('WECHAT_OFFICIAL_ACCOUNT_APPID', 'wxdd1dd7306d6662cf'),         // AppID
            'secret' => env('WECHAT_OFFICIAL_ACCOUNT_SECRET', 'a16015c011af53215d2a885d1c1400af'),    // AppSecret
            'token' => env('WECHAT_OFFICIAL_ACCOUNT_TOKEN', 'ZuZhUsk6zE3cjNdwXRP6t1bKogOa5WGh'),           // Token
        ];
        $app = Factory::officialAccount($config);
        $oauth = $app->oauth;
        // 获取 OAuth 授权结果用户信息
        $user = $oauth->user();

        $openid = $user->getId();

        session(['open_id'=>$openid]);

        $info = User::where('wechat_openid',$openid)->first();
        if(empty($info))
        {
            $data = array(
                'name'=>filterEmoji($user->getNickname()),
                'email'=>'',
                'password'=>'',
                'wechat_openid'=>$openid,
                'wechat_original'=>json_encode($user->toArray()),
                'wechat_nickname'=>filterEmoji($user->getNickname()),
                'wechat_avatar'=>$user->getAvatar(),
                'open_num'=>0
            );

            $success = User::create($data);
            session(['user_id'=>$success->id]);

            DB::table('user_recommends')->insert(['from_user_id'=>session('from_user_id'),'to_user_id'=>$success->id,'created_at'=>date('Y-m-d H:i:s')]);
        }
        else
        {
            session(['user_id'=>$info->id]);

            $data = array(
                'name'=>filterEmoji($user->getNickname()),
                'wechat_openid'=>$openid,
                'wechat_original'=>json_encode($user->toArray()),
                'wechat_nickname'=>filterEmoji($user->getNickname()),
                'wechat_avatar'=>$user->getAvatar(),
            );

            User::where('id',$info->id)->update($data);
        }

        /*$share_open_url = session('share_open_url');

        $targetUrl = !empty($share_open_url)?$share_open_url:route('wechat2.user.share_open');
        header('location:'. $targetUrl); // 跳转到 user/profile*/
        return redirect()->route('wechat2.user.share_open',['user_id'=>session('from_user_id')]);
    }

    /**
     * 帮助页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function help()
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

        return view('wechat2.user.help');
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

    /**
     * 提现成功页面
     * @param $order_code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cash_success($order_code)
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        $order = Order::where('code',$order_code)->first();

        return view('wechat2.user.cash_success',compact('user_id','user','order'));
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

    /**
     * 个人中心的优惠券
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function user_coupon()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        return view('wechat2.user.user_coupon',compact('user_id'));
    }
}
