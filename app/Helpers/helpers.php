<?php
if(!function_exists('alert'))
{
    function alert($params, $status = 0)
    {
        if($status)
        {
            if (is_array($params))
            {
                $params['success'] = 1;
                $data = $params;
            }
            elseif ($params)
            {
                $data = array('success' => 1, 'url' => $params);
            }
            else
            {
                $data = array('success' => 1);
            }
        }
        else
        {
            if(is_array($params))
            {
                $data = array('success' => 0);
            }
            else
            {
                $data = array('success' => 0, 'message' => $params);
            }
        }

        echo json_encode($data);
        exit;
        //return response()->json($data);
    }
}

if(!function_exists('isMobile'))
{
    function isMobile($telephone)
    {
        $pattern = "/^[0-9]{11,12}$/";

        if (!empty($telephone) && preg_match($pattern, $telephone))
        {
            return true;
        }
        return false;
    }
}

if(!function_exists('get_express_info'))
{
    function get_express_info($com, $num)
    {
        $post_data = array();
        $post_data["customer"] = '564B05790C18B954AC4D4198B54B4948';
        $key= 'dLSbEmyh1644' ;
        $param['com'] = $com;
        $param['num'] = $num;

        $post_data["param"] = json_encode($param);

        $url='http://poll.kuaidi100.com/poll/query.do';
        $post_data["sign"] = md5($post_data["param"].$key.$post_data["customer"]);
        $post_data["sign"] = strtoupper($post_data["sign"]);

        $o="";
        foreach ($post_data as $k=>$v)
        {
            $o.= "$k=".urlencode($v)."&";		//默认UTF-8编码格式
        }
        $post_data=substr($o,0,-1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $result = curl_exec($ch);
        $data = str_replace("\&quot;",'"',$result );
        $data = json_decode($data,true);
        //return $data;
    }
}

if(!function_exists('get_order_code'))
{
    function get_order_code($user_id = 0)
    {
        $order_code = date('YmdHis').$user_id.mt_rand(100000,999999);
        return $order_code;
    }
}

if(!function_exists('weixinCurl'))
{
    function weixinCurl($url, $type = 'GET', $param = array())
    {
        $type = strtoupper($type);

        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        if(!empty($param) && $type == 'POST')
        {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        }
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, $type);
        $result = curl_exec($ch);
        //print_r($result);
        if ($ch != null) curl_close($ch);

        $result = json_decode($result,true);
        return $result;
    }
}

if(!function_exists('WxJsPay'))
{
    function WxJsPay($out_trade_no, $total_fee, $openid)
    {
        header("content-type:text/html;charset=utf-8");
        $total_fee = doubleval($total_fee*100);

        include_once __DIR__ . "/wx_js_pay/JsApiPay.php";
        include_once __DIR__ . "/wx_js_pay/log.php";
        include_once __DIR__ . "/wx_js_pay/lib/WxPayApi.php";

        //初始化日志
        //$logHandler= new CLogFileHandler("/logs/".date('Y-m-d').'.log');
        //$log = Log::Init($logHandler, 15);


        $input = new WxPayUnifiedOrder();

        //①、获取用户openid
        $tools = new JsApiPay();
        //$openId = $tools->GetOpenid();

        //echo $openId;
        //②、统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody("订单支付".$out_trade_no);
        //$input->SetAttach("test");
        $input->SetOut_trade_no($out_trade_no);
        $input->SetTotal_fee($total_fee);
        //$input->SetTime_start(date("YmdHis"));
        //$input->SetTime_expire(date("YmdHis", time() + 600));
        //$input->SetGoods_tag("test");
        $input->SetNotify_url(url('wechat/index/pay_vip_card_callback'));
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openid);
        //Log::DEBUG("openid:" . $openId);
        $order = WxPayApi::unifiedOrder($input);
//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
        //print_r($order);
        //Log::DEBUG("apiorder:" . implode(' ',$order));
        $jsApiParameters = $tools->GetJsApiParameters($order);

        //Log::DEBUG("apiparam:" . $jsApiParameters);
        return $jsApiParameters;
    }
}

if(!function_exists('WxJsPayCallback'))
{
    function WxJsPayCallback($out_trade_no)
    {
        $type = substr($out_trade_no, 0, 1);
        if($type == 'v')
        {
            //会员支付
            $order_info = DB::table('vip_card_pays')->where('order_code',$out_trade_no)->first();
            if($order_info)
            {
                DB::table('vip_card_pays')->where('order_code',$out_trade_no)->update(['pay_status'=>1]);

                $user_info = DB::table('users')->where('id',$order_info->user_id)->first();
                if($user_info && $user_info->is_vip==0)
                {
                    $not_can_use_money = $user_info->not_can_use_money + $order_info->money;
                    $days = $user_info->days + $order_info->days;
                    DB::table('users')->where('id',$order_info->user_id)->update(['is_vip'=>1,'not_can_use_money'=>$not_can_use_money,'days'=>$days]);
                }

                //押金明细
                DB::table('user_pay_records')->insert(['user_id'=>$order_info->user_id,'type'=>1,'pay_type'=>1,'price'=>$order_info->money,'created_at'=>date('Y-m-d H:i:s')]);

                //如果使用了优惠券
                if(isset($order_info->user_coupon_id) && $order_info->user_coupon_id > 0)
                {
                    DB::table('user_coupons')->where('id',$order_info->user_coupon_id)->update(['status'=>1]);
                    DB::table('user_choose_coupons')->where('user_id',$order_info->user_id)->delete();
                }

                if(!empty($user_info->telephone))
                {
                    vip_card_pay_success_send_sms($user_info->telephone,$user_info->name);
                }
            }
        }
        elseif($type == 'p')
        {
            $order_info = DB::table('orders')->where('out_trade_no',$out_trade_no)->first();
            if($order_info)
            {
                DB::table('orders')->where('out_trade_no',$out_trade_no)->update(['status'=>\App\Order::STATUS_WAITING_SEND,'pay_success_time'=>date('Y-m-d H:i:s')]);
            }

            $user_info = DB::table('users')->where('id',$order_info->user_id)->first();
            if(!empty($user_info->telephone))
            {
                order_pay_success_send_sms($user_info->telephone);
            }
        }
        //include_once __DIR__ . "/wx_js_pay/Notify.php";
        //$notify = new Notify();
        //$notify->Handle(false);
    }
}

if(!function_exists('order_pay_success_send_sms'))
{
    function order_pay_success_send_sms($telephone)
    {
        $config = [
            // HTTP 请求的超时时间（秒）
            'timeout' => 5.0,

            // 默认发送配置
            'default' => [
                // 网关调用策略，默认：顺序调用
                'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

                // 默认可用的发送网关
                'gateways' => [
                    'aliyun'
                ],
            ],
            // 可用的网关配置
            'gateways' => [
                'errorlog' => [
                    'file' => '/tmp/easy-sms.log',
                ],
                'aliyun' => [
                    'access_key_id' => 'jlU7IQOybzkAXInb',
                    'access_key_secret' => 'LaYx00JdDHeXFPAE3Qz1MlDvjXIc1m',
                    'sign_name' => '玩具小叮当',
                ],
            ],
        ];

        $easySms = new \Overtrue\EasySms\EasySms($config);

        $easySms->send($telephone, [
            'content'  => '您的验证码为: 6379',
            'template' => 'SMS_85355007',
            'data' => [

            ],
        ]);
    }
}

if(!function_exists('vip_card_pay_success_send_sms'))
{
    function vip_card_pay_success_send_sms($telephone,$name)
    {
        $config = [
            // HTTP 请求的超时时间（秒）
            'timeout' => 5.0,

            // 默认发送配置
            'default' => [
                // 网关调用策略，默认：顺序调用
                'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

                // 默认可用的发送网关
                'gateways' => [
                    'aliyun'
                ],
            ],
            // 可用的网关配置
            'gateways' => [
                'errorlog' => [
                    'file' => '/tmp/easy-sms.log',
                ],
                'aliyun' => [
                    'access_key_id' => 'jlU7IQOybzkAXInb',
                    'access_key_secret' => 'LaYx00JdDHeXFPAE3Qz1MlDvjXIc1m',
                    'sign_name' => '玩具小叮当',
                ],
            ],
        ];

        $easySms = new \Overtrue\EasySms\EasySms($config);

        $easySms->send($telephone, [
            'content'  => '您的验证码为: 6379',
            'template' => 'SMS_85355004',
            'data' => [
                'name'=>$name
            ],
        ]);
    }
}

if(!function_exists('getJssdk'))
{
    function getJssdk()
    {
        include_once __DIR__ . "/Jssdk.php";
        $sdk = new Jssdk();
        return $sdk->getSignPackage();
    }
}



