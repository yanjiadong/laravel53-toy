<?php
namespace App\Utility;

class Wechat
{
    public function __construct()
    {
        include_once __DIR__. "/socketlog/slog.function.php";

        //配置
        slog(array(
            'host'                => 'localhost',//websocket服务器地址，默认localhost
            'optimize'            => false,//是否显示利于优化的参数，如果运行时间，消耗内存等，默认为false
            'show_included_files' => false,//是否显示本次程序运行加载了哪些文件，默认为false
            'error_handler'       => false,//是否接管程序错误，将程序错误显示在console中，默认为false
            'force_client_ids'    => array(//日志强制记录到配置的client_id,默认为空,client_id必须在allow_client_ids中
                'yanjiadong',
                //'client_02',
            ),
            'allow_client_ids'    => array(//限制允许读取日志的client_id，默认为空,表示所有人都可以获得日志。
                'yanjiadong',
                //'client_02',
                //'client_03',
            ),
        ),'config');

    }

    public function responseMsg()
    {
        //$text = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><FromUserName><![CDATA[FromUser]]></FromUserName><CreateTime>123456789</CreateTime><MsgType><![CDATA[event]]></MsgType><Event><![CDATA[subscribe]]></Event></xml>";
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        slog('----'.$postStr.'----');
        if(!empty($postStr))
        {
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $msgType = trim($postObj->MsgType);

            switch($msgType)
            {
                case 'text':
                    $resultStr = $this->responseText($postObj,'Welcome to wechat world!');
                    break;
                case 'event':
                    //订阅事件或者取消订阅事件
                    $resultStr = $this->handleEvent($postObj);
                    break;
                default:
                    break;
            }

            echo $resultStr;
        }
        else
        {
            echo "";
            exit;
        }
    }

    private function handleEvent($postObj)
    {
        $contentStr = '';
        switch($postObj->Event)
        {
            case 'subscribe':
                $contentStr .= "hi,欢迎关注趣编程,这里有全球最潮流的益智类编程教育玩具，让孩子在玩乐中培养创造与逻辑分析能力，学会未来用编程与世界沟通。每月租金只需299，快来体验吧！";
                break;
            case 'unsubscribe':
                break;
        }

        $resultStr = $this->responseText($postObj, $contentStr);
        return $resultStr;
    }

    private function responseText($postObj, $contentStr)
    {
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";
        $resultStr = sprintf($textTpl, $postObj->FromUserName, $postObj->ToUserName, time(), $contentStr);
        return $resultStr;
    }
}