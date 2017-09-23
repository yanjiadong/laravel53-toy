<?php if ( !defined('BASEPATH') ) exit('No direct script access allowed');

require_once(__DIR__ . '/lib/WxPayApi.php');
require_once(__DIR__ . '/log.php');

//初始化日志
$logHandler= new CLogFileHandler(FCPATH."logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

class Sendredpack extends WxPayDataBase
{
    private $url;

    public function __construct()
    {
        //设置接口链接
        $this->url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";
    }

    public function postXml($total_fee, $order_sn, $openid)
    {
        header("content-type:text/html;charset=utf-8");
        $ci = &get_instance();

        $total_fee = doubleval($total_fee*100);

        $this->values['nonce_str'] = WxPayApi::getNonceStr();
        $this->values['mch_billno'] = $order_sn;
        $this->values['mch_id'] = WxPayConfig::MCHID;
        $this->values['wxappid'] = WxPayConfig::APPID;
        $this->values['send_name'] = '大创科技';
        $this->values['re_openid'] = $openid;
        $this->values['total_amount'] = $total_fee;
        $this->values['total_num'] = 1;
        $this->values['wishing'] = '提现红包';
        $this->values['client_ip'] = $ci->input->ip_address();
        $this->values['act_name'] = '提现红包';
        $this->values['remark'] = '提现红包';


        $this->SetSign();

        //print_r($this->values);
        $xml = $this->ToXml();

        $result = self::postXmlCurl($xml,$this->url,true);

        $data = $this->FromXml($result);
        Log::DEBUG("redpack:" . json_encode($data));

        //print_r($data);
        if($data['result_code']=='SUCCESS')
        {
            //成功
            $result_order_sn = $data['mch_billno'];
            $ci->base_model->update('u_user_encashment',array('order_sn'=>$result_order_sn),array('status'=>1));
        }
        else
        {

        }
    }

    /**
     * 以post方式提交xml到对应的接口url
     *
     * @param string $xml  需要post的xml数据
     * @param string $url  url
     * @param bool $useCert 是否需要证书，默认不需要
     * @param int $second   url执行超时时间，默认30s
     * @throws WxPayException
     */
    private static function postXmlCurl($xml, $url, $useCert = false, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);

        //如果有配置代理这里就设置代理
        if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0"
            && WxPayConfig::CURL_PROXY_PORT != 0){
            curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
            curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
        }
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if($useCert == true){
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT, FCPATH.'pay_key/wx/apiclient_cert.pem');
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY, FCPATH.'pay_key/wx/apiclient_key.pem');
            curl_setopt($ch,CURLOPT_CAINFO, FCPATH.'/pay_key/wx/rootca.pem');
        }
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new WxPayException("curl出错，错误码:$error");
        }
    }

}