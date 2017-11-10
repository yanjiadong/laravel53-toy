<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>提交物流单号</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
</head>
<body>
<div class="logistics-info-wrap">
    <div class="logistics-info-main">
        <div class="detail-cont">
            <div class="top-tips">
                优先通过顺丰快递（货到付款方式）将玩具寄回，然后将寄回的快递单号提交，即可再次租用
            </div>
            <div class="detail-cont-main">
                <div class="cont">
                    <div class="top">
                        <i class="icon-info-1"></i>
                        <span>归还的玩具</span>
                    </div>
                    <div class="good-detail clear">
                        <!--  <a href="">
                              <div class="fl">
                                  <img src="../image/other/3.png">
                              </div>
                              <div class="fr">
                                  <h3>WewWee Miposaur恐龙机器机龙机器机器机器机器机器机器机器机器人</h3>
                                  <p>市场参考价¥2500.00</p>
                                  <h4>适用年龄1-12岁</h4>
                              </div>
                          </a>-->
                    </div>
                    <div class="return-info">
                        <div class="title bg-white">
                            <i class="icon-info-2"></i>
                            <span>寄回地址</span>
                        </div>
                        <div class="info clear bg-white">
                            <table>
                                <tr>
                                    <td>收件人：</td>
                                    <td class="name">sara</td>
                                </tr>
                                <tr>
                                    <td>电&nbsp;&nbsp;&nbsp;&nbsp;话：</td>
                                    <td class="cell">15899878547</td>
                                </tr>
                                <tr>
                                    <td>地&nbsp;&nbsp;&nbsp;&nbsp;址：</td>
                                    <td class="address">江苏省苏州市工业园区七月街1号某某工业</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="logistics-info">
                        <div class="title bg-white">
                            <i class="icon-info-3"></i>
                            <span>玩具寄回的物流信息</span>
                        </div>
                        <div class="number clear">
                            <div class="fl">
                                <h5>快递单号</h5>
                                <input type="text" value="请输入快递单号" onclick="logisticsInfo.resetInput(this)" onblur="logisticsInfo.testNumber(this)">
                            </div>
                            <div class="fr">
                                <i class="icon icon_code"></i>
                                <p>扫一扫</p>
                            </div>
                        </div>
                        <div class="company clear" onclick="logisticsInfo.getCompany()">
                            <div class="fl">
                                <h5>快递公司</h5>
                                <input type="text" value="点击匹配物流公司名称" id="express_title" disabled>
                                <input type="hidden" value="" id="express_com">
                            </div>
                            <div class="fr">
                                <i class="icon icon_arrowRight_bold"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="no-good">
            <div class="tips">
                <i class="icon-big icon-big-blankPage"></i>
                <h4>暂时没有可归还的玩具</h4>
            </div>
        </div>
    </div>
    <div class="btn" >
        <button onclick="logisticsInfo.submit()">确认提交物流信息</button>
    </div>
</div>

<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>
    var logisticsInfo= {
        data: {
            returnInfo:{},          //寄回信息
            out_trade_no:localStorage.out_trade_no,  //商品订单编码
            goodData:{},             //商品信息
            logistics_num:""
        },
        init:function () {
            logisticsInfo.getList();
        },
        //地址和商品信息 --数据加载
        getList:function () {
            //地址信息
            common.httpRequest('{{url('api/order/order_can_back')}}','post',{user_id:'{{$user_id}}'},function (res) {
                // good_return.returnInfo = res;
                //假数据
                logisticsInfo.returnInfo ={
                    c:res.info.name,
                    d:res.info.address,
                    h:res.info.telephone
                };
                $(".logistics-info-wrap .return-info .info table tr td.name").text(logisticsInfo.returnInfo.c);
                $(".logistics-info-wrap .return-info  .info table tr td.cell").text(logisticsInfo.returnInfo.h);
                $(".logistics-info-wrap .return-info .info table tr td.address").text(logisticsInfo.returnInfo.d);
            });
            //列表
            common.httpRequest('{{url('api/order/order_can_back')}}','post',{user_id:'{{$user_id}}'},function (res) {
                //  res.length=0;
                if(res.info.list.length > 0){
                    //  good_return.data.returnList = res;
                    /*logisticsInfo.data.list = [
                        {
                            good_title:"测试商品002",
                            good_picture:'../image/other/3.png',
                            good_price:"100.00",
                            good_old:"1-3岁",
                            out_trade_no:"p201710136511579415",
                            href:"#",
                            id:8585
                        }
                    ];*/

                    logisticsInfo.data.list = res.info.list;
                    //匹配上个页面选中的订单编号相同的商品对象
                    logisticsInfo.data.list.forEach(function (item,i) {
                        if(item.out_trade_no =logisticsInfo.data.out_trade_no ){
                            logisticsInfo.data.goodData =item;
                        }
                    });
                    //console.log(logisticsInfo.data.goodData);
                    var cont ='<a href="'+logisticsInfo.data.goodData.href+'"><div class="fl"><img src="'+logisticsInfo.data.goodData.good_picture+'"></div>' +
                        '<div class="fr"><h3>'+logisticsInfo.data.goodData.good_title+'</h3>' +
                        '<p>市场参考价¥'+logisticsInfo.data.goodData.good_price+'</p><h4>适用年龄'+logisticsInfo.data.goodData.good_old+'岁</h4></div></a>';
                    $(".detail-cont-main .good-detail").html(cont);

                }else{
                    $(".logistics-info-main .detail-cont").hide();
                    $(".btn").hide();
                    $(".logistics-info-main .no-good").height($(window).height()-38).show();
                }
            })
        },
        //是否填写快递单号
        testNumber:function (item) {
            if(!$(item).val()){
                common.alert_tip1("快递单号不能为空！");
                $(".btn button").removeClass('active');
                $(item).removeClass("active").val("请输入快递单号");
                return;
            }
            if($(".company input").val()=="点击匹配物流公司名称"){
                $(".company input").removeClass("active");
                $(".btn button").removeClass('active');
            }else{
                $(".company input").addClass('active');
                $(item).addClass('active');
                $(".btn button").addClass('active');
            }
        },
        resetInput:function (item) {
            if($(item).val()=="请输入快递单号"){
                $(item).addClass('active');
                $(item).val("")
            }
        },
        //获取物流公司
        getCompany:function(){
            var number =  $(".number input").val();
            if(number=="请输入快递单号"){
                common.alert_tip1("快递单号不能为空！");
                $(".company input").val("击匹配物流公司名称");
                $(".company input").removeClass("active");
                return false;
            }else{
                common.httpRequest('{{url('api/express_info/com')}}','post',{num:number},function (res) {
                    //假数据
                    if(res.code==200){
                        $(".company input").val(res.info.title);
                        $("#express_com").val(res.info.com);
                        $(".company input").addClass('active');
                        //$(".company input").val("顺丰物流公司");
                        $(".btn button").addClass('active');
                        common.success_tip("匹配成功");
                    }else{
                        common.alert_tip("无匹配结果，请检查快递单号是否正确！");
                        return false;
                    }
                })
            }
        },
        //提交
        submit:function () {
            var submitData = {};
            submitData.order_id = logisticsInfo.data.goodData.id;
            submitData.back_express_no =$(".number input").val();
            submitData.back_express_title = $("#express_title").val();
            submitData.back_express_com = $("#express_com").val();

            if($(".btn button").hasClass('active')){
                common.confirm_tip("提交物流单号","提交后快递单号不可修改，确定提交？",null,function () {
                    common.httpRequest('{{url('api/order/order_back')}}','post',submitData,function (res) {
                        if(res.code == 200){
                            common.getCarAndOrder('{{$user_id}}'); //更新订单数量和购物车数量
                            location.href="{{url('wechat/index/order_return_detail1')}}";
                            $(".confirm-alert-wrap").remove();
                        }else{
                            common.alert_tip(res.msg);
                        }
                    })
                })
            }
        }
    };
    $(function () {
        logisticsInfo.init();

        //通过config接口注入权限验证配置
        wx.config({
            debug: false,
            appId: '{{isset($signPackage["appId"])?$signPackage["appId"]:''}}',
            timestamp: '{{isset($signPackage["timestamp"])?$signPackage["timestamp"]:''}}',
            nonceStr: '{{isset($signPackage["nonceStr"])?$signPackage["nonceStr"]:''}}',
            signature: '{{isset($signPackage["signature"])?$signPackage["signature"]:''}}',
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
                    //alert(result);
                    var start = result.indexOf("CODE_128,");

                    if(start>-1){
                        logisticsInfo.data.logistics_num =  result.slice(start+9);
                    }else{
                        logisticsInfo.data.logistics_num = result;
                    }
                    $(".number .fl input").val(logisticsInfo.data.logistics_num);
                    //$(".number input").val(fill_logistics.data.logistics_num);
                }
            });
        })

    })
</script>
{{--<script>
    $(function () {
        pushHistory();
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            location.href='{{url('wechat/index/order_list')}}';  //在这里指定其返回的地址
        }, false);
    })
    function pushHistory() {
        var state = {
            title: "title",
            url: "{{url('wechat/index/logistics_info')}}"
        };
        window.history.pushState(state, state.title, state.url);
    }
</script>--}}
<script>
    $(function () {
        pushHistory();
        /*----------避免下一页返回这一页调用这个函数-------------*/
        var bool=false;
        setTimeout(function(){
            bool=true;
        },1500);
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            if(bool) {
                location.href = document.referrer;  //在这里指定其返回的地址  订单列表页面
            }
        }, false);
    });
    function pushHistory() {
        var state = {
            title: "title",
            url: "#"
        };
        window.history.pushState(state, state.title, state.url);
    }
</script>
</body>
</html>
