<!DOCTYPE html>
<html lang="en" class="bg-white">
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
            <img src="" alt="">
        </div>
        <h3></h3>
        <p></p>
        <div class="separate">
            <span class="line"></span>
            <span class="dot"></span>
            <span class="text">趣编程</span>
            <span class="dot"></span>
            <span class="line"></span>
        </div>
        <h3>专业的编程教育（玩具）机器人租赁平台</h3>
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
        <div class="img">
            <img src="/wechat/image/common/erweima.jpg" >
        </div>
        <h3>长按识别二维码，关注公众号</h3>
        <p>成为会员即可享受免费租、随意换、往返包邮服务</p>
        <h4>每月仅需¥399，新用户再减¥100</h4>
    </div>
</div>
<script>
    $(".photo img").attr('src','{{$user->wechat_avatar}}');
    $(".share-main h3:first").text('{{$user->name}}');
    $(".share-main>p").text("我在“趣编程”免费玩了"+'{{$count}}'+"个编程机器人");
</script>
</body>
</html>