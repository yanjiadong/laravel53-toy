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

