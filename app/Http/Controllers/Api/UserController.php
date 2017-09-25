<?php

namespace App\Http\Controllers\Api;

use App\Area;
use App\Order;
use App\User;
use App\UserAddress;
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

        //会员卡
        $card = VipCardPay::where('user_id',$user_id)->where('days','>',0)->where('pay_status',1)->first()->toArray();
        if(!empty($card))
        {
            $card['isOutTime'] = 1;
            if($card['days']>0)
            {
                $card['isOutTime'] = 0;
            }
            switch ($card['vip_card_type'])
            {
                case 1:
                    $card['vip_card_type_str'] = '月卡';
                    break;
                case 2:
                    $card['vip_card_type_str'] = '季度卡';
                    break;
                case 3:
                    $card['vip_card_type_str'] = '半年卡';
                    break;
            }
        }

        $days = VipCardPay::where('user_id',$user_id)->where('status',1)->where('pay_status',1)->sum('days');

        $this->ret['info'] = ['user'=>$user,'count'=>$count,'card'=>$card,'days'=>$days];
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
}
