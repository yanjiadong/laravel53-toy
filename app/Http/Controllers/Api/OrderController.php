<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Coupon;
use App\Express;
use App\ExpressInfo;
use App\Good;
use App\Order;
use App\SystemConfig;
use App\User;
use App\UserCoupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Overtrue\EasySms\EasySms;
use DB;
use EasyWeChat\Factory;

class OrderController extends BaseController
{
    /**
     * 新版订单接口
     * @param Request $request
     */
    public function add_order_new(Request $request)
    {
        $good_id = $request->get('good_id');
        $user_id = $request->get('user_id');

        $user = User::find($user_id);
        $good = Good::with(['category_tag','brand'])->find($good_id);

        $info['good_title'] = $good->title;
        $info['good_picture'] = $good->picture;
        $info['good_price'] = $good->price;
        $info['good_brand'] = $good->brand->title;
        $info['good_old'] = $good->old;
        $info['good_day_price'] = $good->day_price;
        $info['good_days'] = $good->days;
        $info['good_express_price'] = $good->express_price;
        $info['good_free_price'] = $good->free_price;
        $info['good_express'] = $good->express;
        $info['good_money'] = $good->money;

        //计算不同天数不同的单日价格
        $price_info = [
            array_merge(['name'=>'1周'],getGoodPriceInfo($info['good_price'],7, $good->is_discount, $good_id)),
            array_merge(['name'=>'2周'],getGoodPriceInfo($info['good_price'],14, $good->is_discount, $good_id)),
            array_merge(['name'=>'3周'],getGoodPriceInfo($info['good_price'],21, $good->is_discount, $good_id)),
            array_merge(['name'=>'1个月'],getGoodPriceInfo($info['good_price'],30, $good->is_discount, $good_id)),
            array_merge(['name'=>'2个月'],getGoodPriceInfo($info['good_price'],60, $good->is_discount, $good_id)),
        ];

        //print_r($price_info);
        //计算优惠券数量
        $coupon_nums = UserCoupon::where('user_id',$user_id)->where('status',0)->count();

        //计算需要支付的押金  订单中只能一个订单才能使用芝麻分减免哦
        $order_count = Order::whereIn('status',[Order::STATUS_WAITING_SEND,Order::STATUS_SEND,Order::STATUS_DOING])->where('is_use_zhima',1)->where('user_id',$user_id)->count();
        $money = $info['good_money'];

        $info['can_use_zhima'] = 0;  //需要去认证
        if($order_count > 0 && $user->is_zhima == 1)
        {
            $info['can_use_zhima'] = 2;   //使用过了认证
        }

        $info['good_money_discount'] = 0;
        if($order_count <= 0 && $user->is_zhima == 1)
        {
            //本次能够使用认证减免
            $info['can_use_zhima'] = 1;
            if($user->zhima_money >= $info['good_money'])
            {
                $money = '0.00';
                $info['good_money_discount'] = $info['good_money'];
            }
            else
            {
                $money = $info['good_money'] - $user->zhima_money;
                $info['good_money_discount'] = $user->zhima_money;
            }
        }


        $total_price = round($info['good_day_price']*21,2);  //租金

        //计算运费
        $express_price = $info['good_express_price'];
        if($total_price >= $info['good_free_price'])
        {
            $express_price = '0.00';
        }

        //计算预计发货时间
        $send_time = strtotime("+{$info['good_days']} days",$this->time);
        $send_date = date('m月d日',$send_time);

        $weekarray = array("日","一","二","三","四","五","六");
        $send_week = $weekarray[date("w",$send_time)];

        $result['good'] = $info;
        $result['price_info'] = $price_info;
        $result['express_price'] = $express_price;  //运费
        $result['total_price'] = sprintf("%.2f", $total_price);   //租金
        $result['money'] = $money;  //押金
        $result['price'] = sprintf("%.2f", ($money + $express_price + $total_price));
        $result['send_time'] = ['send_week'=>$send_week,'send_date'=>$send_date];

        $this->ret['info'] = $result;
        //print_r($result);
        return $this->ret;
    }

    /**
     * 新版提交订单接口
     * @param Request $request
     */
    public function submit_order_new(Request $request)
    {
        $good_id = $request->get('good_id');
        $user_id = $request->get('user_id');

        //$express_price = $request->get('express_price');
        //$price = $request->get('price');
        //$money = $request->get('money');
        $address_id = $request->get('address_id');
        $receiver = $request->get('receiver');
        $receiver_telephone = $request->get('receiver_telephone');
        $receiver_address = $request->get('receiver_address');
        $receiver_province = $request->get('receiver_province');
        $receiver_city = $request->get('receiver_city');
        $receiver_area = $request->get('receiver_area');
        $is_use_zhima = $request->get('is_use_zhima');
        $days = $request->get('days');
        $coupon_id = $request->get('coupon_id');

        $user = User::find($user_id);
        if(empty($user->telephone))
        {
            $this->ret['code'] = 300;
            $this->ret['msg'] = '当前账户尚未绑定手机号,请先绑定手机号';
            return $this->ret;
        }

        $good = Good::with(['category_tag','category','brand'])->where(['id'=>$good_id,'status'=>Good::STATUS_ON_SALE])->first();
        if(empty($good->id))
        {
            $this->ret['code'] = 300;
            $this->ret['msg'] = '玩具不存在';
            return $this->ret;
        }
        if($good->store <= 0)
        {
            $this->ret['code'] = 300;
            $this->ret['msg'] = '玩具库存不足';
            return $this->ret;
        }

        $good_day_price = round(getGoodPriceByDays($good->price,$days),2);
        $total_price = round($days*$good_day_price,2);

        $money = $good->money;
        $zhima_price = 0;
        if($is_use_zhima == 1)
        {
            $order_count = Order::whereIn('status',[Order::STATUS_WAITING_SEND,Order::STATUS_SEND,Order::STATUS_DOING])->where('is_use_zhima',1)->where('user_id',$user_id)->count();
            if($order_count <= 0 && $user->is_zhima == 1)
            {
                if($user->zhima_money >= $good->money)
                {
                    $money = 0;
                    $zhima_price = $good->money;
                }
                else
                {
                    $money = $good->money - $user->zhima_money;
                    $zhima_price = $user->zhima_money;
                }
            }
            else
            {
                $is_use_zhima = 0;
            }
        }

        //计算运费
        $express_price = $good->express_price;
        if($total_price >= $good->free_price)
        {
            $express_price = 0;
        }

        //计算优惠券优惠金额
        $coupon_price = 0;
        if($coupon_id)
        {
            $coupon = UserCoupon::where('id',$coupon_id)->first();
            if($total_price >= $coupon->condition)
            {
                $total_price = $total_price - $coupon->coupon_price;
            }
        }

        $price = round($total_price+$express_price+$money,2);

        $plan_send_time = date('Y-m-d',strtotime("+{$good->days} days",$this->time));

        $order_data['code'] = get_order_code();
        $order_data['user_id'] = $user_id;
        $order_data['good_id'] = $good_id;
        $order_data['plan_send_time'] = $plan_send_time;
        $order_data['good_title'] = $good->title;
        $order_data['good_picture'] = $good->picture;
        $order_data['good_price'] = $good->price;
        $order_data['category_id'] = $good->category_id;
        $order_data['category_tag_id'] = $good->category_tag_id;
        $order_data['good_brand_id'] = $good->brand_id;
        $order_data['good_old'] = $good->old;
        $order_data['address_id'] = $address_id;
        $order_data['receiver'] = $receiver;
        $order_data['receiver_telephone'] = $receiver_telephone;
        $order_data['receiver_address'] = $receiver_address;
        $order_data['receiver_province'] = $receiver_province;
        $order_data['receiver_city'] = $receiver_city;
        $order_data['receiver_area'] = $receiver_area;
        $order_data['month'] = date('Y-m');
        $order_data['out_trade_no'] = 'T'.$order_data['code'];
        $order_data['user_telephone'] = $user->telephone;
        $order_data['express_price'] = $express_price;
        $order_data['price'] = $price;
        $order_data['money'] = $money;
        $order_data['days'] = $days;
        $order_data['good_day_price'] = $good_day_price;
        $order_data['total_price'] = $total_price;
        $order_data['is_use_zhima'] = $is_use_zhima;
        $order_data['coupon_id'] = $coupon_id;
        $order_data['coupon_price'] = $coupon_price;
        $order_data['zhima_price'] = $zhima_price;

        $order = Order::create($order_data);

        //$total_fee = $order->price*100;  //订单需要支付的金额
        $total_fee = 0.01*100;  //订单需要支付的金额
        //生成支付信息
        $options = config('wechat.payment');
        $app = Factory::payment($options);

        $result = $app->order->unify([
            'body' => '支付玩具：'.$good->title,
            'out_trade_no' => $order_data['out_trade_no'],
            'total_fee' => $total_fee,
            //'spbill_create_ip' => '123.12.12.123', // 可选，如不传该参数，SDK 将会自动获取相应 IP 地址
            //'notify_url' => 'https://pay.weixin.qq.com/wxpay/pay.action', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'trade_type' => 'JSAPI',
            'openid' => $user->wechat_openid,
        ]);

        $jsApiParameters = '';
        if($result['result_code'] === 'SUCCESS')
        {
            $prepayId = $result['prepay_id'];
            $jssdk = $app->jssdk;
            $jsApiParameters = $jssdk->bridgeConfig($prepayId);
        }

        $this->ret['info'] = ['order_code'=>$order_data['code'],'jsApiParameters'=>$jsApiParameters];
        return $this->ret;
    }

    /**
     * 确认收货
     * @param Request $request
     */
    public function confirm_order(Request $request)
    {
        $id = $request->get('id');

        $order = Order::find($id);

        $start_time = date('Y-m-d 00:00:01',$this->time);
        $end_time = date('Y-m-d 23:59:59',strtotime("+{$order->days} days",$this->time));

        $ret = Order::where('id',$id)->update(['status'=>Order::STATUS_DOING,'confirm_time'=>$this->datetime,'start_time'=>$start_time,'end_time'=>$end_time]);
        return $this->ret;
    }

    /**
     * 申请提现
     * @param Request $request
     */
    public function apply_money(Request $request)
    {
        $user_id = $request->get('user_id');
        $code= $request->get('code');

        $order = DB::table('orders')->where('code',$code)->first();

        if($order->money_status == Order::MONEY_STATUS_UN && $order->status == Order::STATUS_BACK && $order->back_status == Order::BACK_STATUS_DOING)
        {
            Order::where('code',$code)->update(['money_status'=>1,'apply_money_time'=>$this->datetime]);

            //押金提现记录
            $price = $order->money - $order->over_days*$order->good_day_price;
            DB::table('user_pay_records')->insert(['user_id'=>$user_id,'type'=>1,'pay_type'=>2,'price'=>$price,'created_at'=>date('Y-m-d H:i:s')]);
            return $this->ret;
        }

        $this->ret['code'] = 300;
        $this->ret['msg'] = '暂无法申请提现';
        return $this->ret;
    }

    /**
     * 获取订单列表
     * @param Request $request
     * @return array
     */
    public function get_order_list(Request $request)
    {
        $user_id = $request->get('user_id');
        $type = $request->get('type')?$request->get('type'):1;  //1进行中的  2已结束的

        if($type == 1)
        {
            $where = [Order::STATUS_WAITING_SEND,Order::STATUS_SEND,Order::STATUS_DOING];
        }
        else
        {
            $where = [Order::STATUS_BACK];
        }

        if($type == 2)
        {
            $list = Order::with(['user','category','good_brand'])->whereIn('status',$where)->where('user_id',$user_id)->orderBy('back_time','desc')->get()->toArray();
        }
        else
        {
            $list = Order::with(['user','category','good_brand'])->whereIn('status',$where)->where('user_id',$user_id)->orderBy('created_at','desc')->get()->toArray();
        }

        //print_r($list);
        if(!empty($list))
        {
            foreach ($list as &$v)
            {
                /*if($type == 1)
                {
                    $v['over_days'] = 0;
                    if($v['status']==Order::STATUS_DOING_STR)
                    {
                        $time = $this->time > strtotime($v['end_time']);
                        if($time > 0)
                        {
                            $v['over_days'] = ceil($time/86400);
                        }
                    }
                }*/
                $v['price'] = sprintf('%0.1f',$v['price']);
                $v['good_num'] = 1;
                $v['days2'] = 0;  //剩余天数

                if($v['status']==Order::STATUS_BACK_STR)
                {
                    //$v['days'] = floor((strtotime($v['back_time']) - strtotime($v['send_time']))/86400);
                }
                elseif($v['status']==Order::STATUS_DOING_STR)
                {
                    $v['over_days'] = 0;
                    //计算还有几天到期
                    $time = $this->time - strtotime($v['end_time']);
                    if($time > 0)
                    {
                        //逾期的情况下
                        $v['days2'] = 0;
                        $v['over_days'] = ceil($time/86400);
                    }
                    else
                    {
                        $v['days2'] = ceil((strtotime($v['end_time']) - $this->time)/86400);
                    }
                }

                //格式化租期
                $v['start_time_new'] = date('Y.m.d',strtotime($v['start_time']));
                $v['end_time_new'] = date('Y.m.d',strtotime($v['end_time']));
            }
        }

        //print_r($list);
        //客服电话
        $config = SystemConfig::where('type',1)->first();
        $content = json_decode($config->content,true);
        $phone = '';
        if(isset($content[7]))
        {
            $phone = $content[7];
        }


        $this->ret['info'] = ['list'=>$list,'phone'=>$phone];
        return $this->ret;
    }

    public function get_money_list(Request $request)
    {
        $user_id = $request->get('user_id');

        //获取押金页面顶部图片
        $config = SystemConfig::where('type',1)->first();
        $content = json_decode($config->content,true);
        $image = '';
        if(isset($content[9]))
        {
            $image = $content[9];
        }

        $orders = Order::where('user_id',$user_id)->where('money','>','0')->orderBy('pay_success_time','desc')->get()->toArray();
        if(!empty($orders))
        {
            foreach ($orders as &$v)
            {
                $v['num'] = 1;  //订单数量
                $v['over_money'] = $v['over_days']*$v['good_day_price'];
                $v['can_apply_money'] = 0;

                if($v['status'] == Order::STATUS_BACK_STR && $v['back_status'] == Order::BACK_STATUS_DOING_STR && $v['money_status'] == Order::MONEY_STATUS_UN)
                {
                    $v['can_apply_money'] = 1;
                }
                elseif($v['money_status'] == Order::MONEY_STATUS_ING)
                {
                    $v['can_apply_money'] = 2;
                }
                elseif($v['money_status'] == Order::MONEY_STATUS_DONE)
                {
                    $v['can_apply_money'] = 3;
                }

                //格式化时间
                $v['start_time_new'] = date('Y.m.d',strtotime($v['start_time']));
                $v['end_time_new'] = date('Y.m.d',strtotime($v['end_time']));
            }
        }

        $this->ret['info'] = ['list'=>$orders,'image'=>$image];
        return $this->ret;
    }

    public function order_detail(Request $request)
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

        $info['address'] = $info['receiver_province'].$info['receiver_city'].$info['receiver_area'].$info['receiver_address'];

        //dd($info);


        //剩余天数
        $info['days2'] = 0;
        if($info['status'] == Order::STATUS_DOING_STR)
        {
            if($this->time > strtotime($info['end_time']))
            {
                $info['over_days'] = ceil(($this->time - strtotime($info['end_time']))/86400);
            }
            else
            {
                $info['days2'] = ceil((strtotime($info['end_time']) - $this->time)/86400);
            }
        }

        $info['pay_success_time_int'] = $this->time;
        if(!empty($info['pay_success_time']))
        {
            $info['pay_success_time_int'] = strtotime($info['pay_success_time']);
        }

        $info['send_time_int'] = $this->time;
        if(!empty($info['send_time']))
        {
            $info['send_time_int'] = strtotime($info['send_time']);
        }

        $info['start_time_int'] = $this->time;
        $info['has_days'] = 0;
        if(!empty($info['start_time']))
        {
            $info['start_time_int'] = strtotime($info['start_time']);

            //计算已经租用天数
            $info['has_days'] = ceil(($this->time - strtotime($info['start_time']))/86400);
        }

        $info['end_time_int'] = $this->time;
        if(!empty($info['end_time']))
        {
            $info['end_time_int'] = strtotime($info['end_time']);
        }

        $tel = get_tel();
        $this->ret['info'] = ['logistics'=>$logistics,'order'=>$info,'tel'=>$tel];
        return $this->ret;
    }
    /*
     * ================================
     */
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
        $info['good_old'] = $good->old;
        //$info['good_category_tag'] = $good->category_tag->title;

        //计算邮费
        $config = SystemConfig::where('type',1)->first();
        $num = 0;
        $price = '0.00';

        if(!empty($config->content))
        {
            $config_array = json_decode($config->content,true);
            $num = isset($config_array[0])?$config_array[0]:0;
            $price = isset($config_array[1])?$config_array[1]:'0.00';
        }

        $count = Order::where('month',date('Y-m'))->where('user_id',$user_id)->where('status','>',0)->count();
        if($count < $num)
        {
            //免邮
            $express_price = '0.00';
        }
        else
        {
            $express_price = $price;
        }


        $result['good'] = $info;
        $result['express_price'] = $express_price;
        $result['clean_price'] = '0.00';
        $result['money'] = '0.00';
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

        if(!$user->is_vip)
        {
            $this->ret['code'] = 300;
            $this->ret['msg'] = '请先充值成为会员再下单';
            return $this->ret;
        }

        $good = Good::with(['category_tag','category','brand'])->where(['id'=>$good_id,'status'=>Good::STATUS_ON_SALE])->first();
        if(empty($good->id))
        {
            $this->ret['code'] = 300;
            $this->ret['msg'] = '玩具不存在';
            return $this->ret;
        }

        if($good->store <= 0)
        {
            $this->ret['code'] = 300;
            $this->ret['msg'] = '玩具库存不足';
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
        $order_data['month'] = date('Y-m');
        $order_data['out_trade_no'] = 'p'.$order_data['code'];
        $order_data['user_telephone'] = $user->telephone;

        if($order_data['price']<=0)
        {
            $order_data['status'] = Order::STATUS_WAITING_SEND;
            $order_data['pay_success_time'] = $this->datetime;

            //从玩具箱中去除
            Cart::where(['user_id'=>$user_id,'good_id'=>$good_id])->delete();

            //扣除库存
            $store = $good->store - 1;
            if($store <=0 )
            {
                $store = 0;
            }
            Good::where('id',$good_id)->update(['store'=>$store]);

            //发送短信通知
            //$this->send_order_sms($user->telephone,$user->name);
            sms_send('SMS_103795027',$user->telephone,$user->name);

            //短信通知后台管理员
            sms_send('SMS_109345328','13366556200');
            sms_send('SMS_109345328','15101016067');
            //send_order_to_admin('13366556200');
            //send_order_to_admin('15101016067');
        }
        Order::create($order_data);


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
        if($type == 2)
        {
            $list = Order::with(['user','category','good_brand'])->whereIn('status',$where)->where('user_id',$user_id)->orderBy('back_time','desc')->get()->toArray();
        }
        else
        {
            $list = Order::with(['user','category','good_brand'])->whereIn('status',$where)->where('user_id',$user_id)->get()->toArray();
        }

        //print_r($list);
        if(!empty($list))
        {
            foreach ($list as &$v)
            {
                $v['days'] = 0;
                if($v['status']==Order::STATUS_BACK_STR)
                {
                    $v['days'] = floor((strtotime($v['back_time']) - strtotime($v['send_time']))/86400);
                }
                elseif($v['status']==Order::STATUS_DOING_STR)
                {
                    $v['days'] = floor((time()- strtotime($v['send_time']))/86400);
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

        $info['address'] = $info['receiver_province'].$info['receiver_city'].$info['receiver_area'].$info['receiver_address'];
        $info['days'] = 0;
        $info['total_days'] = 0;
        if($info['status'] == Order::STATUS_BACK_STR)
        {
            $info['days'] = floor((strtotime($info['back_time']) - strtotime($info['send_time']))/(3600*24));
            $info['total_days'] = $info['days'];
        }
        elseif($info['status'] == Order::STATUS_DOING_STR)
        {
            $info['days'] = floor(($this->time- strtotime($info['send_time']))/(3600*24));
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
        /*if(!empty($list))
        {
            foreach ($list as &$v)
            {
                $v['days'] = floor((time() - strtotime($v['send_time']))/(3600*24));
            }
        }*/

        $info['list'] = $list;
        $this->ret['info'] = $info;
        return $this->ret;
    }

    /**
     * 提交归还物流信息
     * @param Request $request
     * @return array
     */
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

            //计算逾期
            if($this->time > strtotime($order->end_time))
            {
                $data['over_days'] = ceil(($this->time - strtotime($order->end_time))/(24*3600));
            }

            //每次提交赠送一次满减优惠券
            $coupon = Coupon::where('type',2)->orderBy('id','desc')->first();
            if(!empty($coupon))
            {
                UserCoupon::create(['user_id'=>$order->user_id,'coupon_id'=>$coupon->id,'coupon_type'=>$coupon->type,'coupon_price'=>$coupon->price,'coupon_days'=>$coupon->days,'coupon_title'=>$coupon->title,'start_time'=>date('Y-m-d'),'condition'=>$coupon->condition,'end_time'=>date('Y-m-d',strtotime("+{$coupon->days} days"))]);
                //UserCoupon::create(['user_id'=>$order->user_id,'coupon_id'=>$coupon->id]);
            }

            $data['back_express_title'] = $back_express_title;
            $data['back_express_com'] = $back_express_com;
            $data['back_express_no'] = $back_express_no;
            $data['status'] = Order::STATUS_BACK;
            $data['back_status'] = Order::BACK_STATUS_WAITING;
            $data['back_time'] = $this->datetime;

            Order::where('id',$order_id)->update($data);

            sms_send('SMS_119077485',$user->telephone,$user->name);

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
            'template' => 'SMS_109410296',
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
        $list = Order::with(['user','category','good_brand'])->whereIn('status',$where)->where('user_id',$user_id)->orderBy('back_time','desc')->get()->toArray();
        //print_r($list);
        if(!empty($list))
        {
            foreach ($list as &$v)
            {
                $v['days'] = 0;
                if($v['status']=='已归还')
                {
                    $v['days'] = floor((strtotime($v['back_time']) - strtotime($v['send_time']))/(3600*24));
                }

                if($v['back_time'])
                {
                    $v['back_time_new'] = date('Y.m.d',(strtotime($v['back_time'])));
                }
                if($v['confirm_time'])
                {
                    $v['confirm_time_new'] = date('Y.m.d',(strtotime($v['send_time'])));
                }
            }
        }

        $this->ret['info'] = ['list'=>$list];
        return $this->ret;
    }

}
