<?php

namespace App\Http\Controllers\Wechat;

use App\Order;
use App\User;
use App\VipCardPay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CrontabController extends BaseController
{
    /**
     * 脚本 每天跑
     */
    public function index()
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

                            User::where('id',$order['user_id'])->update(['not_can_use_money'=>$not_can_use_money,'can_use_money'=>$can_use_money]);
                        }
                        else
                        {
                            $days = $card['days'] - 1;
                            VipCardPay::where('id',$card['id'])->update(['days'=>$days]);
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
}
