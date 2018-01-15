<?php

namespace App\Http\Controllers\Api;

use App\Express;
use App\ExpressInfo;
use App\Utility\JuheExp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpressInfoController extends BaseController
{
    public function index(Request $request)
    {
        $post_data = array();
        $post_data["schema"] = 'json' ;

        $param['company'] = $request->get('company');
        $param['number'] = $request->get('number');
        $param['from'] = '';
        $param['to'] = '';
        $param['key'] = 'dLSbEmyh1644';
        $param['parameters']['callbackurl'] = route('api.express_info.callback');
//callbackurl请参考callback.php实现，key经常会变，请与快递100联系获取最新key
        //$post_data["param"] = '{"company":"yunda", "number":"3805420027268","from":"", "to":"", "key":"dLSbEmyh1644", "parameters":{"callbackurl":"http://www.yourdmain.com/kuaidi"}}';
        $post_data["param"] = json_encode($param);

        $url='http://www.kuaidi100.com/poll';

        $o="";
        foreach ($post_data as $k=>$v)
        {
            $o.= "$k=".urlencode($v)."&";		//默认UTF-8编码格式
        }

        $post_data=substr($o,0,-1);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $result = curl_exec($ch);		//返回提交结果，格式与指定的格式一致（result=true代表成功）
        return $result;
    }

    public function callback()
    {
        //订阅成功后，收到首次推送信息是在5~10分钟之间，在能被5分钟整除的时间点上，0分..5分..10分..15分....
        $param=$_POST['param'];

        //$param = '{"status":"shutdown","billstatus":"check","message":"","autoCheck":"0","comOld":"","comNew":"","lastResult":{"message":"ok","nu":"3805420027268","ischeck":"1","condition":"F00","com":"yunda","status":"200","state":"3","data":[{"time":"2017-08-07 12:44:56","ftime":"2017-08-07 12:44:56","context":"[江苏苏州吴中区郭巷公司纳米园便民寄存分部]快件已被 已签收 签收"},{"time":"2017-08-07 08:40:07","ftime":"2017-08-07 08:40:07","context":"[江苏苏州吴中区郭巷公司纳米园便民寄存分部]进行派件扫描；派送业务员：高海科；联系电话：18068022005"},{"time":"2017-08-06 08:16:54","ftime":"2017-08-06 08:16:54","context":"进行快件扫描，将发往：江苏苏州吴中区郭巷公司纳米园便民寄存分部"},{"time":"2017-08-06 05:43:25","ftime":"2017-08-06 05:43:25","context":"[江苏苏州分拨中心]从站点发出，本次转运目的地：江苏苏州吴中区郭巷公司"},{"time":"2017-08-06 04:29:35","ftime":"2017-08-06 04:29:35","context":"[江苏苏州分拨中心]在分拨中心进行卸车扫描"},{"time":"2017-08-05 18:18:52","ftime":"2017-08-05 18:18:52","context":"[江苏徐州分拨中心]进行装车扫描，即将发往：江苏苏州分拨中心"},{"time":"2017-08-05 18:15:38","ftime":"2017-08-05 18:15:38","context":"[江苏徐州分拨中心]在分拨中心进行称重扫描"},{"time":"2017-08-05 16:12:37","ftime":"2017-08-05 16:12:37","context":"[江苏徐州贾汪区公司]进行揽件扫描"},{"time":"2017-08-05 15:21:46","ftime":"2017-08-05 15:21:46","context":"[江苏徐州贾汪区公司]进行下级地点扫描，将发往：江苏苏州网点包"},{"time":"2017-08-05 13:51:04","ftime":"2017-08-05 13:51:04","context":"[江苏徐州贾汪区公司]进行揽件扫描"}]}}';
        $param_arr = json_decode($param,true);

        //"state":"0", /*快递单当前签收状态，包括0在途中、1已揽收、2疑难、3已签收、4退签、5同城派送中、6退回、7转单等7个状态，其中4-7需要另外开通才有效，详见章2.3.3 */
        $nu = isset($param_arr['lastResult']['nu'])?$param_arr['lastResult']['nu']:'';
        $state = isset($param_arr['lastResult']['state'])?$param_arr['lastResult']['state']:'';
        ExpressInfo::create(['nu'=>$nu,'content'=>$param,'state'=>$state]);

        try{
            //$param包含了文档指定的信息，...这里保存您的快递信息,$param的格式与订阅时指定的格式一致
            echo  '{"result":"true","returnCode":"200","message":"成功"}';
            //要返回成功（格式与订阅时指定的格式一致），不返回成功就代表失败，没有这个30分钟以后会重推
        }
        catch(Exception $e)
        {
            echo  '{"result":"false","returnCode":"500","message":"失败"}';
            //保存失败，返回失败信息，30分钟以后会重推
        }
    }

    public function com(Request $request)
    {
        //$num = '450909000804';
        $num = $request->get('num');
        $url = "http://www.kuaidi100.com/autonumber/auto?num={$num}&key=dLSbEmyh1644";
        $result = weixinCurl($url);

        $com = '';
        $title = '';
        if(!empty($request) && !empty($result[0]))
        {
            $com = $result[0]['comCode'];
            $express = Express::where('com',$com)->first();
            if(!empty($express))
            {
                $title = $express->title;
            }
        }

        if(empty($title) || empty($com))
        {
            $this->ret['code'] = 300;
            $this->ret['msg'] = '';
            return $this->ret;
        }
        //print_r($result);
        $this->ret['info'] = ['com'=>$com,'title'=>$title];
        return $this->ret;

    }

    public function get_juhe_coms()
    {
        $params = array(
            'key' => '50699e84ef775876e51cf65f2dca7ebd', //您申请的快递appkey
        );
        $exp = new JuheExp($params['key']);
        $result = $exp->getComs();
        print_r($result);
    }

    public function get_info(Request $request)
    {
        $params = array(
            'key' => '50699e84ef775876e51cf65f2dca7ebd', //您申请的快递appkey
            'com' => 'sf', //快递公司编码，可以通过$exp->getComs()获取支持的公司列表
            'no'  => '240239532696' //快递编号
        );

        $exp = new JuheExp($params['key']);
        $result = $exp->query($params['com'],$params['no']); //执行查询

        print_r($result);
        if($result['error_code'] == 0){//查询成功
            $list = $result['result']['list'];
            print_r($list);
        }else{
            echo "获取失败，原因：".$result['reason'];
        }

        die;
        $param = [
            'com'=>'shunfeng',
            'num'=>'240239532641'
        ];
        $post_data = array();
        $post_data["customer"] = '564B05790C18B954AC4D4198B54B4948';
        $key= 'dLSbEmyh1644' ;
        $post_data["param"] = json_encode($param);

        $url='http://poll.kuaidi100.com/poll/query.do';
        $post_data["sign"] = md5($post_data["param"].$key.$post_data["customer"]);
        $post_data["sign"] = strtoupper($post_data["sign"]);
        $o="";
        foreach ($post_data as $k=>$v)
        {
            $o.= "$k=".urlencode($v)."&";		//默认UTF-8编码格式
        }
        $post_data=substr($o,0,-1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $result = curl_exec($ch);
        $data = str_replace("\&quot;",'"',$result );
        //echo $data;
        //$data = json_decode($data,true);
        //echo $data;
    }
}
