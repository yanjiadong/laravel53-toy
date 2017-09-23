<?php

require_once(__DIR__ . '/lib/WxPayApi.php');
require_once(__DIR__ . '/lib/WxPay.Notify.php');
require_once(__DIR__ . '/log.php');

//初始化日志
$logHandler= new CLogFileHandler(FCPATH."logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

class Notify extends WxPayNotify
{
    //查询订单
    public function Queryorder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
        Log::DEBUG("query:" . json_encode($result));
        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            $ci = &get_instance();
            $out_trade_no = $result["out_trade_no"];
            $total_fee = $result["total_fee"];

            try {
                $ci->base_model->wapPayProcess($out_trade_no, $total_fee * 1.0 / 100);
            } catch (Exception $e) {
            }

            return true;
        }
        return false;
    }

    //重写回调处理函数
    public function NotifyProcess($data, &$msg)
    {
        Log::DEBUG("call back:" . json_encode($data));
        $notfiyOutput = array();

        if(!array_key_exists("transaction_id", $data)){
            $msg = "输入参数不正确";
            return false;
        }
        //查询订单，判断订单真实性
        if(!$this->Queryorder($data["transaction_id"])){
            $msg = "订单查询失败";
            return false;
        }
        return true;
    }
}

Log::DEBUG("begin notify");

