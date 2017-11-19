<?php

namespace App\Http\Controllers\Admin;

use App\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function province()
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $provinces = Area::where('area',Area::TYPE_AREA_PROVINCE)->get();
        $menu = 'dictionary';
        return view('admin.area.province',compact('provinces','username','menu'));
    }

    public function add_province()
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $menu = 'dictionary';
        return view('admin.area.add_province',compact('username','menu'));
    }

    public function store_province(Request $request)
    {
        Area::create(['name'=>$request->get('name'),'area'=>Area::TYPE_AREA_PROVINCE,'fid'=>0,'first'=>strtoupper($request->get('first'))]);
        return alert(route('admin.areas.province'),1);
    }

    public function edit_province($id)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $menu = 'dictionary';

        $province = Area::find($id);
        return view('admin.area.edit_province',compact('username','menu','province'));
    }

    public function update_province(Request $request)
    {
        Area::where('id',$request->get('id'))->update(['name'=>$request->get('name'),'first'=>strtoupper($request->get('first'))]);
        return alert(route('admin.areas.province'),1);
    }

    public function del_province(Request $request)
    {
        $id = $request->get('id');
        $info = Area::where('fid',$id)->first();
        if(!empty($info))
        {
            alert('请先删除下级数据后再操作');
        }

        Area::destroy($id);
        return alert('',1);
    }

    public function city($fid)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $province = Area::find($fid);

        $citys = Area::where('fid',$fid)->where('area',Area::TYPE_AREA_CITY)->get();
        $menu = 'dictionary';

        return view('admin.area.city',compact('citys','username','menu','province','fid'));
    }

    public function add_city($fid)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $province = Area::find($fid);

        $menu = 'dictionary';

        return view('admin.area.add_city',compact('username','menu','province','fid'));
    }

    public function store_city(Request $request)
    {
        $fid = $request->get('fid');

        Area::create(['name'=>$request->get('name'),'area'=>Area::TYPE_AREA_CITY,'fid'=>$fid]);
        return alert(route('admin.areas.city',['fid'=>$fid]),1);
    }

    public function edit_city($id)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $city = Area::find($id);

        $province = Area::find($city->fid);
        $menu = 'dictionary';

        return view('admin.area.edit_city',compact('username','menu','city','fid','province'));
    }

    public function update_city(Request $request)
    {
        $fid = $request->get('fid');
        Area::where('id',$request->get('id'))->update(['name'=>$request->get('name')]);
        return alert(route('admin.areas.city',['fid'=>$fid]),1);
    }

    public function del_city(Request $request)
    {
        $id = $request->get('id');
        $info = Area::where('fid',$id)->first();
        if(!empty($info))
        {
            alert('请先删除下级数据后再操作');
        }
        //print_r($info);
        Area::destroy($id);
        return alert('',1);
    }

    public function area($fid)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $city = Area::find($fid);
        $province = Area::find($city->fid);

        $areas = Area::where('fid',$fid)->where('area',Area::TYPE_AREA_AREA)->get();
        $menu = 'dictionary';

        return view('admin.area.area',compact('areas','username','menu','province','fid','city'));
    }

    public function add_area($fid)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $city = Area::find($fid);
        $province = Area::find($city->fid);

        $menu = 'dictionary';

        return view('admin.area.add_area',compact('username','menu','province','fid','city'));
    }

    public function store_area(Request $request)
    {
        $fid = $request->get('fid');

        Area::create(['name'=>$request->get('name'),'area'=>Area::TYPE_AREA_AREA,'fid'=>$fid]);
        return alert(route('admin.areas.area',['fid'=>$fid]),1);
    }

    public function edit_area($id)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $area = Area::find($id);
        $city = Area::find($area->fid);
        $province = Area::find($city->fid);

        $menu = 'dictionary';
        return view('admin.area.edit_area',compact('username','menu','province','city','area'));
    }

    public function update_area(Request $request)
    {
        $fid = $request->get('fid');

        Area::where('id',$request->get('id'))->update(['name'=>$request->get('name')]);
        return alert(route('admin.areas.area',['fid'=>$fid]),1);
    }

    public function del_area(Request $request)
    {
        $id = $request->get('id');
        $info = Area::where('fid',$id)->first();
        if(!empty($info))
        {
            alert('请先删除下级数据后再操作');
        }

        Area::destroy($id);
        return alert('',1);
    }
}
