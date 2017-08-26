<?php

namespace App\Http\Controllers\Admin;

use App\VipCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VipCardController extends BaseController
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

        $cards = VipCard::get();
        $menu = 'vip_card';

        return view('admin.vip_card.index',compact('cards','username','menu'));
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
        $menu = 'vip_card';

        return view('admin.vip_card.create',compact('username','menu'));
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
        $data['days'] = $request->get('days');
        $data['price'] = $request->get('price');
        $data['money'] = $request->get('money');

        VipCard::create($data);
        return alert(route('vip_cards.index'),1);
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
        $menu = 'vip_card';

        $card = VipCard::findOrFail($id);
        return view('admin.vip_card.edit',compact('username','menu','card'));
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
        $data['days'] = $request->get('days');
        $data['price'] = $request->get('price');
        $data['money'] = $request->get('money');

        VipCard::where('id',$id)->update($data);
        return alert(route('vip_cards.index'),1);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        VipCard::destroy($id);
        return alert('',1);
    }
}
