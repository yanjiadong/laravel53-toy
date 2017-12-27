<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>提交物流信息</title>
    <link href="{{ asset('wechat2/style/reset.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/common.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/style.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('wechat2/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('wechat2/js/main.js') }}"></script>
    <script src="{{ asset('wechat2/js/common.js') }}"></script>
    <style>
        html{
            background-color: #fff;
        }
    </style>
</head>
<body>
<div class="return-success-wrap">
    <div class="return-success-main">
        <div class="return-cont">
            <img src="/wechat2/image/common/return_success.png">
            <div class="success-tip">归还申请已提交</div>
            <div class="tips">
                在平台收货并确认后，才可以申请押金提现哦<br>
                < 如物品有损坏需提前联系客服沟通 >
            </div>
            <div class="bottom-pic">
                <img src="/wechat2/image/common/return_success1.png" >
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        //让会员卡回退到个人中心 或者首页
        pushHistory();
        /*----------避免下一页返回这一页调用这个函数-------------*/
        var bool=false;
        setTimeout(function(){
            bool=true;
        },500);
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            if(bool) {
                location.href="{{ route('wechat2.index.order_list') }}";
            }
        }, false);
    });
    function pushHistory() {
        var state = {
            title: "title",
            url: ''
        };
        window.history.pushState(state, state.title, state.url);
    }
</script>
</body>
</html>
