<?php

namespace App\Http\Controllers\Api;

use App\UserAddress;
use App\VipCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class UserController extends BaseController
{
    public function add_address(Request $request)
    {
        $data['user_id'] = $request->get('user_id');
        $data['province_id'] = $request->get('province_id');
        $data['city_id'] = $request->get('city_id');
        $data['area_id'] = $request->get('area_id');
        $data['address'] = $request->get('address');
        $data['receiver'] = $request->get('receiver');
        $data['receiver_telephone'] = $request->get('receiver_telephone');

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
        $address_id = $request->get('address_id');

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
        $data['address'] = $request->get('address');
        $data['receiver'] = $request->get('receiver');
        $data['receiver_telephone'] = $request->get('receiver_telephone');

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
            ->select('user_addresses.*','p.name as province_name','c.name as city_name','a.name as area_name')
            ->leftJoin('areas as p', 'p.id', '=', 'user_addresses.province_id')
            ->leftJoin('areas as c', 'c.id', '=', 'user_addresses.city_id')
            ->leftJoin('areas as a', 'a.id', '=', 'user_addresses.area_id')
            ->first();

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
