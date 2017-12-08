<?php

namespace App\Http\Controllers\Wechat;

use App\Crontab;
use App\ExpressInfo;
use App\Order;
use App\User;
use App\VipCard;
use App\VipCardPay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Overtrue\EasySms\EasySms;
use DB;

class CrontabController extends BaseController
{
    /**
     * 新版本的脚本
     */
    public function index2()
    {
        $this->check_order_new();
        Crontab::create();
    }

    private function check_order_new()
    {
        //检查已发货的订单 变为确认收货
        $orders = Order::whereIn('status',[Order::STATUS_SEND])->get();
        if(count($orders) > 0)
        {
            foreach ($orders as $order)
            {
                $express = ExpressInfo::where('nu',$order->express_no)->orderBy('id','desc')->first();
                if(isset($express->state) && $express->state==3)
                {
                    //已签收
                    if(isset($express->content) && !empty($express->content))
                    {
                        $content = json_decode($express->content,true);
                        if(isset($content['lastResult']['data']))
                        {
                            $logistics = $content['lastResult']['data'];
                            $time = $logistics[0]['time'];  //签收时间
                            if( ($this->time - strtotime($time)) >= 3600)
                            {
                                $end_time = date('Y-m-d H:i:s',strtotime("+{$order->days} days",$this->time));
                                Order::where('id',$order->id)->update(['status'=>Order::STATUS_DOING,'confirm_time'=>$this->datetime,'start_time'=>$this->datetime,'end_time'=>$end_time]);
                            }
                            //print_r($logistics);
                        }
                    }
                }

            }
        }


        //检查租用中的订单是否有逾期
        $orders = Order::where('status',Order::STATUS_DOING)->get();
        //print_r($orders);
        if(count($orders) > 0)
        {
            foreach ($orders as $order)
            {
                if($this->time > strtotime($order->end_time))
                {
                    //已经逾期
                    DB::table('orders')->where('id',$order->id)->increment('over_days');
                }
            }
        }
    }

    /**
     * 脚本 每天跑
     */
    public function index()
    {
        $this->process_order();
        $this->process_users();
        $this->check_order();

        Crontab::create();
    }

    /**
     * 物流已经签收的订单 签收24小时后自动变为确认收货
     */
    private function check_order()
    {
        $orders = Order::whereIn('status',[Order::STATUS_SEND])->get();
        if(count($orders) > 0)
        {
            foreach ($orders as $order)
            {
                $express = ExpressInfo::where('nu',$order->express_no)->orderBy('id','desc')->first();
                if(isset($express->state) && $express->state==3)
                {
                    //已签收
                    if(isset($express->content) && !empty($express->content))
                    {
                        $content = json_decode($express->content,true);
                        if(isset($content['lastResult']['data']))
                        {
                            $logistics = $content['lastResult']['data'];
                            $time = $logistics[0]['time'];  //签收时间
                            if( ($this->time - strtotime($time)) >= 3600)
                            {
                                Order::where('id',$order->id)->update(['status'=>Order::STATUS_DOING,'confirm_time'=>$this->datetime]);
                            }
                            //print_r($logistics);
                        }
                    }
                }

            }
        }

    }

    /**
     * 根据订单计算使用的会员天数的
     */
    private function process_order()
    {
        $orders = Order::whereIn('status',[Order::STATUS_DOING,Order::STATUS_SEND])->get()->toArray();
        if(!empty($orders))
        {
            foreach ($orders as $order)
            {
                $user_info = User::find($order['user_id']);

                $cards = VipCardPay::where('user_id',$order['user_id'])->where('pay_status',1)->where('status',1)->orderBy('id','asc')->get()->toArray();
                if(!empty($cards))
                {
                    foreach ($cards as $card)
                    {
                        if($card['days']==1)
                        {
                            VipCardPay::where('id',$card['id'])->update(['days'=>0,'status'=>-1]);


                            $card_count = VipCardPay::where('user_id',$order['user_id'])->where('status',1)->where('pay_status',1)->count();


                            if($card_count <= 0)
                            {
                                $update_data['is_vip'] = 0;
                            }

                            $update_data['not_can_use_money'] = $user_info->not_can_use_money - $card['money'];
                            $update_data['can_use_money'] = $user_info->can_use_money + $card['money'];

                            $update_data['days'] = $user_info->days - 1;


                            //User::where('id',$order['user_id'])->update(['not_can_use_money'=>$not_can_use_money,'can_use_money'=>$can_use_money,'days'=>$user_days]);
                            User::where('id',$order['user_id'])->update($update_data);
                        }
                        else
                        {
                            $days = $card['days'] - 1;
                            VipCardPay::where('id',$card['id'])->update(['days'=>$days]);

                            $user_days = $user_info->days - 1;
                            User::where('id',$order['user_id'])->update(['days'=>$user_days]);
                        }
                        break;
                    }
                }
                else
                {
                    if($user_info->is_vip == 1)
                    {
                        User::where('id',$order['user_id'])->update(['is_vip'=>0]);
                    }
                }

            }
        }
    }

    private function process_users()
    {
        $users = User::where('is_vip',1)->get();
        if(!empty($users))
        {
            foreach ($users as $user)
            {
                $days = VipCardPay::where('user_id',$user->id)->where('pay_status',1)->where('status',1)->sum('days');
                //print_r($days);
                if($days == 5)
                {
                    //print_r($days);
                    sms_send('SMS_109470324',$user->telephone,$user->name);
                    //$this->send_sms($user->telephone,$user->name);
                }
                User::where('id',$user->id)->update(['days'=>$days]);
            }
        }
    }

    private function send_sms($telephone,$name)
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

        $easySms = new EasySms($config);

        $easySms->send($telephone, [
            'content'  => '您的验证码为: 6379',
            'template' => 'SMS_109470324',
            'data' => [
                'name'=>$name
            ],
        ]);
    }
}
