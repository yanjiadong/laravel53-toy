<!DOCTYPE html  class="bg-white">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>分享</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">
    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
</head>
<body class="bg-white">
<div class="share-wrap">
    <div class="share-main">
        <div class="photo">
            <img src="{{ isset($user->wechat_avatar) && !empty($user->wechat_avatar) ? $user->wechat_avatar : '' }}" alt="">
        </div>
        <h3 class="name"></h3>
        <p></p>
        <div class="separate">
            <span class="line"></span>
            <span class="dot"></span>
            <span class="text">玩玩具趣编程</span>
            <span class="dot"></span>
            <span class="line"></span>
        </div>
        <h3>少儿编程教育机器人会员制租赁平台</h3>
        <div class="btn1">
            <button style="margin-right: 28px">编程机器人随意挑</button>
            <button>不限次数更换</button>
        </div>
        <div class="btn1">
            <button>比买划算一大截</button>
            <button>孩子编程的启蒙伙伴</button>
        </div>
        <div class="btn1">
            <button style="margin-right: 12px">机器人教育</button>
            <button style="margin-right: 12px">往返包邮</button>
            <button>医疗消毒</button>
        </div>
    </div>
    <div class="invitation">
        <h3>邀请好友</h3>
        <h2>邀请好友注册并成为会员即可领取20元现金红包</h2>
        <p>把邀请好友的微信号截图发给公众号，即可领取</p>
    </div>
    <div class="footer bg-white">
        <button onclick="share.immediately()">立即分享</button>
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

<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>
    var share={
        data:{
            name:'{{$user->wechat_nickname}}',
            num:'{{$count}}'
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
        $(".invitation").css('marginTop',($(window).outerHeight()-20-$(".share-main").outerHeight()-$(".footer").outerHeight()-$(".invitation").height())/2+'px') ;

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
                title: '玩玩具趣编程', // 分享标题
                link: '{{url('wechat/user/share_open')}}'+'/'+'{{$user_id}}', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: 'http://toy.yanjiadong.net/wechat/image/common/icon_logo.png', // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });

            wx.onMenuShareAppMessage({
                title: '玩玩具趣编程', // 分享标题
                desc: '可编程教育机器人包月玩，乐高、能力风暴、优必选等大牌全都有', // 分享描述
                link: '{{url('wechat/user/share_open')}}'+'/'+'{{$user_id}}', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: 'http://toy.yanjiadong.net/wechat/image/common/icon_logo.png', // 分享图标
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