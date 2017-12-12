<?php

namespace App\Http\Controllers\Wechat2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZhimaController extends Controller
{
    public function test()
    {
        $name = '严佳冬';
        $certNo = '320525199201247713';
        $result = TestZhimaCustomerCertificationQuery($name,$certNo);
        //print_r($result);
        $info = json_decode($result ,true);  //{"success":true,"biz_no":"ZM201712123000000212100730089613"}

        $redirect_url = url('wechat2/index/zmxy/face');
        $url = TestZhimaCustomerCertificationCertify($info['biz_no'],$redirect_url);
        Header("Location: $url");
    }

    public function face(Request $request)
    {
        print_r($request);
    }
}
