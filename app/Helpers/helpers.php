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
    function WxJsPay($out_trade_no, $total_fee)
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
        $openId = $tools->GetOpenid();

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
        $input->SetOpenid($openId);
        //Log::DEBUG("openid:" . $openId);
        $order = WxPayApi::unifiedOrder($input);
//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
        //print_r($order);
        Log::DEBUG("apiorder:" . implode(' ',$order));
        $jsApiParameters = $tools->GetJsApiParameters($order);

        Log::DEBUG("apiparam:" . $jsApiParameters);
        return $jsApiParameters;
    }
}


