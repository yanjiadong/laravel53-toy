<?php

namespace App\Http\Controllers\Admin;

use App\Express;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Overtrue\EasySms\EasySms;

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

        if(empty($status) && empty($code))
        {
            $orders = Order::with(['user'])->paginate(20);
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
            $orders = Order::with(['user'])->where($where)->paginate(20);
        }
        $menu = 'order';
        //print_r($orders);

        $express = Express::all();
        return view('admin.order.index',compact('orders','username','menu','express','status','code'));
    }

    public function send(Request $request)
    {
        $id = $request->get('id');
        $express_no = $request->get('express_no');
        $express_id = $request->get('express_id');

        $order = Order::find($id);
        $express = Express::find($express_id);

        $param = [
            'number'=>$express_no,
            'company'=>$express->com
        ];
        weixinCurl(url('api/express_info/index'),'post', $param);

        $this->send_sms($order->receiver_telephone,$order->receiver);
        Order::where('id',$id)->update(['status'=>Order::STATUS_SEND,'express_no'=>$express_no,'express_title'=>$express->title,'express_com'=>$express->com]);
        alert('',1);
    }

    /**
     * 发货短信通知
     * @param $telephone
     * @param $name
     */
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
            'template' => 'SMS_100765112',
            'data' => [
                'name' => $name
            ],
        ]);
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
        alert('',1);
    }

    public function show($id)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $order = Order::with(['user','category'])->find($id);

        $express = Express::all();

        $menu = 'order';
        return view('admin.order.show',compact('order','username','menu','express'));
    }
}
