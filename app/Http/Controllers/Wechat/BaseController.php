<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public $wechat_appid = '';
    public $wechat_appsecret = '';
    public $wechat_token = '';

    public function __construct()
    {
        $this->wechat_appid = config('app.wechat_appid');
        $this->wechat_appsecret = config('app.wechat_appsecret');
        $this->wechat_token = config('app.wechat_token');
    }
}
