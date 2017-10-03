<?php

namespace App\Http\Controllers\Wechat;

use App\Order;
use App\User;
use App\VipCardPay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Overtrue\EasySms\EasySms;

class CrontabController extends BaseController
{
    /**
     * 脚本 每天跑
     */
    public function index()
    {
        $this->process_order();
        $this->process_users();
    }

    /**
     * 根据订单计算使用的会员天数的
     */
    private function process_order()
    {
        $orders = Order::whereIn('status',[Order::STATUS_WAITING_SEND,Order::STATUS_SEND,Order::STATUS_DOING])->get()->toArray();
        if(!empty($orders))
        {
            foreach ($orders as $order)
            {
                $user_info = User::find($order['user_id']);

                $cards = VipCardPay::where('user_id',$order['user_id'])->where('pay_status',1)->where('status',1)->get()->toArray();
                if(!empty($cards))
                {
                    foreach ($cards as $card)
                    {
                        if($card['days']==1)
                        {
                            VipCardPay::where('id',$card['id'])->update(['days'=>0,'status'=>-1]);

                            $not_can_use_money = $user_info->not_can_use_money - $card['money'];
                            $can_use_money = $user_info->can_use_money + $card['money'];

                            $user_days = $user_info->days - 1;
                            User::where('id',$order['user_id'])->update(['not_can_use_money'=>$not_can_use_money,'can_use_money'=>$can_use_money,'days'=>$user_days]);
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
                if($days<=5)
                {
                    $this->send_sms($user->telephone,$user->name);
                }
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
                    'sign_name' => '玩具小叮当',
                ],
            ],
        ];

        $easySms = new EasySms($config);

        $easySms->send($telephone, [
            'content'  => '您的验证码为: 6379',
            'template' => 'SMS_85400005',
            'data' => [
                'name'=>$name
            ],
        ]);
    }
}
