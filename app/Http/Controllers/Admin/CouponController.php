<?php

namespace App\Http\Controllers\Admin;

use App\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $coupons = Coupon::paginate(20);
        $menu = 'coupon';

        return view('admin.coupon.index',compact('coupons','username','menu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];
        $menu = 'coupon';

        return view('admin.coupon.create',compact('username','menu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['title'] = $request->get('title');
        $data['type'] = $request->get('type');
        $data['price'] = $request->get('price');
        $data['start_time'] = $request->get('start_time');
        $data['end_time'] = $request->get('end_time');
        $data['condition'] = $request->get('condition');

        Coupon::create($data);
        return alert(route('coupons.index'),1);
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
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];
        $menu = 'coupon';

        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon.edit',compact('username','menu','coupon'));
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
        $data['title'] = $request->get('title');
        $data['type'] = $request->get('type');
        $data['price'] = $request->get('price');
        $data['start_time'] = $request->get('start_time');
        $data['end_time'] = $request->get('end_time');
        $data['condition'] = $request->get('condition');

        Coupon::where('id',$id)->update($data);
        return alert(route('coupons.index'),1);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Coupon::destroy($id);
        return alert('',1);
    }
}
