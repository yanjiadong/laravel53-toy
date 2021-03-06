<?php

require_once(__DIR__ . '/lib/WxPayApi.php');
require_once(__DIR__ . '/lib/WxPay.Notify.php');
require_once(__DIR__ . '/log.php');

//初始化日志
$logHandler= new CLogFileHandler(public_path()."/logs/".date('Y-m-d').'.log');
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
            $out_trade_no = $result["out_trade_no"];
            $total_fee = $result["total_fee"];

            try {
                $money = $total_fee * 1.0 / 100;

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

