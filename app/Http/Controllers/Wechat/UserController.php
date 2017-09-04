<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function center()
    {
        return view('wechat.user.center');
    }

    public function help()
    {
        return view('wechat.user.help');
    }
}
