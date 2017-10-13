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

</head>
<body>
<div class="fill-logistics">
    <div class="top">
        <div class="title">
            寄回的物品
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
                <input type="text" placeholder="点击匹配物流公司名称" disabled id="express_title">
                <input type="hidden" value="" id="express_com">
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

<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>
    var fill_logistics  ={
        data:{
            item:JSON.parse(localStorage.order_fill_logistics)
        },
        init:function () {
            console.log(fill_logistics.data.item);
            $(".fill-logistics .good-show .fl a").attr('href','#');
            $(".fill-logistics .good-show .fl img").attr('src',fill_logistics.data.item.good_picture);
            $(".fill-logistics .good-show .fr h3 a").text(fill_logistics.data.item.good_title);
            $(".fill-logistics .good-show .fr h4").text('市场参考价¥'+fill_logistics.data.item.good_price);
            $(".fill-logistics .good-show .fr p").text('适用年龄'+fill_logistics.data.item.good_old);
        },
        //获取物流公司
        getCompany:function(){
            var number =  $(".number input").val();
            if(!number.replace(/(^\s*)|(\s*$)/g, "")){
                common.alert_tip("快递单号不能为空！");
            }else{
                common.httpRequest('{{url('api/express_info/com')}}','post',{num:number},function (res) {
                    //假数据
                    if(res.code==200){
                        $(".company input").val(res.info.title);
                        $("#express_com").val(res.info.com);

                        $(".btn button").addClass('active');
                    }else{
                        common.alert_tip("无匹配结果，请检查快递单号是否正确！");
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
            //submitData.id = fill_logistics.id;
            submitData.back_express_no =$(".number input").val();
            submitData.order_id = fill_logistics.data.item.id;
            submitData.back_express_title = $("#express_title").val();
            submitData.back_express_com = $("#express_com").val();
            //submitData.express_id = 3;

            if($(".btn button").hasClass('active')){
                common.confirm_tip("提交物流单号","提交后快递单号不可修改，确定提交？",null,function () {
                    common.httpRequest('{{url('api/order/order_back')}}','post',submitData,function (res) {
                        if(res.code == 200){
                            location.href="{{url('wechat/index/order_return_detail')}}"+'/2';
                            $(".confirm-alert-wrap").remove();
                        } else {
                            common.alert_tip(res.msg);
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
                    var start = result.indexOf("CODE_128,");
                    if(start>-1){
                        fill_logistics.data.logistics_num =  result.slice(start+9);
                    }else{
                        fill_logistics.data.logistics_num = result;
                    }
                    $(".number input").val( fill_logistics.data.logistics_num);
                }
            });
        })

    })
</script>
</body>
</html>