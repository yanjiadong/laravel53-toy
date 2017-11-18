<?php

namespace App\Http\Controllers\Wechat;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public $wechat_appid = '';
    public $wechat_appsecret = '';
    public $wechat_token = '';
    public $time = null;
    protected $datetime = null;

    public function __construct()
    {
        $this->wechat_appid = config('app.wechat_appid');
        $this->wechat_appsecret = config('app.wechat_appsecret');
        $this->wechat_token = config('app.wechat_token');
        $this->time = time();
        $this->datetime = date('Y-m-d H:i:s',$this->time);
    }

    public function check_user()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        if(empty($openid) || empty($user_id))
        {
            $url = url('wechat/index/getOpenId');
            Header("Location: $url");
            exit();
        }

        $user_info = User::find($user_id);
        if(empty($user_info))
        {
            $url = url('wechat/index/getOpenId');
            Header("Location: $url");
            exit();
        }

        if($user_info->id != $user_id)
        {
            $url = url('wechat/index/getOpenId');
            Header("Location: $url");
            exit();
        }
    }

    public function getOpenId(Request $request)
    {
        $code = $request->get('code');
        if($code)
        {
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->wechat_appid."&secret=".$this->wechat_appsecret."&code={$code}&grant_type=authorization_code";
            $result = weixinCurl($url);

            if(isset($result['openid']))
            {
                session(['open_id'=>$result['openid']]);

                $info = User::where('wechat_openid',$result['openid'])->first();
                if(empty($info))
                {
                    $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$result['access_token']}&openid={$result['openid']}&lang=zh_CN";
                    $info = weixinCurl($url);

                    $data = array(
                        'name'=>filterEmoji($info['nickname']),
                        'email'=>'',
                        'password'=>'',
                        'wechat_openid'=>$result['openid'],
                        'wechat_original'=>json_encode($info),
                        'wechat_nickname'=>filterEmoji($info['nickname']),
                        'wechat_avatar'=>$info['headimgurl'],
                        'open_num'=>0
                    );

                    $success = User::create($data);
                    //echo $success->id;
                    //dd($success);
                    session(['user_id'=>$success->id]);

                }
                else
                {
                    session(['user_id'=>$info->id]);
                    $user_id = $info->id;

                    $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$result['access_token']}&openid={$result['openid']}&lang=zh_CN";
                    $info = weixinCurl($url);

                    $data = array(
                        'name'=>filterEmoji($info['nickname']),
                        'wechat_openid'=>$result['openid'],
                        'wechat_original'=>json_encode($info),
                        'wechat_nickname'=>filterEmoji($info['nickname']),
                        'wechat_avatar'=>$info['headimgurl'],
                    );

                    User::where('id',$user_id)->update($data);
                }
            }

            return redirect()->route('wechat.index.index');
        }
        else
        {
            $redirect_uri = urlencode(url('wechat/index/getOpenId'));
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->wechat_appid."&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
            Header("Location: $url");
            exit();
        }
    }
}
