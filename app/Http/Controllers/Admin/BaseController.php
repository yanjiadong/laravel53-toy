<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $time = null;
    protected $datetime = null;

    public function __construct()
    {
        $this->middleware('checkadmin');
        $this->time = time();
        $this->datetime = date('Y-m-d H:i:s',$this->time);
    }

    public function get_session_info()
    {
        $admin_id = session('admin_id');
        $username = session('username');

        return ['admin_id'=>$admin_id,'username'=>$username];
    }
}
