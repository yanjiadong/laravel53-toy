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

//主动去查询快递100物流信息
if(!function_exists('get_express_info'))
{
    function get_express_info($num, $com = 'shunfeng')
    {
        header('Content-Type: application/json');
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
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $data = str_replace("\&quot;",'"',$result );
        //$data = json_decode($data,true);
        return $data;
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
                if($order_info->money > 0)
                {
                    DB::table('user_pay_records')->insert(['user_id'=>$order_info->user_id,'type'=>1,'pay_type'=>1,'price'=>$order_info->money,'created_at'=>date('Y-m-d H:i:s')]);
                }


                //如果使用了优惠券
                if(isset($order_info->user_coupon_id) && $order_info->user_coupon_id > 0)
                {
                    DB::table('user_coupons')->where('id',$order_info->user_coupon_id)->update(['status'=>1]);
                    DB::table('user_choose_coupons')->where('user_id',$order_info->user_id)->delete();
                }

                if(!empty($user_info->telephone))
                {
                    sms_send('SMS_103895011',$user_info->telephone,$user_info->name);
                    //vip_card_pay_success_send_sms($user_info->telephone,$user_info->name);
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

            if(!empty($order_info->coupon_id))
            {
                DB::table('user_coupons')->where('user_id',$order_info->user_id)->where('coupon_id',$order_info->coupon_id)->update(['status'=>1]);
            }

            $user_info = DB::table('users')->where('id',$order_info->user_id)->first();
            if(!empty($user_info->telephone) && $order_info->price > 0)
            {
                sms_send('SMS_103795027',$user_info->telephone,$user_info->name);
                //order_pay_success_send_sms($user_info->telephone,$user_info->name);

                //短信通知后台管理员
                sms_send('SMS_109345328','13366556200');
                sms_send('SMS_109345328','15101016067');
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

/**
 * 阿里短信发送函数
 */
if(!function_exists('sms_send'))
{
    function sms_send($template,$telephone,$name = '',$code = '')
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
                    'access_key_id' => config('app.ali_sms_access_key_id'),
                    'access_key_secret' => config('app.ali_sms_access_key_secret'),
                    'sign_name' => '小Q编程',
                ],
            ],
        ];

        try {
            $easySms = new \Overtrue\EasySms\EasySms($config);

            $easySms->send($telephone, [
                'content'  => '您的验证码为: 6379',
                'template' => $template,
                'data' => [
                    'name'=>$name,
                    'number'=>$code
                ],
            ]);
        } catch (\Exception $e){

        }
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
        //$result = strip_tags($content, "<img><br><a>");
        $result = $content;
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

//第一步 芝麻认证查初始化
if(!function_exists('TestZhimaCustomerCertificationQuery'))
{
    function TestZhimaCustomerCertificationQuery($certName, $certNo)
    {
        include_once __DIR__."/zmop/ZmopClient.php";
        include_once __DIR__."/zmop/request/ZhimaCustomerCertificationInitializeRequest.php";

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

        $transaction_id = date('YmdHis').microtime_format('x', microtime_float()).time().mt_rand(0000,9999);

        $client = new ZmopClient($gatewayUrl,$appId,$charset,$privateKeyFile,$zmPublicKeyFile);
        $request = new ZhimaCustomerCertificationInitializeRequest();
        $request->setChannel("apppc");
        $request->setPlatform("zmop");
        $request->setTransactionId($transaction_id);// 必要参数
        $request->setProductCode("w1010100000000002978");// 必要参数
        $request->setBizCode("FACE");// 必要参数
        $request->setIdentityParam("{\"identity_type\": \"CERT_INFO\", \"cert_type\": \"IDENTITY_CARD\", \"cert_name\": \"{$certName}\", \"cert_no\":\"{$certNo}\"}");// 必要参数
        $request->setMerchantConfig("{\"need_user_authorization\":\"false\"}");//
        $request->setExtBizParam("{}");// 必要参数
        $response = $client->execute($request);
        return json_encode($response);
    }
}

//第二步 芝麻认证开始认证
if(!function_exists('TestZhimaCustomerCertificationCertify'))
{
    function TestZhimaCustomerCertificationCertify($bizNo, $redirect_url)
    {
        include_once __DIR__."/zmop/ZmopClient.php";
        include_once __DIR__."/zmop/request/ZhimaCustomerCertificationCertifyRequest.php";

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
        $request = new ZhimaCustomerCertificationCertifyRequest();
        $request->setChannel("apppc");
        $request->setPlatform("zmop");
        $request->setBizNo($bizNo);// 必要参数  一次认证的唯一标识，在完成芝麻认证初始化后可以获取
        $request->setReturnUrl($redirect_url);// 必要参数  商户回调地址，在用户完成认证后会调转回商户地址
        $url = $client->generatePageRedirectInvokeUrl($request);
        return $url;
    }
}


/*
 * 根据用户信息  获取授权页面
 */
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
        include_once __DIR__."/zmop/request/ZhimaCreditScoreGetRequest.php";

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

        $transaction_id = date('YmdHis').microtime_format('x', microtime_float()).time().mt_rand(0000,9999);

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

if(!function_exists('microtime_format'))
{
    function microtime_format($tag, $time)
    {
        list($usec, $sec) = explode(".", $time);
        $date = date($tag,$usec);
        return str_replace('x', $sec, $date);
    }
}

//根据芝麻分获取等级
/**
 * 350≤分数<550（信用较差）
    550≤分数<600（信用中等）
    600≤分数<650（信用良好）
    650≤分数<700（信用优秀）
    700≤分数<950（信用极好）
 */
if(!function_exists('get_level_by_score'))
{
    function get_level_by_score($score)
    {
        $str = '';
        if($score>=350 && $score<550)
        {
            $str = '信用较差';
        }
        elseif($score>=550 && $score<600)
        {
            $str = '信用中等';
        }
        elseif($score>=600 && $score<650)
        {
            $str = '信用良好';
        }
        elseif($score>=650 && $score<700)
        {
            $str = '信用优秀';
        }
        elseif($score>=700 && $score<950)
        {
            $str = '信用极好';
        }
        return $str;
    }
}

//计算租金公式
if(!function_exists('getGoodDayPrice'))
{
    function getGoodDayPrice($price, $days)
    {
        $day_price = 0;
        if($days>=7 && $days<=13)
        {
            $day_price = $price/(70+1*$days);
        }
        elseif($days>13 && $days<=20)
        {
            $day_price = $price/(75+1.2*$days);
        }
        elseif($days > 20 && $days <= 29)
        {
            $day_price = $price/(80+1.4*$days);
        }
        elseif($days>29 && $days<=44)
        {
            $day_price = $price/(95+2.0*$days);
        }
        elseif($days>44 && $days<=60)
        {
            $day_price = $price/(95+2.4*$days);
        }

        return number_format($day_price,1,".","");
    }
}

//根据商品租用天数来计算每日的租金
if(!function_exists('getGoodPriceByDays'))
{
    function getGoodPriceByDays($price, $days, $is_discount = 0, $good_id = 0)
    {
        if(!empty($is_discount))
        {
            $good = DB::table('goods')->where('id',$good_id)->first();
        }

        $result = 0;

        if($days >= 1 && $days <= 7)
        {
            if(!empty($good) && $is_discount)
            {
                $result = $good->discount1;
            }
        }
        elseif($days > 7 && $days <= 14)
        {
            if(!empty($good) && $is_discount)
            {
                $result = $good->discount2;
            }
        }
        elseif($days > 14 && $days <= 21)
        {
            if(!empty($good) && $is_discount)
            {
                $result = $good->discount3;
            }

        }
        elseif($days > 21 && $days <= 30)
        {
            if(!empty($good) && $is_discount)
            {
                $result = $good->discount4;
            }

        }
        elseif($days > 30 && $days <= 45)
        {
            if(!empty($good) && $is_discount)
            {
                $result = $good->discount5;
            }
        }
        elseif($days > 45 && $days <= 60)
        {
            if(!empty($good) && $is_discount)
            {
                $result = $good->discount6;
            }
        }

        if($result<=0)
        {
            $result = getGoodDayPrice($price,$days);
        }


        return number_format($result,1,".","");
    }
}

//根据商品租用天数来计算每日的租金以及是否是优惠价格
if(!function_exists('getGoodPriceInfo'))
{
    function getGoodPriceInfo($price, $days, $is_discount = 0, $good_id = 0)
    {
        if(!empty($is_discount))
        {
            $good = DB::table('goods')->where('id',$good_id)->first();
        }

        $result = 0;
        $isDiscount = false;

        if($days >= 1 && $days <= 7)
        {
            if(!empty($good) && $is_discount)
            {
                $isDiscount = true;
                if(getGoodDayPrice($good->price,7) == $good->discount1)
                {
                    $isDiscount = false;
                }
                $result = $good->discount1;
            }
        }
        elseif($days > 7 && $days <= 14)
        {
            if(!empty($good) && $is_discount)
            {
                $isDiscount = true;
                if(getGoodDayPrice($good->price,14) == $good->discount2)
                {
                    $isDiscount = false;
                }

                $result = $good->discount2;
            }
        }
        elseif($days > 14 && $days <= 21)
        {
            if(!empty($good) && $is_discount)
            {
                $isDiscount = true;
                if(getGoodDayPrice($good->price,21) == $good->discount3)
                {
                    $isDiscount = false;
                }

                $result = $good->discount3;
            }
        }
        elseif($days > 21 && $days <= 30)
        {
            if(!empty($good) && $is_discount)
            {
                $isDiscount = true;
                if(getGoodDayPrice($good->price,30) == $good->discount4)
                {
                    $isDiscount = false;
                }

                $result = $good->discount4;
            }
        }
        elseif($days > 30 && $days <= 45)
        {
            if(!empty($good) && $is_discount)
            {
                $isDiscount = true;
                if(getGoodDayPrice($good->price,45) == $good->discount5)
                {
                    $isDiscount = false;
                }
                $result = $good->discount5;
            }
        }
        elseif($days > 45 && $days <= 60)
        {
            if(!empty($good) && $is_discount)
            {
                $isDiscount = true;
                if(getGoodDayPrice($good->price,60) == $good->discount6)
                {
                    $isDiscount = false;
                }

                $result = $good->discount6;
            }
        }

        if($result<=0)
        {
            $result = getGoodDayPrice($price,$days);
        }


        return ['money'=>number_format($result,1,".",""),'isDiscount'=>$isDiscount];
    }
}

//根据芝麻分获取减免的押金额度
if(!function_exists('getMoneyByZhimaScore'))
{
    function getMoneyByZhimaScore($score)
    {
        $money = 0;
        if($score >= 650 && $score <= 670)
        {
            $money = 500;
        }
        elseif($score > 670 && $score <= 690)
        {
            $money = 700;
        }
        elseif($score > 690 && $score <= 700)
        {
            $money = 900;
        }
        elseif($score > 700 && $score <= 720)
        {
            $money = 1100;
        }
        elseif($score > 720 && $score <= 740)
        {
            $money = 1500;
        }
        elseif($score > 740 && $score <= 750)
        {
            $money = 1700;
        }
        elseif($score > 750 && $score <= 770)
        {
            $money = 1900;
        }
        elseif($score > 770 && $score <= 790)
        {
            $money = 2200;
        }
        elseif($score > 790 && $score <= 800)
        {
            $money = 2500;
        }
        elseif($score > 800)
        {
            $money = 3000;
        }

        return $money;
    }
}


//获取客服电话
if(!function_exists('get_tel'))
{
    function get_tel()
    {
        //客服电话
        $config = DB::table('system_configs')->where('type',1)->first();
        $content = json_decode($config->content,true);
        $phone = '';
        if(isset($content[7]))
        {
            $phone = $content[7];
        }
        return $phone;
    }
}










