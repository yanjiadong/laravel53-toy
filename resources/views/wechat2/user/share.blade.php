<!DOCTYPE html  class="bg-white">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>分享</title>
    <link href="{{ asset('wechat2/style/reset.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/common.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/style.css') }}" rel="stylesheet" type="text/css">

</head>
<body class="bg-white">
<div class="share-wrap">
    <div class="share-main">
        <img class="share-img" src="/wechat2/image/common/share.png" alt="">
        <img class="share-btn" src="/wechat2/image/common/share-btn.png" onclick="share.immediately()">
    </div>
</div>
<div class="share-wrap-cover-wrap">
    <i class="icon-big icon-big-share"></i>
    <div class="share-wrap-cover-main">
        <p class="tips">
            请点击右上角，选择“发送给朋友”或“分享到朋友圈”
        </p>
        <div class="share-img">
            <i class="icon-big icon-big-share-friend"></i>
            <i class="icon-big icon-big-share-moment"></i>
        </div>
    </div>
</div>

<script src="{{ asset('wechat2/js/jquery-1.11.1.min.js') }}"></script>
<script src="{{ asset('wechat2/js/main.js') }}"></script>
<script src="{{ asset('wechat2/js/common.js') }}"></script>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>

<script>
    var share={
        data:{
            name:"{{ $user->wechat_nickname }}",
            num:" {{ $count }}"
        },
        init:function () {
            $('.share-main>h3.name').text(share.data.name);
            $('.share-main>p').text('我在“趣编程”免费玩了'+share.data.num+'个编程机器人');
        },
        //立即分享
        immediately:function () {
            var $cove_wrap = $(".share-wrap-cover-wrap");
            $cove_wrap.fadeIn(500);
            $cove_wrap.click(function (event) {
                if(event.target.className.toLowerCase() =="share-wrap-cover-wrap"){
                    $cove_wrap.hide();
                }
            })
        }
    };
    $(function () {
        share.init();
        $(".invitation").css('marginTop',($(window).outerHeight()-20-$(".share-main").outerHeight()-$(".footer").outerHeight()-$(".invitation").height())/2+'px');

        //通过config接口注入权限验证配置
        wx.config({
            debug: false,
            appId: '{{$signPackage["appId"]}}',
            timestamp: '{{$signPackage["timestamp"]}}',
            nonceStr: '{{$signPackage["nonceStr"]}}',
            signature: '{{$signPackage["signature"]}}',
            jsApiList: [
                'onMenuShareAppMessage',
                'onMenuShareTimeline',
                'scanQRCode'
            ]
        });

        wx.ready(function(){
            wx.onMenuShareTimeline({
                title: '小Q编程', // 分享标题
                link:"{{ route('wechat2.user.share_open',['user_id'=>$user_id]) }}",
                //link: '{{url('wechat2/user/share_open')}}'+'/'+'{{$user_id}}', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: 'http://toy.yanjiadong.net/wechat2/image/common/order-list-logo.png', // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });

            wx.onMenuShareAppMessage({
                title: '小Q编程', // 分享标题
                desc: '机器人教育一站式服务平台，培养未来的创造者！', // 分享描述
                link:"{{ route('wechat2.user.share_open',['user_id'=>$user_id]) }}",
                //link: '{{url('wechat2/user/share_open')}}'+'/'+'{{$user_id}}', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: 'http://toy.yanjiadong.net/wechat2/image/common/order-list-logo.png', // 分享图标
                type: 'link', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    // 用户确认分享后执行的回调函数
                },

                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
        });
    })
</script>
</body>
</html>