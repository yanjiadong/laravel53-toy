<?php

namespace App\Http\Controllers\Wechat;

use App\Crontab;
use App\Express;
use App\ExpressInfo;
use App\Order;
use App\User;
use App\VipCard;
use App\VipCardPay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Overtrue\EasySms\EasySms;
use DB;
use App\Utility\JuheExp;

class CrontabController extends BaseController
{
    /**
     * 新版本的脚本
     */
    public function index()
    {
        $this->check_order_new();
        Crontab::create();
    }

    /*public function check_order_express()
    {
        $orders = Order::whereIn('status',[Order::STATUS_SEND])->get();
        if(count($orders) > 0)
        {
            foreach ($orders as $order)
            {
                $express = ExpressInfo::where('nu',$order->express_no)->where('type',1)->orderBy('id','desc')->first();
                if(empty($express) || $express->juhe_status == 0)
                {
                    $express_info = Express::where('title',$order->express_title)->first();
                    $express_com = $order->express_com;

                    if($express_info && $express_info->com != $order->express_com)
                    {
                        $express_com = $express_info->com;
                    }
                    //需要获取物流信息
                    $params = array(
                        'key' => '50699e84ef775876e51cf65f2dca7ebd', //您申请的快递appkey
                        'com' => $express_com, //快递公司编码，可以通过$exp->getComs()获取支持的公司列表
                        'no'  => $order->express_no //快递编号
                    );
                    $exp = new JuheExp($params['key']);
                    $result = $exp->query($params['com'],$params['no']); //执行查询

                    $juhe_content_list = '';
                    if(!empty($result['result']['list']))
                    {
                        $juhe_content_list = json_encode(array_reverse($result['result']['list']));
                    }

                    $juhe_status = isset($result['result']['status'])?$result['result']['status']:0;
                    ExpressInfo::create(['content'=>'','nu'=>$params['no'],'juhe_content_list'=>$juhe_content_list,'juhe_content'=>json_encode($result),'type'=>1,'juhe_status'=>$juhe_status]);
                }
            }
        }

        Crontab::create();
    }*/

    private function check_order_new()
    {
        //检查已发货的订单 变为确认收货
        $orders = Order::whereIn('status',[Order::STATUS_SEND])->get();
        if(count($orders) > 0)
        {
            foreach ($orders as $order)
            {
                $express = ExpressInfo::where('nu',$order->express_no)->where('type',0)->orderBy('id','desc')->first();

                if(isset($express->state) && $express->state==3)
                {
                    //已签收
                    if(!empty($express->content_list))
                    {
                        $logistics = json_decode($express->content_list,true);
                        $time = $logistics[0]['ftime'];  //签收时间
                        if( ($this->time - strtotime($time)) >= 3600)
                        {
                            $start_time = date('Y-m-d 00:00:01',$this->time);
                            $end_time = date('Y-m-d 23:59:59',strtotime("+{$order->days} days",$this->time));
                            Order::where('id',$order->id)->update(['status'=>Order::STATUS_DOING,'confirm_time'=>$this->datetime,'start_time'=>$start_time,'end_time'=>$end_time]);
                        }

                        /*if(isset($content['lastResult']['data']))
                        {
                            $logistics = $content['lastResult']['data'];
                            $time = $logistics[0]['ftime'];  //签收时间
                            if( ($this->time - strtotime($time)) >= 3600)
                            {
                                $start_time = date('Y-m-d 00:00:01',$this->time);
                                $end_time = date('Y-m-d 23:59:59',strtotime("+{$order->days} days",$this->time));
                                Order::where('id',$order->id)->update(['status'=>Order::STATUS_DOING,'confirm_time'=>$this->datetime,'start_time'=>$start_time,'end_time'=>$end_time]);
                            }
                        }*/
                    }
                }
                /*if(empty($express) || $express->juhe_status == 0)
                {
                    $express_info = Express::where('title',$order->express_title)->first();
                    $express_com = $order->express_com;

                    if($express_info && $express_info->com != $order->express_com)
                    {
                        $express_com = $express_info->com;
                    }
                    //需要获取物流信息
                    $params = array(
                        'key' => '50699e84ef775876e51cf65f2dca7ebd', //您申请的快递appkey
                        'com' => $express_com, //快递公司编码，可以通过$exp->getComs()获取支持的公司列表
                        'no'  => $order->express_no //快递编号
                    );
                    $exp = new JuheExp($params['key']);
                    $result = $exp->query($params['com'],$params['no']); //执行查询

                    $juhe_content_list = '';
                    if(!empty($result['result']['list']))
                    {
                        $juhe_content_list = json_encode(array_reverse($result['result']['list']));
                    }

                    $juhe_status = isset($result['result']['status'])?$result['result']['status']:0;
                    ExpressInfo::create(['content'=>'','nu'=>$params['no'],'juhe_content_list'=>$juhe_content_list,'juhe_content'=>json_encode($result),'type'=>1,'juhe_status'=>$juhe_status]);

                    if($result['result']['status'] == 1 && !empty($juhe_content_list))
                    {
                        //已签收
                        $last_info_array = json_decode($juhe_content_list,true);

                        $time = $last_info_array[0]['datetime'];
                        if( ($this->time - strtotime($time)) >= 3600)
                        {
                            $start_time = date('Y-m-d 00:00:01',$this->time);
                            $end_time = date('Y-m-d 23:59:59',strtotime("+{$order->days} days",$this->time));
                            Order::where('id',$order->id)->update(['status'=>Order::STATUS_DOING,'confirm_time'=>$this->datetime,'start_time'=>$start_time,'end_time'=>$end_time]);
                        }
                    }
                }
                else
                {
                    //已签收
                    $last_info_array = json_decode($express->juhe_content_list,true);

                    $time = $last_info_array[0]['datetime'];
                    if( ($this->time - strtotime($time)) >= 3600)
                    {
                        $start_time = date('Y-m-d 00:00:01',$this->time);
                        $end_time = date('Y-m-d 23:59:59',strtotime("+{$order->days} days",$this->time));
                        Order::where('id',$order->id)->update(['status'=>Order::STATUS_DOING,'confirm_time'=>$this->datetime,'start_time'=>$start_time,'end_time'=>$end_time]);
                    }
                }*/

            }
        }


        //检查租用中的订单是否有逾期
        /*$orders = Order::where('status',Order::STATUS_DOING)->get();
        //print_r($orders);
        if(count($orders) > 0)
        {
            foreach ($orders as $order)
            {
                $time = $this->time > strtotime($order->end_time);
                if($time > 0)
                {
                    //已经逾期
                    $over_days = ceil($time/86400);
                    DB::table('orders')->where('id',$order->id)->update(['over_days'=>$over_days]);
                }
            }
        }*/
    }

    /**
     * 检测租期还有一天到期
     */
    public function check_order()
    {
        $orders = Order::where('status',Order::STATUS_DOING)->get();
        if(count($orders) > 0)
        {
            foreach ($orders as $order)
            {
                if(!empty($order->end_time))
                {
                    $time = strtotime($order->end_time) - $this->time;
                    $day = floor($time/86400);
                    if($day == 1)
                    {
                        $user = User::select('telephone','name')->where('id',$order->user_id)->first();
                        if(!empty($user))
                        {
                            sms_send('SMS_120366315',$user->telephone,$user->name);
                        }
                    }
                }
            }
        }

        Crontab::create();
    }
}
