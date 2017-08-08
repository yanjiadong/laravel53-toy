<?php

namespace App\Http\Controllers\Api;

use App\Area;
use App\Banner;
use App\Category;
use App\Good;
use App\TelephoneCode;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends BaseController
{
    public function __construct()
    {

    }

    public function index()
    {
        $categorys = Category::all();
        $banners = Banner::all();
        $new_goods = Good::with(['category_tag'])->where(['is_new'=>1,'status'=>Good::STATUS_ON_SALE])->first();
        $goods = Good::with(['category_tag'])->limit(4)->get();

        return ['code'=>200,'msg'=>['categorys'=>$categorys,'banners'=>$banners,'new_goods'=>$new_goods,'goods'=>$goods]];
    }

    public function get_telephone_code(Request $request)
    {
        $telephone = $request->get('telephone');
        if(!isMobile($telephone))
        {
            $this->ret = ['code'=>300,'msg'=>'输入的手机号有误'];
            return $this->ret;
        }

        $start_time = date('Y-m-d 00:00:00');
        $end_time = date('Y-m-d 23:59:59');

        $count = TelephoneCode::where('created_at','>=',$start_time)->where('created_at','<=',$end_time)->where('telephone',$telephone)->count();
        if($count>=env('DAY_SMS_COUNT'))
        {
            $this->ret = ['code'=>300,'msg'=>'今日获取验证码次数已达上限,请明日再试'];
            return $this->ret;
        }

        $user = User::where(['telephone'=>$telephone,'status'=>1])->first();
        if(!empty($user))
        {
            $this->ret = ['code'=>300,'msg'=>'输入的手机号已存在'];
            return $this->ret;
        }

        $data['code'] = mt_rand(100000,999999);
        $data['telephone'] = $telephone;
        $data['is_used'] = 1;
        TelephoneCode::create($data);

        //todo 接入短信接口发送
        //$this->send_sms($telephone,$data['code']);

        $this->ret['msg'] = '验证码发送成功';
        return $this->ret;
    }

    public function bind_telephone(Request $request)
    {
        $telephone = $request->get('telephone');
        $code = $request->get('code');
        $wechat_openid = $request->get('wechat_openid');

        if(empty($telephone) || !isMobile($telephone))
        {
            $this->ret = ['code'=>300,'msg'=>'输入的手机号有误'];
            return $this->ret;
        }

        $pattern = "/^[0-9]{6}$/";
        if(empty($code) || !preg_match($pattern,$code))
        {
            $this->ret = ['code'=>300,'msg'=>'输入的短信验证码有误'];
            return $this->ret;
        }

        $user = User::where(['telephone'=>$telephone,'status'=>1])->first();
        if(!empty($user))
        {
            $this->ret = ['code'=>300,'msg'=>'输入的手机号已存在'];
            return $this->ret;
        }

        $telephone_code = TelephoneCode::where('telephone',$telephone)->limit(1)->orderBy('id','desc')->first();

        if($telephone_code->is_used == 1 && $telephone_code->code==$code)
        {
            TelephoneCode::where('id',$telephone_code->id)->update(['is_used'=>2]);

            $ret = User::where('wechat_openid',$wechat_openid)->update(['telephone'=>$telephone]);
            if($ret)
            {
                $this->ret['msg'] = '绑定手机号码成功';
                return $this->ret;
            }
        }

        $this->ret = ['code'=>300,'msg'=>'请输入正确的手机号或验证码'];
        return $this->ret;
    }

    public function get_area($fid = 0)
    {
        $areas = Area::where(['fid'=>$fid])->get();
        $this->ret['info'] = $areas;
        return $this->ret;
    }

}
