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
</head>
<body>
<div class="logistics-info-wrap">
    <div class="logistics-info-main">
        <div class="detail-cont">
            <div class="top-tips">
                <img src="/wechat2/image/common/submit-return.png" alt="">
            </div>
            <div class="return-address  bg-white">
                <div class="cont">
                    <div class="title">
                        <i class="lip"></i>
                        <span>寄回地址</span>
                        <i class="lip"></i>
                    </div>
                    <div class="info">
                        <table>
                            <tr>
                                <td class="name"></td>
                                <td class="cell"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="address"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="detail-cont-main">
                <div class="cont">
                    <div class="top">
                        <i class="return-logistics1"></i>
                        <span>寄回的器具</span>
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

                    <div class="logistics-info">
                        <div class="title bg-white">
                            <i class="return-logistics3"></i>
                            <span>寄回的物流信息</span>
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
                                <span>点击匹配物流公司名称</span>
                                <input type="hidden" value="" id="express_title">
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
                <h4>暂无！</h4>
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
            goodData:{},          //商品信息
            logistics_num:""
        },
        init:function () {
            logisticsInfo.getList();
        },
        //地址和商品信息 --数据加载
        getList:function () {
            //地址信息
            common.httpRequest("{{url('api/order/order_can_back')}}",'post',{user_id:'{{ $user_id }}'},function (res) {
                // good_return.returnInfo = res;
                //假数据
                logisticsInfo.returnInfo ={
                    c:res.info.name,
                    d:res.info.address,
                    h:res.info.telephone
                };

                $(".logistics-info-wrap .return-address table tr td.name").text(logisticsInfo.returnInfo.c);
                $(".logistics-info-wrap .return-address table tr td.cell").text(logisticsInfo.returnInfo.h);
                $(".logistics-info-wrap .return-address table tr td.address").text(logisticsInfo.returnInfo.d);

                //$(".logistics-info-wrap .return-info .info table tr td.name").text(logisticsInfo.returnInfo.c);
                //$(".logistics-info-wrap .return-info  .info table tr td.cell").text(logisticsInfo.returnInfo.h.slice(0,3)+'-'
                    //+logisticsInfo.returnInfo.h.slice(3,7)+'-'+logisticsInfo.returnInfo.h.slice(7));
                //$(".logistics-info-wrap .return-info .info table tr td.address").text(logisticsInfo.returnInfo.d);
            });
            //列表
            //  res.length=0;
            common.httpRequest("{{url('api/order/order_can_back')}}",'post',{user_id:'{{ $user_id }}'},function (res) {
                if(res.info.list.length>0){
                    //  good_return.data.returnList = res;
                    /*logisticsInfo.data.list = [
                        {
                            good_title:"测试商测试商测试商测试商测试商测试商测试商测试商测试商测试商测试商测试商测试商测试商测试商测试商测试商测试商测试商品002",
                            good_picture:'../image/other/3.png',
                            good_price:"100.00",
                            good_old:"1-3岁",
                            out_trade_no:"p201710136511579415",
                            href:"#",
                            id:8585,
                            num:1     //租用玩具的个数
                        }
                    ];*/
                    logisticsInfo.data.list = res.info.list;
                    //匹配上个页面选中的订单编号相同的商品对象
                    logisticsInfo.data.list.forEach(function (item,i) {
                        if(item.out_trade_no =logisticsInfo.data.out_trade_no ){
                            logisticsInfo.data.goodData =item;
                        }
                    });
                    var href = "{{url('wechat2/index/good')}}"+'/'+logisticsInfo.data.goodData.id;

                    var cont ='<a href="'+href+'"><div class="fl"><img src="'+logisticsInfo.data.goodData.good_picture+'"></div>' +
                        '<div class="fr"><h3>'+logisticsInfo.data.goodData.good_title+'</h3>' +'<div class="num">x'+'1'+'</div></div></a>';
                    $(".detail-cont-main .good-detail").html(cont);

                    /*var cont ='<a href="'+href+'"><div class="fl"><img src="'+logisticsInfo.data.goodData.good_picture+'"></div>' +
                        '<div class="fr"><h3>'+logisticsInfo.data.goodData.good_title+'</h3>' +
                        '<p>市场价¥'+logisticsInfo.data.goodData.good_price+'</p><h4>适龄'+logisticsInfo.data.goodData.good_old+'岁</h4><div class="num">x'+1+'</div></div></a>';
                    $(".detail-cont-main .good-detail").html(cont);*/

                }else{
                    $(".logistics-info-main .detail-cont").hide();
                    $(".btn").hide();
                    $(".logistics-info-main .no-good").height($(window).height()-38).show();
                }
            });

        },
        //是否填写快递单号
        testNumber:function (item) {
            if(!$(item).val()){
                common.alert_tip1("快递单号不能为空！");
                $(".btn button").removeClass('active');
                $(item).removeClass("active").val("请输入快递单号");
                return;
            }
            if($(".company span").text()=="点击匹配物流公司名称"){
                $(".company span").removeClass("active");
                $(".btn button").removeClass('active');
            }else{
                $(".company span").addClass('active');
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
                $(".company span").text("击匹配物流公司名称");
                $(".company span").removeClass("active");
                return false;
            }else{
                common.httpRequest("{{url('api/express_info/com')}}",'post',{num:number},function (res) {
                    //假数据
                    if(res.code == 200){
                        $(".company span").text(res.info.title);
                        $(".company span").addClass('active');
                        $(".btn button").addClass('active');

                        $("#express_title").val(res.info.title);
                        $("#express_com").val(res.info.com);
                        common.success_tip("匹配成功");
                    }else{
                        common.alert_tip1("无匹配结果，请检查快递单号是否正确！");
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
                    //location.href="order_return_detail.html";
                    common.httpRequest("{{url('api/order/order_back')}}",'post',submitData,function (res) {
                        if(res.code == 200){
                            var user_id = '{{ $user_id }}';
                            var get_url = "{{url('api/user/get_cart_order_num')}}";
                            common.getCarAndOrder(get_url,user_id); //更新订单数量和购物车数量

                            location.href="{{route('wechat2.index.logistics_info_return')}}";
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
        //通过config接口注入权限验证配置
        wx.config({
            debug: false,
            appId: '{{isset($signPackage["appId"])?$signPackage["appId"]:''}}',
            timestamp: '{{isset($signPackage["timestamp"])?$signPackage["timestamp"]:''}}',
            nonceStr: '{{isset($signPackage["nonceStr"])?$signPackage["nonceStr"]:''}}',
            signature: '{{isset($signPackage["signature"])?$signPackage["signature"]:''}}',
            jsApiList: [
                'scanQRCode'
            ]
        });

        wx.error(function(res) {
            alert("出错了：" + res.errMsg);
        });

        wx.ready(function(){
            //调用扫一扫
            $(".icon_code").click(function (event) {
                event.preventDefault();
                wx.scanQRCode({
                    needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                    scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                    success: function (res) {
                        if(res && res.resultStr)
                        {
                            var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                            //alert(result);
                            var start = result.indexOf("CODE_128,");

                            if(start>-1){
                                logisticsInfo.data.logistics_num =  result.slice(start+9);
                            }else{
                                logisticsInfo.data.logistics_num = result;
                            }
                            $(".number .fl input").addClass('active').val( logisticsInfo.data.logistics_num);
                        }
                        else
                        {
                            $(".number .fl input").addClass('active').val("");
                            common.alert_tip1("扫码失败，请您重新扫码或者手动输入！");
                        }
                    },
                    fail:function (res) {
                        $(".number .fl input").addClass('active').val("");
                        common.alert_tip1("扫码失败，请您重新扫码或者手动输入！");
                    }
                });
            });
        });
    })
</script>
<script>
    $(function () {
        if(document.referrer.indexOf("user/user_center")>-1||document.referrer.indexOf("lease_order")>-1||
            document.referrer.indexOf("index/order_list")>-1||document.referrer.indexOf("index/order_detail")>-1){
            sessionStorage.setItem("logistics_info_back_url",document.referrer)
        }
        //让会员卡回退到个人中心 或者首页
        pushHistory();
        /*----------避免下一页返回这一页调用这个函数-------------*/
        var bool=false;
        setTimeout(function(){
            bool=true;
        },500);
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            //debugger;
            if(bool) {
                if(sessionStorage.getItem('logistics_info_back_url')){
                    if(sessionStorage.getItem('logistics_info_back_url').indexOf("/index/order_list")>-1){
                        var  url_last;
                        if(sessionStorage.getItem('logistics_info_back_url').indexOf("?page")==-1){
                            url_last =sessionStorage.getItem('logistics_info_back_url')
                        }else{
                            url_last = sessionStorage.getItem('logistics_info_back_url').slice(0,sessionStorage.getItem('logistics_info_back_url').indexOf("?page"));
                        }
                        location.href=url_last+"?page="+localStorage.order_return_state;
                    }else{
                        location.href=sessionStorage.getItem('logistics_info_back_url')
                    }
                }else{
                    location.href=document.referrer;  //在这里指定其返回的地址
                }
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
