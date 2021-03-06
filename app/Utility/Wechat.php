<?php
namespace App\Utility;

use Illuminate\Support\Facades\DB;

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
        //slog('hello world');
        //$text = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><FromUserName><![CDATA[FromUser]]></FromUserName><CreateTime>123456789</CreateTime><MsgType><![CDATA[event]]></MsgType><Event><![CDATA[subscribe]]></Event></xml>";
        //$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postStr = file_get_contents('php://input');

        if(!empty($postStr))
        {
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $msgType = trim($postObj->MsgType);

            slog('----'.$msgType.'----');

            $resultStr = '';
            switch($msgType)
            {
                case 'text':
                    //$resultStr = $this->responseText($postObj,'Welcome to wechat world!');
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
        //$wechat_info_setting = DB::table('system_configs')->where('type',2)->first();

        /*$content = [];
        if(!empty($wechat_info_setting->content))
        {
            $content = json_decode($wechat_info_setting->content,true);
        }

        $auto_reply = isset($content[0])?$content[0]:'';
        $back_address = isset($content[1])?$content[1]:'';
        $contact_us = isset($content[2])?$content[2]:'';

        slog($auto_reply);
        slog($back_address);
        slog($contact_us);*/

        $auto_reply = <<<EOT
感谢关注小Q编程\n
孩子的机器人教育从这里开始\n
帮助孩子用玩机器人的方式学习编程，培养未来的创造者。\n
现阶段我们提供全品类的编程教育机器人租赁服务，之后会陆续推出在线课程哦，敬请期待～！[坏笑]
EOT;

        $back_address = <<<EOT
归还时请优先选择「顺丰」物流，将玩具寄回到以下地址[机智]\n
收货人：
小Q / 176-1113-4460\n
收货地址：
北京市 丰台区  新宫家园北区3号楼3单元804
EOT;

        $contact_us = <<<EOT
请通过以下方式联系客服\n
方式1:
直接公众号内发送要咨询的内容，将会有工作人员回复您\n
方式2:
拨打客服热线 400-636-0816
EOT;

        $contentStr = '';
        switch($postObj->Event)
        {
            case 'subscribe':
                //关注
                //$contentStr .= "hi,欢迎关注趣编程,这里有全球最潮流的益智类编程教育玩具，让孩子在玩乐中培养创造与逻辑分析能力，学会未来用编程与世界沟通。每月租金只需299，快来体验吧！";
                $contentStr .= $auto_reply;
                break;
            case 'unsubscribe':
                //取消关注
                break;
            case 'SCAN':
                //已关注扫码
                $contentStr .= "欢迎回来！\n玩的开心！";
                break;
            case 'CLICK':
                if($postObj->EventKey == 'BACK_ADDRESS')
                {
                    $contentStr .= $back_address;
                }
                elseif ($postObj->EventKey == 'CONTACT_US')
                {
                    $contentStr .= $contact_us;
                }
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