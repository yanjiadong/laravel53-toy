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
        $order_code = date('Ymd').mt_rand(1000000000,9999999999);
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
                if($user_info)
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
            if(!empty($user_info->telephone) && $order_info->price > 0)
            {
                order_pay_success_send_sms($user_info->telephone,$user_info->name);
            }

            $good = \App\Good::where(['id'=>$order_info->good_id])->first();

            //从玩具箱中去除
            \App\Cart::where(['user_id'=>$order_info->user_id,'good_id'=>$order_info->good_id])->delete();

            //扣除库存
            $store = $good->store - 1;
            if($store <=0 )
            {
                $store = 0;
            }
            \App\Good::where('id',$order_info->good_id)->update(['store'=>$store]);
        }
        //include_once __DIR__ . "/wx_js_pay/Notify.php";
        //$notify = new Notify();
        //$notify->Handle(false);
    }
}

if(!function_exists('order_pay_success_send_sms'))
{
    function order_pay_success_send_sms($telephone,$name)
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
                    'sign_name' => '玩玩具趣编程',
                ],
            ],
        ];

        $easySms = new \Overtrue\EasySms\EasySms($config);

        $easySms->send($telephone, [
            'content'  => '您的验证码为: 6379',
            'template' => 'SMS_103795027',
            'data' => [
                'name'=>$name
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
                    'sign_name' => '玩玩具趣编程',
                ],
            ],
        ];

        $easySms = new \Overtrue\EasySms\EasySms($config);

        $easySms->send($telephone, [
            'content'  => '您的验证码为: 6379',
            'template' => 'SMS_103895011',
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


if(!function_exists('filterEmoji'))
{
    // 过滤掉emoji表情
    function filterEmoji($str)
    {
        $str = preg_replace_callback(
            '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '?' : $match[0];
            },
            $str);

        return $str;
    }
}


if(!function_exists('filterHtmlTag'))
{
    function filterHtmlTag($content)
    {
        $result = strip_tags($content, "<img><br><a>");
        //$result = preg_replace('/<p[^>]*>/', "&nbsp;&nbsp;&nbsp;&nbsp;", $result);
        //$result = preg_replace('/<\/p[^>]*>/', "<br />", $result);
        //$result = preg_replace('/<\?p[^>]*>/', "", $result);

        $result = preg_replace('/><br><img/i', "><img", $result);
        $result = preg_replace("/style=\"[^\"]*width:\s*(\d+)px;[^\"]*\"/i", "", $result);
        $result = preg_replace("/style=\"width:(\d+)px;height:(\d+)px;\"/i", "", $result);
        $result = preg_replace("/style=\"width:\s*(\d+)px;\"/i", "", $result);
        $result = preg_replace("/width=\"(\d+)\" height=\"(\d+)\"/i", "", $result);
        $result = preg_replace("/height=\"(\d+)\" width=\"(\d+)\"/i", "", $result);

        return $result;
    }
}

if(!function_exists('TestZhimaAuthInfoAuthorize'))
{
    function TestZhimaAuthInfoAuthorize($name, $certNo)
    {
        include_once __DIR__."/zmop/ZmopClient.php";
        include_once __DIR__."/zmop/request/ZhimaAuthInfoAuthorizeRequest.php";
        //芝麻信用网关地址
        $gatewayUrl = "https://zmopenapi.zmxy.com.cn/openapi.do";
        //商户私钥文件
        $privateKeyFile = public_path()."/pem/rsa_private_key.pem";
        //芝麻公钥文件
        $zmPublicKeyFile = public_path()."/pem/public_key.pem";
        //数据编码格式
        $charset = "UTF-8";
        //芝麻分配给商户的 appId
        $appId = "300000622";

        $client = new ZmopClient($gatewayUrl,$appId,$charset,$privateKeyFile,$zmPublicKeyFile);
        $request = new ZhimaAuthInfoAuthorizeRequest();
        $request->setChannel("apppc");
        $request->setPlatform("zmop");
        $request->setIdentityType("2");// 必要参数
        $request->setIdentityParam("{\"name\":\"{$name}\",\"certType\":\"IDENTITY_CARD\",\"certNo\":\"{$certNo}\"}");// 必要参数
        $request->setBizParams("{\"auth_code\":\"M_H5\",\"channelType\":\"app\",\"state\":\"商户自定义\"}");//
        $url = $client->generatePageRedirectInvokeUrl($request);
        return $url;
    }
}

if(!function_exists('TestZhimaGetResult'))
{
    function TestZhimaGetResult($params, $sign)
    {
        include_once __DIR__."/zmop/ZmopClient.php";

        //芝麻信用网关地址
        $gatewayUrl = "https://zmopenapi.zmxy.com.cn/openapi.do";
        //商户私钥文件
        $privateKeyFile = public_path()."/pem/rsa_private_key.pem";
        //芝麻公钥文件
        $zmPublicKeyFile = public_path()."/pem/public_key.pem";
        //数据编码格式
        $charset = "UTF-8";
        //芝麻分配给商户的 appId
        $appId = "300000622";

        //$params = 'BFMqwAYz615BnJQIloDJw5h8mfLMTv%2FjvoitHU2PFu7E%2FdO1cTprm0jZ6N6V73BU9KIO5Lc43DrkyEJ9P7%2BDnjUfsFOfbIuV4rSL%2BMe8IEMHtGC3KR6lUn4PZ5qc3VDx5hgdc0D5sCy8v3KgYeEGuXNcNws7F2dL30ze45yps%2FkW1f%2BUbs%2BFcXMYpoZz1dfh7LF78NsjmD1d0D9doM9z8yydgPdZ%2F8kdszCKnLre0iuq%2Bv%2FBHHcDr0NyRvhJQotNJqm%2BA590wUfb%2BpcI168g81av5a9naQHech%2F1z5OF%2BjHADMw%2BSdR6jklASJTCPq0p8rHTLmH0QOnOm7G6ePrG9w%3D%3D';
        //从回调URL中获取params参数，此处为示例值
        //$sign = 'YKbTxhXrEE8VmD7cdpD9FK6Wd00WwkgLn9N2zppfukIOMzQfL4WRsKcCJgHe3YFJRZB%2FVV%2BqGk7chQF5PAaVr1iJyocxGC4cp4UB7HhDnEf01OxGLsjdtqA735Tze3dJv4qzcssBj1edSx1DWECJhthecKaevUxcf2%2BLoe0cRQI%3D';
        //从回调URL中获取sign参数，此处为示例值
        // 判断串中是否有%，有则需要decode
        $params = strstr ( $params, '%' ) ? urldecode ( $params ) : $params;
        $sign = strstr ( $sign, '%' ) ? urldecode ( $sign ) : $sign;

        $client = new ZmopClient ($gatewayUrl, $appId, $charset, $privateKeyFile, $zmPublicKeyFile);
        $result = $client->decryptAndVerifySign ( $params, $sign );
        return $result;
    }
}

if(!function_exists('TestZhimaCreditScoreGet'))
{
    function TestZhimaCreditScoreGet($open_id)
    {
        include_once __DIR__."/zmop/ZmopClient.php";

        //芝麻信用网关地址
        $gatewayUrl = "https://zmopenapi.zmxy.com.cn/openapi.do";
        //商户私钥文件
        $privateKeyFile = public_path()."/pem/rsa_private_key.pem";
        //芝麻公钥文件
        $zmPublicKeyFile = public_path()."/pem/public_key.pem";
        //数据编码格式
        $charset = "UTF-8";
        //芝麻分配给商户的 appId
        $appId = "300000622";

        $transaction_id = date('YmdHis').microtime_format('x', microtime_float()).time().mt_rand(0000,9999);;

        $client = new ZmopClient($gatewayUrl,$appId,$charset,$privateKeyFile,$zmPublicKeyFile);
        $request = new ZhimaCreditScoreGetRequest();
        $request->setChannel("apppc");
        $request->setPlatform("zmop");
        $request->setTransactionId($transaction_id);// 必要参数
        $request->setProductCode("w1010100100000000001");// 必要参数
        $request->setOpenId($open_id);// 必要参数
        $response = $client->execute($request);
        return json_encode($response);
    }
}

if(!function_exists('microtime_float'))
{
    function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
}

function microtime_format($tag, $time)
{
    list($usec, $sec) = explode(".", $time);
    $date = date($tag,$usec);
    return str_replace('x', $sec, $date);
}









