<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\VipCardPay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VipCardPayController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];
        $status = $request->get('status');

        if($status)
        {
            $users = VipCardPay::with(['user','vip_card'])->where('status',$status)->paginate(20);
        }
        else
        {
            $users = VipCardPay::with(['user','vip_card'])->paginate(20);
        }

        $menu = 'vip_card_pay';

        return view('admin.vip_card_pay.index',compact('users','username','menu','status'));
    }

    public function action(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');

        $info = VipCardPay::find($id);

        $user_info = User::find($info->user_id);

        VipCardPay::where('id',$id)->update(['status'=>$status]);

        /*if($info->days > 0)
        {
            $user_days = $user_info->days - $info->days;
            User::where('id',$info->user_id)->update(['days'=>$user_days]);

            VipCardPay::where('id',$id)->update(['status'=>$status,'days'=>0]);

            $vip_card_count = VipCardPay::where(['user_id'=>$info->user_id,'pay_status'=>1,'status'=>1])->count();
            if($vip_card_count <= 0)
            {
                User::where('id',$info->user_id)->update(['is_vip'=>0]);
            }
        }
        else
        {
            VipCardPay::where('id',$id)->update(['status'=>$status]);
        }*/

        alert('',1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
