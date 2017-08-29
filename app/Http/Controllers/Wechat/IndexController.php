<?php

namespace App\Http\Controllers\Wechat;

use App\WechatAccessToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends BaseController
{
    /**
     * 验证服务器配置
     * @param Request $request
     * @return bool
     */
    public function valid(Request $request)
    {
        $echoStr = $request->get('echostr');

        $signature = $request->get('signature');
        $timestamp = $request->get('timestamp');
        $nonce = $request->get('nonce');

        $token = $this->wechat_token;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            echo $echoStr;
            exit;
        }else{
            return false;
        }
    }

    public function menu()
    {
        $info = WechatAccessToken::orderBy('id','desc')->first();
        if(!empty($info->access_token) && $this->time < $info->expires_in)
        {

        }
        else
        {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->wechat_appid."&secret=".$this->wechat_appsecret;
            echo $url;
            $result = weixinCurl($url);
            print_r($result);
        }
    }
}
