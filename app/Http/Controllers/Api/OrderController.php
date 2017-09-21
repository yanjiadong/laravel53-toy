<?php

namespace App\Http\Controllers\Api;

use App\Express;
use App\Good;
use App\Order;
use App\SystemConfig;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends BaseController
{
    public function add_order(Request $request)
    {
        $good_id = $request->get('good_id');
        $user_id = $request->get('user_id');

        //判断是否租用中的玩具
        $order = Order::whereIn('status',[Order::STATUS_WAITING_SEND,Order::STATUS_SEND,Order::STATUS_DOING])->where('user_id',$user_id)->get()->toArray();
        //print_r($order);
        if(!empty($order))
        {
            $this->ret['code'] = 300;
            $this->ret['msg'] = '当前账户已有正在租用物品,归还后才能再次下单';
            return $this->ret;
        }

        $good = Good::with(['category_tag'])->find($good_id);

        $info['good_title'] = $good->title;
        $info['good_picture'] = $good->picture;
        $info['good_price'] = $good->price;
        $info['good_category_tag'] = $good->category_tag->title;

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



        $user = User::find($user_id);
        if(empty($user->telephone))
        {
            $this->ret['code'] = 300;
            $this->ret['msg'] = '当前账户尚未绑定手机号,请先绑定手机号';
            return $this->ret;
        }

        $good = $good = Good::with(['category_tag','category'])->where(['id'=>$good_id,'status'=>Good::STATUS_ON_SALE])->first();
        if(empty($good->id))
        {
            $this->ret['code'] = 300;
            $this->ret['msg'] = '玩具不存在';
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
        $order_data['express_price'] = $express_price;
        $order_data['clean_price'] = $clean_price;
        $order_data['price'] = $price;
        $order_data['money'] = $money;
        $order_data['address_id'] = $address_id;
        $order_data['receiver'] = $receiver;
        $order_data['receiver_telephone'] = $receiver_telephone;
        $order_data['receiver_address'] = $receiver_address;
        $order_data['out_trade_no'] = 'P'.$order_data['code'];

        Order::create($order_data);

        return $this->ret;
    }

    public function order_list(Request $request)
    {
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

        $list = Order::with(['user','category','good_brand'])->skip($offset)->take($limit)->whereIn('status',$where)->get()->toArray();
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

        $this->ret['info'] = ['order'=>$info];
        return $this->ret;
    }

    public function order_can_back(Request $request)
    {
        $config = SystemConfig::where('type',1)->first();
        $content = json_decode($config->content,true);
        //print_r($content);
        $info['tip'] = $content[5];
        $info['address'] = $content[4];
        $info['telephone'] = $content[3];
        $info['name'] = $content[2];

        $where = [Order::STATUS_DOING];
        $list = Order::with(['user','category','good_brand'])->whereIn('status',$where)->get()->toArray();
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


    public function order_back(Request $request)
    {
        $code = $request->get('code');
        $express_id = $request->get('express_id');
        $back_express_no = $request->get('back_express_no');

        $order = Order::where('code',$code)->first();

        if($order->status == Order::STATUS_DOING_STR)
        {
            $express = Express::find($express_id);

            $data['back_express_title'] = $express->title;
            $data['back_express_com'] = $express->com;
            $data['back_express_no'] = $back_express_no;
            $data['status'] = Order::STATUS_BACK;
            $data['back_status'] = Order::BACK_STATUS_WAITING;
            $data['back_time'] = $this->datetime;

            Order::where('code',$code)->update($data);
            return $this->ret;
        }
        else
        {
            $this->ret['code'] = 300;
            $this->ret['msg'] = '操作失败';
            return $this->ret;
        }
    }

    public function order_back_list(Request $request)
    {
        $page = $request->get('page')?$request->get('page'):1;
        $limit = $request->get('limit')?$request->get('limit'):10;

        $offset = ($page-1)*$limit;


        $where = [Order::STATUS_BACK];
        $list = Order::with(['user','category','good_brand'])->skip($offset)->take($limit)->whereIn('status',$where)->get()->toArray();
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
            }
        }

        $this->ret['info'] = ['list'=>$list];
        return $this->ret;
    }

}