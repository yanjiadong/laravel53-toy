<?php

namespace App\Http\Controllers\Wechat2;

use App\Cart;
use App\Coupon;
use App\Order;
use App\SystemConfig;
use App\User;
use App\UserChooseCoupon;
use App\UserCoupon;
use App\UserOpenTime;
use App\Utility\Wechat;
use App\VipCard;
use App\VipCardPay;
use App\WechatAccessToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\Factory;
use DB;
use Illuminate\Support\Facades\Cache;

class IndexController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 测试新版支付
     * @param Request $request
     */
    public function pay_test(Request $request)
    {
        $options = config('wechat.payment');
        $app = Factory::payment($options);

        $out_trade_no = 'T'.get_order_code(29);
        $result = $app->order->unify([
            'body' => '支付订单',
            'out_trade_no' => $out_trade_no,
            'total_fee' => 1,  //单位  分
            //'spbill_create_ip' => '123.12.12.123', // 可选，如不传该参数，SDK 将会自动获取相应 IP 地址
            //'notify_url' => 'https://pay.weixin.qq.com/wxpay/pay.action', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'trade_type' => 'JSAPI',
            'openid' => 'o2xFAw7K6g1yHtZ-MvYFX2gYRzpI',
        ]);

        if($result['result_code'] === 'SUCCESS')
        {
            $prepayId = $result['prepay_id'];
            $jssdk = $app->jssdk;
            $jsApiParameters = $jssdk->bridgeConfig($prepayId);
            return ['jsApiParameters'=>$jsApiParameters,'out_trade_no'=>$out_trade_no];
            //return view('wechat2.index.pay_test',compact('jsApiParameters','out_trade_no'));
        }
    }

    /**
     * 新版支付回调
     * @param Request $request
     */
    public function pay_notify(Request $request)
    {
        $options = config('wechat.payment');
        $app = Factory::payment($options);

        $response = $app->handlePaidNotify(function($message, $fail){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $out_trade_no = $message['out_trade_no'];

            $order = DB::table('orders')->where('out_trade_no',$out_trade_no)->first();

            if (!$order) { // 如果订单不存在
                $fail('Order not exist.'); // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }


            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->pay_success_time) { // 假设订单字段“支付时间”不为空代表已经支付
                return true; // 已经支付成功了就不再更新了
            }

            DB::table('pay_notifies')->insert([
                'out_trade_no'=>$out_trade_no,
                'result_code'=>$message['result_code'],
                'created_at'=>date('Y-m-d H:i:s')
            ]);

            // 用户是否支付成功
            if ($message['result_code'] === 'SUCCESS') {
                // 不是已经支付状态则修改为已经支付状态
                /*$order->paid_at = time(); // 更新支付时间为当前时间
                $order->status = 'paid';*/
                DB::table('orders')->where('out_trade_no',$out_trade_no)->update(['status'=>Order::STATUS_WAITING_SEND,'pay_success_time'=>date('Y-m-d H:i:s')]);

                if(!empty($order->coupon_id))
                {
                    DB::table('user_coupons')->where('user_id',$order->user_id)->where('id',$order->coupon_id)->update(['status'=>1]);
                }

                $user_info = DB::table('users')->where('id',$order->user_id)->first();
                if(!empty($user_info->telephone) && $order->price > 0)
                {
                    sms_send('SMS_119082485',$user_info->telephone,$user_info->name);

                    //短信通知后台管理员
                    sms_send('SMS_109345328','13366556200');
                    sms_send('SMS_109345328','15101016067');
                }

                //从玩具箱中去除
                DB::table('carts')->where(['user_id'=>$order->user_id,'good_id'=>$order->good_id])->delete();

                //去库存
                DB::table('goods')->where('id',$order->good_id)->decrement('store');

                //押金作为充值记录
                DB::table('user_pay_records')->insert(['user_id'=>$order->user_id,'type'=>1,'pay_type'=>1,'price'=>$order->money,'created_at'=>date('Y-m-d H:i:s')]);
            } else { // 用户支付失败
                //$order->status = 'paid_fail';
            }

            //$order->save(); // 保存订单

            return true; // 返回处理完成
        });

        return $response;
    }

    /**
     * 首页页面
     * time 2017-12-20
     */
    public function index()
    {

        if(config('app.env')=='local')
        {
            session(['open_id'=>'o2xFAw7K6g1yHtZ-MvYFX2gYRzpI']);
            session(['user_id'=>29]);
        }
        else
        {
            //$this->check_user();
            //采用easywechat扩展包 检查是否授权登录
            $this->check_oauth();
        }

        $openid = session('open_id');
        $user_id = session('user_id');

        $menu = 'index';

        //领取新人优惠券
        $coupon = UserCoupon::where('user_id',$user_id)->first();
        if(empty($coupon))
        {
            $coupon_info = Coupon::where('type',1)->get();
            if(count($coupon_info) > 0)
            {
                foreach ($coupon_info as $coupon)
                {
                    UserCoupon::create(['user_id'=>$user_id,'coupon_id'=>$coupon->id,'coupon_type'=>$coupon->type,'coupon_price'=>$coupon->price,'coupon_days'=>$coupon->days,'coupon_title'=>$coupon->title,'start_time'=>date('Y-m-d'),'condition'=>$coupon->condition,'end_time'=>date('Y-m-d',strtotime("+{$coupon->days} days"))]);
                }
            }
        }

        $user = User::find($user_id);
        $is_first = 0;
        if($user->open_num == 0)
        {
            $is_first = 1;
        }
        $open_num = $user->open_num + 1;

        User::where('id',$user_id)->update(['open_num'=>$open_num]);


        //首页打开时间
        UserOpenTime::create(['user_id'=>$user_id]);

        return view('wechat2.index.index',compact('menu','user_id','is_first'));
    }

    /**
     * 订单详情
     * @param $order_code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * time 2017-12-21
     */
    public function order_detail($order_code)
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        //客服电话
        $config = SystemConfig::where('type',1)->first();
        $content = json_decode($config->content,true);
        $phone = '';
        if(isset($content[7]))
        {
            $phone = $content[7];
        }

        return view('wechat2.index.order_detail',compact('user_id','openid','order_code','phone'));
    }

    /**
     *
     * @param Request $request
     * @param $category_id
     * @param $brand_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category(Request $request, $category_id, $brand_id)
    {
        $user_id = session('user_id');
        $menu = 'index';
        return view('wechat2.index.category',compact('category_id','brand_id','user_id','menu'));
    }

    /**
     * 商品详情
     * @param $good_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @time 2017-12-22
     */
    public function good($good_id)
    {
        $user_id = session('user_id');

        //购物车数量
        $cart_num = Cart::where('user_id',$user_id)->count();
        return view('wechat2.index.good',compact('good_id','user_id','cart_num'));
    }

    /**
     * 查看购物车
     * @time 2017-12-22
     */
    public function cart()
    {
        $user_id = session('user_id');
        $openid = session('open_id');
        $menu = 'cart';

        return view('wechat2.index.cart',compact('user_id','menu','openid'));
    }

    /**
     * 使用优惠券  废弃
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function choose_coupon()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        return view('wechat2.index.choose_coupon',compact('user_id'));
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
        //$total_fee = 0.01;
        $total_fee = $order->price;
        $jsApiParameters = WxJsPay($out_trade_no, $total_fee, $openid);
        return view('wechat.index.pay_order',compact('user_id','jsApiParameters','out_trade_no','order_code'));
    }

    /**
     * 提交订单页面
     * @param $good_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function submit_order($good_id)
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        //判断是否绑定手机号
        $user_info = User::find($user_id);

        $bind_telephone = 1;
        if(!empty($user_info->telephone))
        {
            $bind_telephone = 0;
        }

        return view('wechat2.index.submit_order',compact('user_id','openid','good_id','bind_telephone'));
    }

    /**
     * 订单列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function order_list()
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

        $user_id = session('user_id');
        $openid = session('open_id');
        $menu = 'order_list';

        return view('wechat2.index.order_list',compact('user_id','openid','menu','phone'));
    }

    public function pay_success($order_code)
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        $order = Order::where('code',$order_code)->first();
        return view('wechat2.index.pay_success',compact('user_id','openid','order_code','order'));
    }


    /**
     * 查看归还详情
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function order_return_detail()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        return view('wechat2.index.order_return_detail',compact('user_id','openid'));
    }

    public function fill_logistics()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        $signPackage = getJssdk();

        return view('wechat.index.fill_logistics',compact('user_id','openid','signPackage'));
    }

    /**
     * 提交归还物流信息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logistics_info()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        $signPackage = getJssdk();

        return view('wechat2.index.logistics_info',compact('user_id','openid','signPackage'));
    }

    /**
     * 提交归还物流成功页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logistics_info_return()
    {
        $user_id = session('user_id');
        $openid = session('open_id');
        return view('wechat2.index.logistics_info_return',compact('user_id','openid'));
    }

    public function children_interesting_compilation()
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        return view('wechat.index.children_interesting_compilation',compact('user_id','openid'));
    }

    /**
     * 查看物流信息
     * @param $order_code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logistics_detail($order_code)
    {
        $user_id = session('user_id');
        $openid = session('open_id');

        $order = Order::where('code',$order_code)->first();
        return view('wechat2.index.logistics_detail',compact('user_id','openid','order','order_code'));
    }

    public function test()
    {
        $config = config('wechat.official_account');
        $redis = new \Redis();
        $redis->connect(config('database.redis.default.host'));
        $redis->select(config('database.redis.default.database'));

        $cache = new Cache($redis);

        $app = Factory::officialAccount($config);
        $app['cache'] = $cache;

        $accessToken = $app->access_token;
        $token = $accessToken->getToken(true); // token 字符串
        dd($token);
        $info = SystemConfig::where('type',2)->first();

        $content = [];
        if(!empty($info->content))
        {
            $content = json_decode($info->content,true);
        }

        $auto_reply = isset($content[0])?$content[0]:'';
        echo $auto_reply;
        die;
        $order_data = [
            'user_id'=>29,
        ];
        $ret = Order::create($order_data);
        print_r($ret);
        //return view('wechat.index.test',compact('signPackage'));
    }
}
