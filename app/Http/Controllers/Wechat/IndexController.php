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

    /**
     * 创建公众号菜单栏
     */
    public function menu()
    {
        $info = WechatAccessToken::orderBy('id','desc')->first();
        $access_token = '';
        if(!empty($info->access_token) && $this->time < $info->expires_in)
        {
            $access_token = $info->access_token;
        }
        else
        {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->wechat_appid."&secret=".$this->wechat_appsecret;
            $result = weixinCurl($url);
            if(!empty($result))
            {
                WechatAccessToken::create(['access_token'=>$result['access_token'],'expires_in'=>$result['expires_in']+$this->time]);
                $access_token = $result['access_token'];
            }
        }

        if(!empty($access_token))
        {
            $data = <<<EOF
        {
         "button":[
            {
                "name":"租编程玩具",
                "type":"view",
                "url":"http://toy.yanjiadong.net"
            },
          {
               "name":"我的订单",
                "type":"view",
                "url":"http://toy.yanjiadong.net"
           },
           {
                "name":"更多",
               "sub_button":[
                    {
                       "type":"view",
                       "name":"寄回地址",
                       "url":"http://toy.yanjiadong.net"
                    },
                     {
                       "type":"view",
                       "name":"新手指南",
                       "url":"http://toy.yanjiadong.net"
                    }, 
                    {
                       "type":"view",
                       "name":"我的账户",
                       "url":"http://toy.yanjiadong.net"
                    },
                    {
                       "type":"view",
                       "name":"联系客服",
                       "url":"http://toy.yanjiadong.net"
                    }
                ]
           }
       ]
    }
EOF;
            $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;

            $result = weixinCurl($url,'post',$data);
            if($result && $result['errcode']==0)
            {
                echo 'ok';
            }
            else
            {
                print_r($result);
            }
        }
    }
}
