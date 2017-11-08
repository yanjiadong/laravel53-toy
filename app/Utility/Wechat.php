<?php
namespace App\Utility;

class Wechat
{
    public function responseMsg()
    {
        //$text = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><FromUserName><![CDATA[FromUser]]></FromUserName><CreateTime>123456789</CreateTime><MsgType><![CDATA[event]]></MsgType><Event><![CDATA[subscribe]]></Event></xml>";
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

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