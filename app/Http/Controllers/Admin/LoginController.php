<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $rules = [
            'username'=>'required',
            'password'=>'required|min:6'
        ];

        $messages = [
            'username.required'=>'用户名不能为空',
            'password.min'=>'密码至少6个字符',
            'password.required'=>'密码不能为空',
        ];

        $this->validate($request,$rules,$messages);

        
    }
}
