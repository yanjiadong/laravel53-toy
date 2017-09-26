<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>支付结果</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
</head>
<body>
<div class="pay-success bg-white">
    <div class="sign">
        <i class="icon-big icon-big-paySuccess"></i>
    </div>
    <div class="money">¥{{$order->price}}</div>
    <p>平台将在24小时内发货，请耐心等待</p>
    <div class="tips">
        <i class="icon-attetion">!</i>
        <span>物品在邮寄途中，会员有效期计时自动暂停</span>
    </div>
    <div class="btn">
        <button onclick="goodDetail()">查看订单详情</button>
    </div>
</div>

<script>
    function goodDetail() {
        location.href="{{url('wechat/index/order_detail')}}"+'/'+'{{$order->code}}';
    }
    $(function () {
        $(".toys-car").height($(window).height());
    })
</script>
</body>
</html>