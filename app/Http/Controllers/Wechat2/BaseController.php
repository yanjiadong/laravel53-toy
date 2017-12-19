<?php

namespace App\Http\Controllers\Wechat2;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\Factory;

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

    /**
     * 检查是否登录以及是否授权
     */
    public function check_oauth()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        $url = route('wechat2.index.oauth');

        if(empty($openid) || empty($user_id))
        {
            Header("Location: $url");
            exit();
        }

        $user_info = User::find($user_id);
        if(empty($user_info))
        {
            Header("Location: $url");
            exit();
        }

        if($user_info->id != $user_id)
        {
            Header("Location: $url");
            exit();
        }
    }

    /**
     * 微信授权回调
     * @return \Illuminate\Http\RedirectResponse
     */
    public function oauth_callback()
    {
        $config = config('wechat.official_account');
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
            //echo $success->id;
            //dd($success);
            session(['user_id'=>$success->id]);
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

        return redirect()->route('wechat2.index.index');
    }

    /**
     * 微信授权
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function oauth()
    {
        $config = config('wechat.official_account');
        $app = Factory::officialAccount($config);
        $oauth = $app->oauth;
        return $oauth->redirect();
    }

    public function check_user()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        if(empty($openid) || empty($user_id))
        {
            $url = url('wechat2/index/getOpenId');
            Header("Location: $url");
            exit();
        }

        $user_info = User::find($user_id);
        if(empty($user_info))
        {
            $url = url('wechat2/index/getOpenId');
            Header("Location: $url");
            exit();
        }

        if($user_info->id != $user_id)
        {
            $url = url('wechat2/index/getOpenId');
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

            return redirect()->route('wechat2.index.index');
        }
        else
        {
            $redirect_uri = urlencode(url('wechat2/index/getOpenId'));
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->wechat_appid."&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
            Header("Location: $url");
            exit();
        }
    }
}
