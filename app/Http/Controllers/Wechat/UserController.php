<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends BaseController
{
    public function center()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        return view('wechat.user.center',compact('user_id'));
    }

    public function help()
    {
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

        return view('wechat.user.deposit',compact('user_id'));
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
}
