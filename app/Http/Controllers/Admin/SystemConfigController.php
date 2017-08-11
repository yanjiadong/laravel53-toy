<?php

namespace App\Http\Controllers\Admin;

use App\SystemConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SystemConfigController extends BaseController
{
    public function index()
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];


        $info = SystemConfig::where('type',1)->first();
        $content = [];
        if(!empty($info->content))
        {
            $content = json_decode($info->content,true);
        }

        $menu = 'dictionary';
        return view('admin.system_config.index',compact('content','username','menu'));
    }

    public function store(Request $request)
    {
        $config = $request->get('config');
        SystemConfig::create(['type'=>1,'content'=>json_encode($config)]);
        alert('',1);
    }
}
