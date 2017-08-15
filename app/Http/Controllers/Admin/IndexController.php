<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Support\Facades\Validator;
use Crypt;

class IndexController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];
        return view('admin.index.index',compact('username'));
    }

    public function setting()
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];
        return view('admin.index.setting',compact('username'));
    }

    public function update_setting(Request $request)
    {
        $rules = [
            'old_password'=>'required|min:6',
            'password'=>'required|min:6|confirmed'
        ];
        $messages = [
            'old_password.required'=>'原始密码不能为空',
            'old_password.min'=>'原始密码至少6个字符',
            'password.required'=>'新密码不能为空',
            'password.min'=>'新密码至少6个字符',
            'password.confirmed'=>'新密码与确认密码不一致'
        ];

        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails())
        {
            $message_arr = [];
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                $message_arr[] = $message.'<br/>';
            }
            return response()->json(['code'=>300,'message'=>implode('',$message_arr)]);
        }

        $admin_info = $this->get_session_info();

        $admin = Admin::where('id',$admin_info['admin_id'])->first();
        $password = Crypt::decrypt($admin->password);  //解密


        if($password !== $request->get('old_password'))
        {
            return response()->json(['code'=>300,'message'=>'原始密码错误']);
        }

        Admin::where('id',$admin_info['admin_id'])->update(['password'=>Crypt::encrypt($request->get('password'))]);
        return response()->json(['success'=>1,'code'=>200,'message'=>'密码修改成功']);
    }
}
