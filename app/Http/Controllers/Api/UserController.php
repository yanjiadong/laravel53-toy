<?php

namespace App\Http\Controllers\Api;

use App\Area;
use App\Order;
use App\SystemConfig;
use App\User;
use App\UserAddress;
use App\UserChooseCoupon;
use App\UserCoupon;
use App\UserPayRecord;
use App\VipCard;
use App\VipCardPay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class UserController extends BaseController
{
    public function center(Request $request)
    {
        $user_id = $request->get('user_id');

        $user = User::find($user_id);

        $where = [Order::STATUS_WAITING_SEND,Order::STATUS_SEND,Order::STATUS_DOING];
        $count = Order::whereIn('status',$where)->where('user_id',$user_id)->count();

        $order_code = '';
        if($count)
        {
            $order = Order::whereIn('status',$where)->where('user_id',$user_id)->first();
            $order_code = $order->code;
        }
        //会员卡
        $card = VipCardPay::where('user_id',$user_id)->where('days','>',0)->where('pay_status',1)->orderBy('id','desc')->first();
        if(!empty($card))
        {
            $card->isOutTime = 1;
            if($card->days>0)
            {
                $card->isOutTime = 0;
            }
            switch ($card->vip_card_type)
            {
                case 1:
                    $card->vip_card_type_str = '月卡';
                    break;
                case 2:
                    $card->vip_card_type_str = '季度卡';
                    break;
                case 3:
                    $card->vip_card_type_str = '半年卡';
                    break;
            }
        }
        else
        {
            $card['isOutTime'] = 1;
            $card['vip_card_type_str'] = '';
        }

        $days = VipCardPay::where('user_id',$user_id)->where('status',1)->where('pay_status',1)->sum('days');

        //优惠券数量
        $coupon_nums = UserCoupon::where('user_id',$user_id)->where('status',0)->count();

        $this->ret['info'] = ['user'=>$user,'count'=>$count,'card'=>$card,'days'=>$days,'coupon_nums'=>$coupon_nums,'order_code'=>$order_code];
        return $this->ret;
    }

    public function deposit_list(Request $request)
    {
        $user_id = $request->get('user_id');
        $list = UserPayRecord::where(['user_id'=>$user_id,'type'=>1])->get()->toArray();
        if(!empty($list))
        {
            foreach ($list as &$v)
            {
                $v['pay_type_status'] = '提现';
                if($v['pay_type']==1)
                {
                    $v['pay_type_status'] = '充值';
                }
            }
        }
        $this->ret['info'] = ['list'=>$list];
        return $this->ret;
    }
    /**
     * @param Request $request
     * @return array
     */
    public function add_address(Request $request)
    {
        $data['user_id'] = $request->get('user_id');
        $province = $request->get('c');
        $city = $request->get('d');
        $area = $request->get('e');

        $province_info = Area::where('name',$province)->first();
        $data['province_id'] = $province_info->id;

        $city_info = Area::where('name',$city)->first();
        $data['city_id'] = $city_info->id;

        $area_info = Area::where('name',$area)->first();
        $data['area_id'] = $area_info->id;

        $data['address'] = $request->get('f');
        $data['receiver'] = $request->get('a');
        $data['receiver_telephone'] = $request->get('b');

        if(empty($data['address']))
        {
            $this->ret = ['code'=>300,'msg'=>'请输入详细地址'];
            return $this->ret;
        }

        if(empty($data['receiver']))
        {
            $this->ret = ['code'=>300,'msg'=>'请输入收货人'];
            return $this->ret;
        }

        if(!isMobile($data['receiver_telephone']))
        {
            $this->ret = ['code'=>300,'msg'=>'请输入正确的收货人号码'];
            return $this->ret;
        }
        UserAddress::create($data);
        $this->ret['msg'] = '添加成功';
        return $this->ret;
    }

    public function edit_address(Request $request)
    {
        $address_id = $request->get('g');

        $address = UserAddress::find($address_id);
        if(empty($address))
        {
            $this->ret = ['code'=>300,'msg'=>'收货地址不存在'];
            return $this->ret;
        }

        $data['user_id'] = $request->get('user_id');
        $data['province_id'] = $request->get('province_id');
        $data['city_id'] = $request->get('city_id');
        $data['area_id'] = $request->get('area_id');
        $data['address'] = $request->get('f');
        $data['receiver'] = $request->get('a');
        $data['receiver_telephone'] = $request->get('b');

        if(empty($data['address']))
        {
            $this->ret = ['code'=>300,'msg'=>'请输入详细地址'];
            return $this->ret;
        }

        if(empty($data['receiver']))
        {
            $this->ret = ['code'=>300,'msg'=>'请输入收货人'];
            return $this->ret;
        }

        if(!isMobile($data['receiver_telephone']))
        {
            $this->ret = ['code'=>300,'msg'=>'请输入正确的收货人号码'];
            return $this->ret;
        }
        UserAddress::where('id',$address_id)->update($data);
        $this->ret['msg'] = '修改成功';
        return $this->ret;
    }

    public function get_address($id)
    {
        $address = DB::table('user_addresses')
            ->select('user_addresses.receiver as a','user_addresses.receiver_telephone as b','p.name as c','c.name as d','a.name as e','user_addresses.address as f')
            ->leftJoin('areas as p', 'p.id', '=', 'user_addresses.province_id')
            ->leftJoin('areas as c', 'c.id', '=', 'user_addresses.city_id')
            ->leftJoin('areas as a', 'a.id', '=', 'user_addresses.area_id')
            ->first();

        $this->ret['info'] = ['address'=>$address];
        return $this->ret;
    }

    public function address_list(Request $request)
    {
        $user_id = $request->get('user_id');

        $address = DB::table('user_addresses')
            ->select('user_addresses.receiver as a','user_addresses.receiver_telephone as b','p.name as c','c.name as d','a.name as e','user_addresses.address as f','user_addresses.id as g','user_addresses.province_id','user_addresses.city_id','user_addresses.area_id')
            ->leftJoin('areas as p', 'p.id', '=', 'user_addresses.province_id')
            ->leftJoin('areas as c', 'c.id', '=', 'user_addresses.city_id')
            ->leftJoin('areas as a', 'a.id', '=', 'user_addresses.area_id')
            ->where('user_id',$user_id)
            ->get();

        $this->ret['info'] = ['address'=>$address];
        return $this->ret;
    }

    public function delete_address(Request $request)
    {
        UserAddress::destroy($request->get('address_id'));
        $this->ret['msg'] = '删除成功';
        return $this->ret;
    }

    public function vip_cards()
    {
        $list = VipCard::all();
        $this->ret['info'] = ['list'=>$list];
        return $this->ret;
    }

    public function coupon_list(Request $request)
    {
        $user_id = $request->get('user_id');
        $vip_card_id = $request->get('vip_card_id');

        $vip_card_info = VipCard::find($vip_card_id);
        $condition = $vip_card_info->price;

        $user = User::find($user_id);
        $coupons = $user->coupons()->get()->toArray();

        //print_r($coupons);
        $result = [];
        if(!empty($coupons))
        {
            foreach ($coupons as &$v)
            {
                $info = UserCoupon::where('user_id',$user_id)->where('coupon_id',$v['id'])->first();
                if($info->status == 1)
                {
                    continue;
                }

                $v['can_use'] = 1;
                if($v['condition'] > $condition)
                {
                    $v['can_use'] = 0;
                }
                $v['new_start_time'] = date('Y.m.d',strtotime($v['start_time']));
                $v['new_end_time'] = date('Y.m.d',strtotime($v['end_time']));

                $result[] = $v;
            }
        }
        $this->ret['info'] = ['coupons'=>$result];
        return $this->ret;
    }

    public function choose_coupon(Request $request)
    {
        $user_id = $request->get('user_id');
        $coupon_id = $request->get('coupon_id');

        UserChooseCoupon::where('user_id',$user_id)->delete();
        UserChooseCoupon::create(['user_id'=>$user_id,'coupon_id'=>$coupon_id]);
        return $this->ret;
    }

    public function del_choose_coupon(Request $request)
    {
        $user_id = $request->get('user_id');
        UserChooseCoupon::where('user_id',$user_id)->delete();
        return $this->ret;
    }

    /**
     * 提现操作
     * @param Request $request
     */
    public function cash(Request $request)
    {
        $user_id = $request->get('user_id');
        $vip_card_pay_id = $request->get('vip_card_pay_id');

        $info = VipCardPay::find($vip_card_pay_id);

        //押金明细
        DB::table('user_pay_records')->insert(['user_id'=>$user_id,'type'=>1,'pay_type'=>2,'price'=>$info->money,'created_at'=>date('Y-m-d H:i:s')]);

        $user = User::find($user_id);
        $can_use_money = $user->can_use_money - $info->money;
        User::where('id',$user_id)->update(['can_use_money'=>$can_use_money]);

        if($info->days > 0)
        {
            $user_days = $user->days - $info->days;
            User::where('id',$info->user_id)->update(['days'=>$user_days]);

            VipCardPay::where('id',$vip_card_pay_id)->update(['status'=>-2,'days'=>0]);

            $vip_card_count = VipCardPay::where(['user_id'=>$info->user_id,'pay_status'=>1,'status'=>1])->count();
            if($vip_card_count <= 0)
            {
                User::where('id',$info->user_id)->update(['is_vip'=>0]);
            }
        }
        else
        {
            VipCardPay::where('id',$vip_card_pay_id)->update(['status'=>-2]);
        }

        return $this->ret;
    }

    public function cash_list(Request $request)
    {
        $user_id = $request->get('user_id');

        $list = VipCardPay::with(['user','vip_card'])->where('money','>',0)->where('user_id',$user_id)->where('pay_status',1)->orderBy('id','desc')->get();
        $this->ret['info'] = ['list'=>$list];
        return $this->ret;
    }
}
