<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>选择会员类型</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
    <!--微信js-sdk-->
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
</head>
<body>

<script>
    //调用微信JS api 支付
    function jsApiCall()
    {
        <?php if(isset($jsApiParameters)):?>
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest',
            <?php echo $jsApiParameters; ?>,
            function(res){
                WeixinJSBridge.log(res.err_msg);
                alert(res.err_msg);
                //alert(res.err_code+res.err_desc+res.err_msg);
                if(res.err_msg === "get_brand_wcpay_request:ok") {
                    var out_trade_no = '{{$out_trade_no}}';

                    common.httpRequest('{{url('wechat/index/pay_vip_card_callback')}}','post',{out_trade_no:out_trade_no},function (res) {
                        //支付成功
                        var url = '{{url('wechat/user/center')}}';
                        common.alert_tip("支付成功",'#323232','支付成功',function () {
                            {{--{{ WxJsPayCallback($out_trade_no) }}--}}
                                location.href=url;
                        });
                    });

                }
                else
                {
                    //alert(res.err_code);
                    alert('支付失败');
                    //layer_btn_msg('支付失败');
                }
            }
        );
        <?php endif;?>
    }

    function callpay()
    {
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        }else{
            jsApiCall();
        }
    }

    $(function () {
        callpay();
    })
</script>
</body>
</html>