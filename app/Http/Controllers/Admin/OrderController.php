<?php

namespace App\Http\Controllers\Admin;

use App\Express;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $orders = Order::with(['user'])->paginate(5);
        $menu = 'order';
        //print_r($orders);

        $express = Express::all();
        return view('admin.order.index',compact('orders','username','menu','express'));
    }

    public function send(Request $request)
    {
        $id = $request->get('id');
        $express_no = $request->get('express_no');
        $express_id = $request->get('express_id');

        $express = Express::find($express_id);

        Order::where('id',$id)->update(['status'=>Order::STATUS_SEND,'express_no'=>$express_no,'express_title'=>$express->title,'express_com'=>$express->com]);
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

    public function show($id)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $order = Order::with(['user','category_tag','category'])->find($id);
        $menu = 'order';
        return view('admin.order.show',compact('order','username','menu'));
    }
}
