<?php

namespace App\Http\Controllers\Admin;

use App\Express;
use App\Good;
use App\Order;
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

    public function index(Request $request)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $status = $request->get('status');
        $code = $request->get('code');
        $telephone = $request->get('telephone');

        if(empty($status) && empty($code) && empty($telephone))
        {
            $orders = Order::with(['user'])->where('status','!=','0')->orderBy('id','desc')->paginate(20);
        }
        else
        {
            if(!empty($status))
            {
                $where['status'] = $status;
            }
            if(!empty($code))
            {
                $where['code'] = $code;
            }
            if(!empty($telephone))
            {
                $where['user_telephone'] = $telephone;
            }
            $orders = Order::with(['user'])->where($where)->orderBy('id','desc')->paginate(20);
        }
        $menu = 'order';
        //print_r($orders);

        //分页需要的参数
        $orders->appends([
           'status'=>$status,
            'code'=>$code,
            'telephone'=>$telephone,
        ]);
        $express = Express::all();
        return view('admin.order.index',compact('orders','username','menu','express','status','code','telephone'));
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
            'number'=>$express_no,
            'company'=>$express->com
        ];
        weixinCurl(url('api/express_info/index'),'post', $param);

        if($type == 1)
        {
            sms_send('SMS_109405330',$order->receiver_telephone,$order->receiver);
            //$this->send_sms($order->receiver_telephone,$order->receiver);
            Order::where('id',$id)->update(['send_time'=>$this->datetime,'send_time2'=>$this->datetime,'status'=>Order::STATUS_SEND,'express_no'=>$express_no,'express_title'=>$express->title,'express_com'=>$express->com]);
        }
        else
        {
            Order::where('id',$id)->update(['send_time2'=>$send_time,'express_no'=>$express_no,'express_title'=>$express->title,'express_com'=>$express->com]);
        }


        alert('',1);
    }

    public function verify(Request $request)
    {
        $id = $request->get('id');
        $order = Order::find($id);

        if($order->back_status == '待验证' && $order->status == '已归还')
        {
            Order::where('id',$id)->update(['back_status'=>Order::BACK_STATUS_DOING]);
            alert('',1);
        }
        alert('验证寄回失败');
    }

    public function action(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');

        $order = Order::find($id);

        Order::where('id',$id)->update(['status'=>$status]);

        if($status == -1)
        {
            //返还库存
            DB::table('goods')->where('id',$order->good_id)->increment('store');
        }

        alert('',1);
    }

    public function show($id)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $order = Order::with(['user','category'])->find($id);

        $express = Express::all();

        $order->days = '';
        if($order->status==Order::STATUS_BACK_STR)
        {
            $order->days = floor((strtotime($order->back_time) - strtotime($order->send_time))/86400);
        }
        elseif($order->status==Order::STATUS_DOING_STR)
        {
            $order->days = floor((time()- strtotime($order->send_time))/86400);
        }

        $menu = 'order';
        return view('admin.order.show',compact('order','username','menu','express'));
    }
}
