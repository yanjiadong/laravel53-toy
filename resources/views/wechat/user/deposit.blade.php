<!DOCTYPE html>
<html lang="en" class="bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>会员押金</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
</head>
<body class="bg-white">
<div class="deposit-wrap">
    <div class="deposit-main">
        <div class="top">
            押金为使用小叮当玩具的保证金，在当前会员的有效期内会被冻结，您可以在当前会员卡到期后手动申请提现退还押金
        </div>
        <div class="cont">
            <h4>会员押金</h4>
            <h1></h1>
            <div class="extract"></div>
        </div>
        <div class="look">
            <span onclick="deposit.lookDetail()">查看押金明细</span> <i class="icon icon_arrowRight_bold"></i>
        </div>
    </div>
    <div class="footer">
        <button onclick="deposit.getCash()">提现</button>
    </div>
</div>


<script>
    var deposit={
        data:{
            money:common.getParam('yajin'),
            id:common.getParam('id'),
            cashState:common.getParam('cashState')
        },
        init:function () {
            $(".deposit-main h1").text("￥" + parseFloat(deposit.data.money).toFixed(2));
            $(".deposit-main .extract").text("可提现金额：￥" + parseFloat(deposit.data.money).toFixed(2));
            if(!eval(deposit.data.cashState)){
                $('.deposit-wrap .footer button').removeClass('active');
            }else{
                $('.deposit-wrap .footer button').addClass('active');
            }
        },
        //查看详情
        lookDetail:function () {
            location.href="{{url('wechat/user/deposit_list')}}";
        },
        //提现
        getCash:function () {
            if($('.deposit-wrap .footer button').hasClass('active')){
                location.href='cash.html?money='+deposit.data.money;
            }
        }
    };
    $(function () {
        deposit.init();
    })
</script>
</body>
</html>