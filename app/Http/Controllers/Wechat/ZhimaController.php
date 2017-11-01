<?php

namespace App\Http\Controllers\Wechat;

use App\Zmxy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZhimaController extends BaseController
{
    public function test()
    {
        $name = '严佳冬';
        $certNo = '320525199201247713';

        $url = TestZhimaAuthInfoAuthorize($name,$certNo);
        Header("Location: $url");
        //echo $url;
    }

    public function zmxy(Request $request)
    {
        $params = $request->get('params');
        $sign = $request->get('sign');


        $result = TestZhimaGetResult($params,$sign);

        $user_id = '3';

        Zmxy::create(['user_id'=>$user_id,'info'=>$result]);
    }
}
