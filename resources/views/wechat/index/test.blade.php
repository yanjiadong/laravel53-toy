<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>提交订单</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
</head>
<body>
<div class="fill-logistics">
    <div class="top">
        <div class="title">
            寄回物品
        </div>
        <div class="good-show clear">
            <div class="fl">
                <a href="">
                    <img src="">
                </a>
            </div>
            <div class="fr">
                <h3>
                    <a href="">
                    </a>
                </h3>
                <h4></h4>
                <p></p>
            </div>
        </div>
    </div>
    <div class="info">
        <div class="number clear">
            <div class="fr">
                <i class="icon icon_code"></i>
                <p>扫一扫</p>
            </div>
        </div>
    </div>
</div>


<script>
    $(function () {
        //调用扫一扫
        $(".icon_code").click(function (event) {
            event.preventDefault();
            wx.scanQRCode({
                needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                success: function (res) {
                    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                    alert(result);
                }
            });
        })

    })
</script>
</body>
</html>