<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin.order.index',compact('orders','username','menu'));
    }
}
