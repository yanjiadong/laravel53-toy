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
        $certNo = '320525199201247711';

        $url = TestZhimaAuthInfoAuthorize($name,$certNo);
        Header("Location: $url");
        //echo $url;
    }

    public function zmxy(Request $request)
    {
        $params = $request->get('params');
        $sign = $request->get('sign');

        //$result = TestZhimaGetResult($params,$sign);

        $user_id = '3';
        $result = 'open_id=268817768944808448617928815&error_message=%E6%93%8D%E4%BD%9C%E6%88%90%E5%8A%9F&state=%E5%95%86%E6%88%B7%E8%87%AA%E5%AE%9A%E4%B9%89&error_code=SUCCESS&app_id=300000622&success=true';
        //Zmxy::create(['user_id'=>$user_id,'info'=>$result]);

        $open_id = '';

        $result_arr = explode('&',$result);
        if(isset($result_arr[3]) && $result_arr[3])
        {
            $error_code_arr = explode('=',$result_arr[3]);
            if(isset($error_code_arr[1]) && $error_code_arr[1] == 'SUCCESS')
            {
                $open_id_arr = explode('=',$result_arr[0]);
                $open_id = $open_id_arr[1];
            }
        }


        print_r($open_id);
    }
}
