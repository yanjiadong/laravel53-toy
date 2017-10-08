<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Express;
use App\ExpressInfo;
use App\Good;
use App\Order;
use App\SystemConfig;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Overtrue\EasySms\EasySms;

class OrderController extends BaseController
{
    public function add_order(Request $request)
    {
        $good_id = $request->get('good_id');
        $user_id = $request->get('user_id');

        //判断是否租用中的玩具
        $order = Order::whereIn('status',[Order::STATUS_WAITING_SEND,Order::STATUS_SEND,Order::STATUS_DOING])->where('user_id',$user_id)->get()->toArray();
        //print_r($order);
        if(count($order) > 0)
        {
            $this->ret['code'] = 300;
            $this->ret['msg'] = '当前账户已有正在租用物品,归还后才能再次下单';
            return $this->ret;
        }

        $good = Good::with(['category_tag','brand'])->find($good_id);

        $info['good_title'] = $good->title;
        $info['good_picture'] = $good->picture;
        $info['good_price'] = $good->price;
        $info['good_brand'] = $good->brand->title;
        //$info['good_category_tag'] = $good->category_tag->title;

        //计算邮费
        $config = SystemConfig::where('type',1)->first();
        $num = 0;
        $price = 0;

        if(!empty($config->content))
        {
            $config_array = json_decode($config->content,true);
            $num = isset($config_array[0])?$config_array[0]:0;
            $price = isset($config_array[1])?$config_array[1]:0;
        }

        $count = Order::where('month',date('Y-m'))->count();
        if($count < $num)
        {
            //免邮
            $express_price = 0;
        }
        else
        {
            $express_price = $price;
        }


        $result['good'] = $info;
        $result['express_price'] = $express_price;
        $result['clean_price'] = 0.00;
        $result['money'] = 0.00;
        $result['price'] = $result['express_price']+$result['clean_price']+$result['money'];
        $this->ret['info'] = $result;
        return $this->ret;
    }

    public function submit_order(Request $request)
    {
        $good_id = $request->get('good_id');
        $user_id = $request->get('user_id');
        $express_price = $request->get('express_price');
        $clean_price = $request->get('clean_price');
        $price = $request->get('price');
        $money = $request->get('money');
        $address_id = $request->get('address_id');
        $receiver = $request->get('receiver');
        $receiver_telephone = $request->get('receiver_telephone');
        $receiver_address = $request->get('receiver_address');
        $receiver_province = $request->get('receiver_province');
        $receiver_city = $request->get('receiver_city');
        $receiver_area = $request->get('receiver_area');



        $user = User::find($user_id);
        if(empty($user->telephone))
        {
            $this->ret['code'] = 300;
            $this->ret['msg'] = '当前账户尚未绑定手机号,请先绑定手机号';
            return $this->ret;
        }

        $good = $good = Good::with(['category_tag','category','brand'])->where(['id'=>$good_id,'status'=>Good::STATUS_ON_SALE])->first();
        if(empty($good->id))
        {
            $this->ret['code'] = 300;
            $this->ret['msg'] = '玩具不存在';
            return $this->ret;
        }

        //如果有租用中的订单 那就无法重复下单
        //判断是否租用中的玩具
        $orders = Order::whereIn('status',[Order::STATUS_WAITING_SEND,Order::STATUS_SEND,Order::STATUS_DOING])->where('user_id',$user_id)->get()->toArray();
        //print_r($order);
        if(count($orders) > 0)
        {
            $this->ret['code'] = 300;
            $this->ret['msg'] = '当前账户已有正在租用物品,归还后才能再次下单';
            return $this->ret;
        }

        $order_data['code'] = get_order_code($user_id);
        $order_data['user_id'] = $user_id;
        $order_data['good_id'] = $good_id;
        $order_data['good_title'] = $good->title;
        $order_data['good_picture'] = $good->picture;
        $order_data['good_price'] = $good->price;
        $order_data['category_id'] = $good->category_id;
        $order_data['category_tag_id'] = $good->category_tag_id;
        $order_data['good_brand_id'] = $good->brand_id;
        $order_data['good_old'] = $good->old;
        $order_data['express_price'] = $express_price;
        $order_data['clean_price'] = $clean_price;
        $order_data['price'] = $price;
        $order_data['money'] = $money;
        $order_data['address_id'] = $address_id;
        $order_data['receiver'] = $receiver;
        $order_data['receiver_telephone'] = $receiver_telephone;
        $order_data['receiver_address'] = $receiver_address;
        $order_data['receiver_province'] = $receiver_province;
        $order_data['receiver_city'] = $receiver_city;
        $order_data['receiver_area'] = $receiver_area;
        $order_data['out_trade_no'] = 'p'.$order_data['code'];

        if($order_data['price']<=0)
        {
            $order_data['status'] = Order::STATUS_WAITING_SEND;
            $order_data['pay_success_time'] = $this->datetime;
        }
        Order::create($order_data);

        //从玩具箱中去除
        Cart::where(['user_id'=>$user_id,'good_id'=>$good_id])->delete();

        $this->ret['info'] = ['order_code'=>$order_data['code']];
        return $this->ret;
    }

    public function order_list(Request $request)
    {
        $user_id = $request->get('user_id');
        $page = $request->get('page')?$request->get('page'):1;
        $limit = $request->get('limit')?$request->get('limit'):10;
        $type = $request->get('type')?$request->get('type'):1;  //1进行中的  2已归还的

        $offset = ($page-1)*$limit;

        if($type == 1)
        {
            $where = [Order::STATUS_WAITING_SEND,Order::STATUS_SEND,Order::STATUS_DOING];
        }
        else
        {
            $where = [Order::STATUS_BACK];
        }

        //$list = Order::with(['user','category','good_brand'])->skip($offset)->take($limit)->whereIn('status',$where)->get()->toArray();
        $list = Order::with(['user','category','good_brand'])->whereIn('status',$where)->where('user_id',$user_id)->get()->toArray();
        //print_r($list);
        if(!empty($list))
        {
            foreach ($list as &$v)
            {
                $v['days'] = 0;
                if($v['status']==Order::STATUS_BACK)
                {
                    $v['days'] = ceil((strtotime($v['back_time']) - strtotime($v['confirm_time']))/(3600*24));
                }
                elseif($v['status']==Order::STATUS_DOING)
                {
                    $v['days'] = ceil((time()- strtotime($v['confirm_time']))/(3600*24));
                }
            }
        }

        $this->ret['info'] = ['list'=>$list];
        return $this->ret;
    }

    public function order_info(Request $request)
    {
        $code = $request->get('code');
        $info = Order::with(['user','category','good_brand'])->where('code',$code)->first();

        $express_info = ExpressInfo::where('nu',$info->express_no)->orderBy('id','desc')->first();

        $logistics = array('time'=>'','context'=>'暂无物流信息');
        if(isset($express_info->content) && !empty($express_info->content))
        {
            $content = json_decode($express_info->content,true);
            if(isset($content['lastResult']['data'][0]))
            {
                $logistics = $content['lastResult']['data'][0];
                //print_r($logistics);
            }
            //print_r($content);
        }

        $this->ret['info'] = ['logistics'=>$logistics,'order'=>$info];
        return $this->ret;
    }

    public function logistics_detail(Request $request)
    {
        $nu = $request->get('nu');

        $express_info = ExpressInfo::where('nu',$nu)->orderBy('id','desc')->first();

        $logistics = array();
        if(isset($express_info->content) && !empty($express_info->content))
        {
            $content = json_decode($express_info->content,true);
            if(isset($content['lastResult']['data']))
            {
                $logistics = $content['lastResult']['data'];
                //print_r($logistics);
            }
            //print_r($content);
        }

        $this->ret['info'] = ['logistics'=>$logistics];
        return $this->ret;
    }

    public function order_can_back(Request $request)
    {
        $user_id = $request->get('user_id');

        $config = SystemConfig::where('type',1)->first();
        $content = json_decode($config->content,true);
        //print_r($content);
        $info['tip'] = $content[5];
        $info['address'] = $content[4];
        $info['telephone'] = $content[3];
        $info['name'] = $content[2];

        $where = [Order::STATUS_DOING];
        $list = Order::with(['user','category','good_brand'])->whereIn('status',$where)->where('user_id',$user_id)->get()->toArray();
        //print_r($list);
        if(!empty($list))
        {
            foreach ($list as &$v)
            {
                $v['days'] = ceil((time() - strtotime($v['confirm_time']))/(3600*24));
            }
        }

        $info['list'] = $list;
        $this->ret['info'] = $info;
        return $this->ret;
    }

    /**
     * 确认收货
     * @param Request $request
     */
    public function confirm_order(Request $request)
    {
        $order_code = $request->get('code');
        $id = $request->get('id');

        if(!empty($id))
        {
            $ret = Order::where('id',$id)->update(['status'=>Order::STATUS_DOING,'confirm_time'=>$this->datetime]);
        }
        else
        {
            $ret = Order::where('code',$order_code)->update(['status'=>Order::STATUS_DOING,'confirm_time'=>$this->datetime]);
        }

        return $this->ret;
    }

    public function order_back(Request $request)
    {
        $order_id = $request->get('order_id');
        //$express_id = $request->get('express_id');
        $back_express_com = $request->get('back_express_com');
        $back_express_title = $request->get('back_express_title');
        $back_express_no = $request->get('back_express_no');

        $order = Order::where('id',$order_id)->first();

        $user = User::find($order->user_id);

        if($order->status == Order::STATUS_DOING_STR)
        {
            //$express = Express::find($express_id);

            $data['back_express_title'] = $back_express_title;
            $data['back_express_com'] = $back_express_com;
            $data['back_express_no'] = $back_express_no;
            $data['status'] = Order::STATUS_BACK;
            $data['back_status'] = Order::BACK_STATUS_WAITING;
            $data['back_time'] = $this->datetime;

            Order::where('id',$order_id)->update($data);

            $this->send_sms($user->telephone,$user->name);

            return $this->ret;
        }
        else
        {
            $this->ret['code'] = 300;
            $this->ret['msg'] = '操作失败';
            return $this->ret;
        }
    }

    /**
     * 用户已提交归还的物流单号
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
            'template' => 'SMS_85485003',
            'data' => [
                'name' => $name
            ],
        ]);
    }

    public function order_back_list(Request $request)
    {
        $user_id = $request->get('user_id');
        $page = $request->get('page')?$request->get('page'):1;
        $limit = $request->get('limit')?$request->get('limit'):10;

        $offset = ($page-1)*$limit;


        $where = [Order::STATUS_BACK];
        //$list = Order::with(['user','category','good_brand'])->skip($offset)->take($limit)->whereIn('status',$where)->get()->toArray();
        $list = Order::with(['user','category','good_brand'])->whereIn('status',$where)->where('user_id',$user_id)->get()->toArray();
        //print_r($list);
        if(!empty($list))
        {
            foreach ($list as &$v)
            {
                $v['days'] = 0;
                if($v['status']=='已归还')
                {
                    $v['days'] = ceil((strtotime($v['back_time']) - strtotime($v['confirm_time']))/(3600*24));
                }

                if($v['back_time'])
                {
                    $v['back_time_new'] = date('Y-m-d',(strtotime($v['back_time'])));
                }
                if($v['confirm_time'])
                {
                    $v['confirm_time_new'] = date('Y-m-d',(strtotime($v['confirm_time'])));
                }
            }
        }

        $this->ret['info'] = ['list'=>$list];
        return $this->ret;
    }

}
