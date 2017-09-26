<?php

namespace App\Http\Controllers\Wechat;

use App\Cart;
use App\Order;
use App\User;
use App\VipCard;
use App\VipCardPay;
use App\WechatAccessToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends BaseController
{
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
                        'name'=>$info['nickname'],
                        'email'=>'',
                        'password'=>'',
                        'wechat_openid'=>$result['openid'],
                        'wechat_original'=>json_encode($info),
                        'wechat_nickname'=>$info['nickname'],
                        'wechat_avatar'=>$info['headimgurl'],
                    );

                    $success = User::create($data);
                    //echo $success->id;
                    //dd($success);
                    session(['user_id'=>$success->id]);

                    /*$to_url = url('wechat/index/index');
                    Header("Location: $to_url");
                    exit();*/
                }
                else
                {
                    session(['user_id'=>$info->id]);
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

    /**
     * 首页面
     */
    public function index()
    {
        session(['open_id'=>'o2xFAw7K6g1yHtZ-MvYFX2gYRzpI']);
        session(['user_id'=>3]);
        //$this->check_user();
        $openid = session('open_id');
        $user_id = session('user_id');
        $url = url('api/index');
        $result = weixinCurl($url);

        $menu = 'index';

        //计算玩具箱数量
        $cart_num = Cart::where('user_id',$user_id)->count();

        return view('wechat.index.index',compact('result','menu','user_id','cart_num'));
    }

    /**
     * 分类详情页
     */
    public function category(Request $request, $category_id, $brand_id)
    {
        //$url = url("api/category/$category_id/$brand_id");
        //$result = weixinCurl($url);
        //print_r($result);
        $user_id = session('user_id');
        $cart_num = Cart::where('user_id',$user_id)->count();
        $menu = 'index';
        return view('wechat.index.category',compact('category_id','brand_id','user_id','menu','cart_num'));
    }

    /**
     * 商品详情
     */
    public function good(Request $request, $good_id)
    {
        $user_id = session('user_id');

        //购物车数量
        $cart_num = Cart::where('user_id',$user_id)->count();
        return view('wechat.index.good',compact('good_id','user_id','cart_num'));
    }

    /**
     * 查看购物车
     */
    public function cart(Request $request)
    {
        $user_id = session('user_id');
        $menu = 'cart';
        //计算玩具箱数量
        $cart_num = Cart::where('user_id',$user_id)->count();

        return view('wechat.index.cart',compact('user_id','menu','cart_num'));
    }

    /**
     * 成为会员
     */
    public function choose_vip()
    {
        $this->check_user();
        $user_id = session('user_id');

        //获取剩余天数
        $days = VipCardPay::where('user_id',$user_id)->where('status',1)->where('pay_status',1)->sum('days');

        return view('wechat.index.choose_vip',compact('user_id','days'));
    }

    public function pay_vip_card($vip_card_id)
    {
        $user_id = session('user_id');
        $openid = session('open_id');
        $info = VipCard::find($vip_card_id);

        switch ($info->type)
        {
            case 1:
                $days = 30;
                break;
            case 2:
                $days = 90;
                break;
            case 3:
                $days = 180;
                break;
        }
        $out_trade_no = 'v'.get_order_code($user_id);
        $total_fee = 0.01;

        $data['user_id'] = $user_id;
        $data['price'] = $total_fee;
        $data['money'] = $info->money;
        $data['vip_card_id'] = $vip_card_id;
        $data['vip_card_type'] = $info->type;
        $data['pay_status'] = 0;
        $data['status'] = 1;
        $data['days'] = $days;
        $data['order_code'] = $out_trade_no;

        VipCardPay::create($data);

        $jsApiParameters = WxJsPay($out_trade_no, $total_fee, $openid);
        return view('wechat.index.pay_vip_card',compact('user_id','jsApiParameters','out_trade_no'));
    }

    /**
     * 支付订单
     * @param $order_code
     */
    public function pay_order($order_code)
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        $order = Order::where('code',$order_code)->first();

        $out_trade_no = $order->out_trade_no;
        $total_fee = 0.01;
        $jsApiParameters = WxJsPay($out_trade_no, $total_fee, $openid);
        return view('wechat.index.pay_order',compact('user_id','jsApiParameters','out_trade_no','order_code'));
    }

    public function pay_order_callback()
    {
        WxJsPayCallback();
    }

    public function pay_vip_card_callback()
    {
        WxJsPayCallback();
    }

    public function submit_order($good_id)
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        //判断是否绑定手机号
        $user_info = User::find($user_id);

        $bind_telephone = 0;
        if(!empty($user_info->telephone))
        {
            $bind_telephone = 1;
        }

        return view('wechat.index.submit_order',compact('user_id','openid','good_id','bind_telephone'));
    }

    public function order_list()
    {
        $user_id = session('user_id');
        $openid = session('open_id');
        $menu = 'order_list';

        //计算玩具箱数量
        $cart_num = Cart::where('user_id',$user_id)->count();

        return view('wechat.index.order_list',compact('user_id','openid','menu','cart_num'));
    }

    public function order_success($order_code)
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        $order = Order::where('code',$order_code)->first();
        return view('wechat.index.order_success',compact('user_id','openid','order_code','order'));
    }

    public function order_detail($order_code)
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        return view('wechat.index.order_detail',compact('user_id','openid','order_code'));
    }

    public function order_return_detail()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        return view('wechat.index.order_return_detail',compact('user_id','openid'));
    }

    public function fill_logistics()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        return view('wechat.index.fill_logistics',compact('user_id','openid','order_code'));
    }

    public function children_interesting_compilation()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        return view('wechat.index.children_interesting_compilation',compact('user_id','openid','order_code'));
    }


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
                "url":"http://toy.yanjiadong.net/wechat/index/index"
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
