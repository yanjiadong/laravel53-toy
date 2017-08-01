<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use Crypt;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Support\Facades\Validator;


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

        if($request->get('captcha') != session('captcha'))
        {
            return response()->json(['code'=>300,'message'=>'请输入正确的验证码']);
        }

        $password = Crypt::encrypt($request->get('password'));

        $admin_info = Admin::where('username',$request->get('username'))->first();

        $password = Crypt::decrypt($admin_info->password);  //解密

        if($request->get('password') === $password)
        {
            //session()->flash('success', '登录成功,欢迎回来');
            session(['admin_id'=>$admin_info->id,'username'=>$admin_info->username]);
            return response()->json(['code'=>200,'url'=>route('admin.index.index')]);
        }
        else
        {
            return response()->json(['code'=>300,'message'=>'账号或者密码错误']);
        }
    }

    /**
     * 获取验证码
     * @param $tmp
     */
    public function captcha($tmp)
    {
        $phrase = new PhraseBuilder;
        // 设置验证码位数
        $code = $phrase->build(4);

        $builder = new CaptchaBuilder($code, $phrase);
        $builder->build(100,30);
        // 获取验证码的内容
        $captcha = $builder->getPhrase();

        session(['captcha'=>$captcha]);
        // 生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }

    public function logout()
    {
        session(['admin_id'=>'','username'=>'']);
        return redirect()->route('admin.login.index');
    }

    public function test()
    {
        return Admin::create([
            'username'=>'admin',
            'password'=>Crypt::encrypt('111111'),
            'status'=>1,
            'salt'=>''
        ]);
    }
}
