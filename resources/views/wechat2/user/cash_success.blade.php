<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>提现</title>
    <link href="{{ asset('wechat2/style/reset.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/common.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/style.css') }}" rel="stylesheet" type="text/css">


</head>
<body>
<div class="cash-success bg-white">
    <div class="sign">
        <i class="icon-big icon-big-paySuccess"></i>
    </div>
    <div class="money"></div>
    <div class="tips">押金提现申请已提交</div>
    <p>预计0-5个工作日退还到原支付账户，请注意查收</p>
</div>
<script src="{{ asset('wechat2/js/jquery-1.11.1.min.js') }}"></script>
<script src="{{ asset('wechat2/js/common.js') }}"></script>
<script>
    //var cashDeposit = JSON.parse(localStorage.cashDeposit);
    var cashDeposit = "{{ $order->money - $order->over_days*$order->good_day_price }}";
    $(".cash-success .money").text('¥'+cashDeposit);
</script>

<script>
    $(function () {
        pushHistory();
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            location.href=document.referrer;  //在这里指定其返回的地址
        }, false);
    });
    function pushHistory() {
        var state = {
            title: "title",
            url: "{{url('wechat2/user/cash_success')}}"+'/'+'{{$order->code}}'
        };
        window.history.pushState(state, state.title, state.url);
    }
</script>

</body>
</html>