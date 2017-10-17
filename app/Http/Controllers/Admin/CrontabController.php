<?php

namespace App\Http\Controllers\Admin;

use App\Crontab;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CrontabController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $lists = Crontab::orderBy('id','desc')->paginate(20);

        $menu = 'crontab';
        return view('admin.crontab.index',compact('lists','username'));
    }
}
