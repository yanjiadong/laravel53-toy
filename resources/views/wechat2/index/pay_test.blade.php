<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>订单支付</title>
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
<input type="text" value="">
<button id="submit">提交订单</button>
<input type="hidden" id="jsApiParameters" value="">
<script>
    //调用微信JS api 支付
    function jsApiCall()
    {
        var jsApiParameters = $("#jsApiParameters").val();
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest', jsApiParameters,
            function(res){
                WeixinJSBridge.log(res.err_msg);
                //alert(res.err_msg);
                //alert(res.err_code+res.err_desc+res.err_msg);
                if(res.err_msg === "get_brand_wcpay_request:ok") {

                }
                else if(res.err_msg === "get_brand_wcpay_request:cancel")
                {
                    location.href=document.referrer;
                }
                else
                {
                    window.history.go(-1);
                }
            }
        );
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
        $("#submit").click(function () {
            common.httpRequest('{{url('wechat/index/pay_test')}}','post',{},function (res) {
                $("#jsApiParameters").val(res.jsApiParameters);
            });
            callpay();
        });
    });
</script>
</body>
</html>