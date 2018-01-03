<?php

namespace App\Http\Controllers\Admin;

use App\Express;
use App\Good;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Overtrue\EasySms\EasySms;
use DB;

class OrderController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 押金列表
     * @param Request $request
     */
    public function money(Request $request)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $code = $request->get('code');
        $status = $request->get('status');


        //$where['back_status'] = 1;

        if (empty($code) && empty($status)) {
            $where[] = ['status','>',Order::STATUS_UNPAY];
            $orders = Order::with(['user'])->where($where)->paginate(20);
        } else {
            if (!empty($code)) {
                $where['out_trade_no'] = $code;
            }
            if(!empty($status))
            {
                switch ($status)
                {
                    case 1:
                        //不可提现
                        $where[] = ['status','<',Order::STATUS_BACK];
                        $where[] = ['status','>',Order::STATUS_UNPAY];
                        break;
                    case 2:
                        //可提现
                        $where['back_status'] = Order::BACK_STATUS_DOING;
                        $where['status'] = Order::STATUS_BACK;
                        $where['money_status'] = Order::MONEY_STATUS_UN;
                        break;
                    case 3:
                        //已申请提现
                        $where['back_status'] = Order::BACK_STATUS_DOING;
                        $where['status'] = Order::STATUS_BACK;
                        $where['money_status'] = Order::MONEY_STATUS_ING;
                        break;
                    case 4:
                        //提现成功
                        $where['back_status'] = Order::BACK_STATUS_DOING;
                        $where['status'] = Order::STATUS_BACK;
                        $where['money_status'] = Order::MONEY_STATUS_DONE;
                        break;
                }
            }

            $orders = Order::with(['user'])->where($where)->paginate(20);
        }
        $menu = 'order';

        //分页需要的参数
        $orders->appends([
            'code' => $code,
            'status' => $status
        ]);
        return view('admin.order.money', compact('orders', 'username', 'menu', 'code', 'status'));
    }

    /**
     * 押金申请操作
     * @param Request $request
     */
    public function confirm_money(Request $request)
    {
        $id = $request->get('id');

        $order = Order::select('user_id')->where('id',$id)->first();

        Order::where('id', $id)->update(['money_status' => Order::MONEY_STATUS_DONE]);

        $user = User::select('telephone','name')->where('id',$order->user_id)->first();
        sms_send('SMS_119092355',$user->telephone,$user->name);
        alert('', 1);
    }

    public function remark(Request $request)
    {
        $id = $request->get('id');
        $remark = $request->get('remark');
        Order::where('id', $id)->update(['remark' => $remark]);
        alert('', 1);
    }

    public function index(Request $request)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $status = $request->get('status');
        $code = $request->get('code');
        $telephone = $request->get('telephone');

        if (empty($status) && empty($code) && empty($telephone)) {
            $orders = Order::with(['user'])->where('status', '!=', '0')->orderBy('id', 'desc')->paginate(20);
        } else {
            if (!empty($status)) {
                if ($status == 5) {
                    $where['status'] = Order::STATUS_BACK;
                    $where['back_status'] = Order::BACK_STATUS_DOING;
                } elseif ($status == 4) {
                    $where['status'] = Order::STATUS_BACK;;
                    $where['back_status'] = Order::BACK_STATUS_WAITING;
                } else {
                    $where['status'] = $status;
                }
            }
            if (!empty($code)) {
                $where['code'] = $code;
            }
            if (!empty($telephone)) {
                $where['user_telephone'] = $telephone;
            }
            $orders = Order::with(['user'])->where($where)->orderBy('id', 'desc')->paginate(20);
        }
        if($status == 3)
        {
            if(count($orders) > 0)
            {
                foreach ($orders as $order)
                {
                    $order->over_days = 0;  //逾期天数
                    $order->days2 = 0;  //还剩多少天
                    $time = $this->time - strtotime($order->end_time);
                    if($time > 0)
                    {
                        $order->over_days = ceil($time/86400);

                    }
                    else
                    {
                        $order->days2 = floor((strtotime($order->end_time) - $this->time)/86400);
                    }
                }
            }
        }
        $menu = 'order';
        //print_r($orders);

        //分页需要的参数
        $orders->appends([
            'status' => $status,
            'code' => $code,
            'telephone' => $telephone,
        ]);
        $express = Express::all();
        return view('admin.order.index', compact('orders', 'username', 'menu', 'express', 'status', 'code', 'telephone'));
    }

    public function send(Request $request)
    {
        $id = $request->get('id');
        $express_no = $request->get('express_no');
        $express_id = $request->get('express_id');
        $send_time = $request->get('send_time');
        $type = $request->get('type');

        $order = Order::find($id);
        $express = Express::find($express_id);

        $param = [
            'number' => $express_no,
            'company' => $express->com
        ];
        $result = weixinCurl(url('api/express_info/index'), 'post', $param);
        //var_dump($result);
        if ($type == 1) {
            sms_send('SMS_119077480', $order->receiver_telephone, $order->receiver);
            //$this->send_sms($order->receiver_telephone,$order->receiver);
            Order::where('id', $id)->update(['send_time' => $this->datetime, 'send_time2' => $this->datetime, 'status' => Order::STATUS_SEND, 'express_no' => $express_no, 'express_title' => $express->title, 'express_com' => $express->com]);
        } else {
            Order::where('id', $id)->update(['send_time2' => $send_time, 'express_no' => $express_no, 'express_title' => $express->title, 'express_com' => $express->com]);
        }


        alert('', 1);
    }

    public function verify(Request $request)
    {
        $id = $request->get('id');
        $order = Order::find($id);

        if ($order->back_status == '待验证' && $order->status == '已归还') {
            Order::where('id', $id)->update(['back_status' => Order::BACK_STATUS_DOING]);

            $user = User::select('telephone','name')->where('id',$order->user_id)->first();
            sms_send('SMS_119087517',$user->telephone,$user->name);
            alert('', 1);
        }
        alert('验证寄回失败');
    }

    public function confirm(Request $request)
    {
        $id = $request->get('id');
        $order = Order::find($id);

        $start_time = date('Y-m-d 00:00:01',$this->time);
        $end_time = date('Y-m-d 23:59:59',strtotime("+{$order->days} days",$this->time));

        $ret = Order::where('id',$id)->update(['status'=>Order::STATUS_DOING,'confirm_time'=>$this->datetime,'start_time'=>$start_time,'end_time'=>$end_time]);
        alert('', 1);
    }

    public function action(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');

        $order = Order::find($id);

        Order::where('id', $id)->update(['status' => $status]);

        if ($status == -1) {
            //返还库存
            DB::table('goods')->where('id', $order->good_id)->increment('store');
        }

        alert('', 1);
    }

    public function show($id)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $order = Order::with(['user', 'category'])->find($id);

        $express = Express::all();

        $menu = 'order';
        return view('admin.order.show', compact('order', 'username', 'menu', 'express'));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        $start_time = $request->get('start_time');
        $end_time = $request->get('end_time');

        //$order = Order::find($id);
        $start_time = date('Y-m-d 00:00:01',strtotime($start_time));
        $end_time = date('Y-m-d 23:59:59',strtotime($end_time));

        Order::where('id', $id)->update(['start_time' => $start_time,'end_time'=>$end_time]);
        alert('', 1);
    }
}
