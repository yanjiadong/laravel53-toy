<!DOCTYPE html>
<html lang="en" class="bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>提现</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">
    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
</head>
<body class="bg-white">
<div class="cash-wrap">
    <div class="top">提现到原支付账户</div>
    <h3>提现金额</h3>
    <h1></h1>
    <p></p>
    <div class="footer">
        <p>确认提现后，提现金额将于0-5个工作日退还到原支付账户</p>
        <button onclick="cash.getCash()">确认提现</button>
    </div>
</div>


<script>
    var cash={
        data:{
            money:"{{$user->can_use_money}}",
            money2:"{{$user->not_can_use_money}}"
        },
        init:function () {
            $(".cash-wrap>h1").text('¥'+cash.data.money);
            $(".cash-wrap>p").text('剩余冻结押金：￥'+cash.data.money+'（不可提现）');
        },
        getCash:function () {
            common.httpRequest('../js/test.json','get',null,function (res) {
                res={success:true,error:'操作超时，请稍后重试！'};
                if(res.success){
                    location.href='cash_success.html?money='+cash.data.money;
                }else{
                    common.alert_tip(res.error);
                }
            })
        }
    };
    $(function () {
        cash.init();
    })
</script>
</body>
</html>