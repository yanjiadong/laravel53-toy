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
        <div class="title">
            <h3>请填写寄回的物流单号</h3>
            <p>确认后，快递单号不可修改</p>
        </div>
        <div class="number clear">
            <div class="fl">
                <h5>快递单号</h5>
                <input type="text" placeholder="请输入快递单号" onblur="fill_logistics.testNumber(this)">
            </div>
            <div class="fr">
                <i class="icon icon_code"></i>
                <p>扫一扫</p>
            </div>
        </div>
        <div class="company clear" onclick="fill_logistics.getCompany()">
            <div class="fl">
                <h5>快递公司</h5>
                <input type="text" placeholder="点击匹配物流公司名称" disabled>
            </div>
            <div class="fr">
                <i class="icon icon_arrowRight_bold"></i>
            </div>
        </div>
    </div>
    <div class="btn">
        <button onclick="fill_logistics.submit()">确认提交</button>
    </div>
</div>


<script>
    var fill_logistics  ={
        data:{
            item:JSON.parse(localStorage.order_fill_logistics)
        },
        init:function () {
            $(".fill-logistics .good-show .fl a").attr('href','#');
            $(".fill-logistics .good-show .fl img").attr('src',fill_logistics.data.item.good_picture);
            $(".fill-logistics .good-show .fr h3 a").text(fill_logistics.data.item.good_title);
            $(".fill-logistics .good-show .fr h4").text('市场参考价¥'+fill_logistics.data.item.good_price);
            $(".fill-logistics .good-show .fr p").text(''+fill_logistics.data.item.good_brand.title);
        },
        //获取物流公司
        getCompany:function(){
            var number =  $(".number input").val();
            if(!number.replace(/(^\s*)|(\s*$)/g, "")){
                common.alert_tip("快递单号不能为空！");
            }else{
                common.httpRequest('{{url('api/index/get_express_list')}}','post',{number:number},function (res) {
                    //假数据
                    if(res){
                        $(".company input").val("顺丰物流公司");
                        $(".btn button").addClass('active');
                    }else{
                        common.alert_tip("无法匹配到物流公司，请坚持快递单号是否正确！");
                        return false;
                    }
                })
            }

        },
        //是否填写快递单号
        testNumber:function (item) {
            console.log(!$(item).val().replace(/(^\s*)|(\s*$)/g, ""));
            if(!$(item).val().replace(/(^\s*)|(\s*$)/g, "")||!$(".company input").val()){
                $(".btn button").removeClass('active');
            }else{
                $(".btn button").addClass('active');
            }
        },
        submit:function () {
            var submitData = {};
            submitData.id = fill_logistics.id;
            submitData.number =$(".number input").val();
            if($(".btn button").hasClass('active')){
                common.confirm_tip("提交物流单号","提交后快递单号不可修改，确定提交？",null,function () {
                    common.httpRequest('../js/test.json','get',null,function (res) {
                        if(res){
                            location.href="#";
                            $(".confirm-alert-wrap").remove();
                        }
                    })
                })
            }
        }
    };
    $(function () {
        fill_logistics.init();

        //通过config接口注入权限验证配置
        wx.config({
            debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: '', // 必填，公众号的唯一标识
            timestamp:'' , // 必填，生成签名的时间戳
            nonceStr: '', // 必填，生成签名的随机串
            signature: '',// 必填，签名，见附录1
            jsApiList: ['scanQRCode'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
        });
        wx.error(function(res) {
            alert("出错了：" + res.errMsg);
        });
        //调用扫一扫
        $(".icon_code").click(function (event) {
            event.preventDefault();
            wx.scanQRCode({
                needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                success: function (res) {
                    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                }
            });
        })

    })
</script>
</body>
</html>