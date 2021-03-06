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
    <p>平台将尽快安排发货，请耐心等待</p>
    <div class="btn">
        <button class="fl" onclick="goIndex()">返回首页</button>
        <button class="fr" onclick="goodDetail()">查看订单</button>
    </div>
</div>

<script>
    //获取购物车数量
    var user_id='{{$user_id}}';
    var get_url = '{{url('api/user/get_cart_order_num')}}';
    common.getCarAndOrder(get_url,user_id);

    function goodDetail() {
        location.href="{{url('wechat/index/order_detail')}}"+'/'+'{{$order->code}}';
    }
    function goIndex() {
        location.href="{{url('/wechat/index/index')}}";
    }
    $(function () {
        $(".toys-car").height($(window).height());
        pushHistory();
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            location.href='{{url('/wechat/index/index')}}';  //在这里指定其返回的地址
        }, false);
    })
    function pushHistory() {
        var state = {
            title: "title",
            url: "{{url('wechat/index/order_success')}}"+'/'+'{{$order_code}}'
        };
        window.history.pushState(state, state.title, state.url);
    }
</script>
</body>
</html>