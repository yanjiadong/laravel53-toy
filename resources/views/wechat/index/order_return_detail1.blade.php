<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>归还详情</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
</head>
<body>

<div class="order-return-wrap">
    <div class="order-return-main">
        <div class="parent-box">
            <div class="detail-cont tab-page">
                <div class="top-tips">
                    请完整的寄回租用的玩具，若玩具损坏或零件丢失请提前联系客服，否则将会影响下一次快速换玩具功能
                </div>
                <div class="detail-list">
                    <ul>

                    </ul>
                    <div class="no-good">
                        <div class="tips">
                            <i class="icon-no-goods1"></i>
                            <h4>您还没有相关的订单</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var good_return= {
        data:{
            list:{},   //可寄回更换
            returnInfo:{},  //可寄回更换头部信息
            detailList:[]
        },
        init:function () {
            good_return.getDetailList();
        },
        getDetailList:function () {
            //列表
            common.httpRequest('{{url('api/order/order_back_list')}}','post',{'user_id':'{{$user_id}}'},function (res) {
                //res.length=0;
                /*res ={
                    code:200,
                    msg:"操作成功",
                    info:{list: [
                        {
                            back_status:"已验证",
                            href:"good_detail.html",
                            good_picture: "http://ougu95ew5.bkt.clouddn.com/toys/3998fca8c1864d8aacc8156c5135146b.jpg",
                            good_title: "氪1号 能力风暴教育机器人字段长度字段长度稍大阿斯顿萨达萨达萨达萨达阿斯顿达萨",
                            good_old: "1-12岁",
                            good_price: "699.00",
                            days: 1,
                            money: "0.00",
                            good_num:1,    //商品的件数
                            confirm_time_new: "2017.10.12",
                            back_time_new: "2017.10.12",
                            express_no: "55465fgfdg6dsfdsf",
                            express_title: "顺丰",
                            confirm_time: "2017-10-12 22:53:29"

                        }]}
                };*/
                if(res.code==200 && res.info.list.length>0){
                    good_return.data.detailList = res.info.list;

                    var dataList='';
                    for(var i=0;i<good_return.data.detailList.length;i++){
                        //var href = "{{url('wechat/index/order_detail')}}"+'/'+good_return.data.detailList[i].code;
                        var href = "javascript:;";

                        switch (good_return.data.detailList[i].back_status){
                            case '待验证':
                                dataList +='<li class="bg-white"><div class="top clear"><div class="fl"><i class="icon-logo"></i><span>玩玩具趣编程</span></div>' +
                                    '<div class="fr">待平台验货确认</div></div><div class="good-detail clear"><a href="'+href+'">' +
                                    '<div class="fl"><img src="'+good_return.data.detailList[i].good_picture+'"></div><div class="fr"><h3>' +good_return.data.detailList[i].good_title+
                                    '</h3><p>市场参考价¥'+good_return.data.detailList[i].good_price+'</p><h4>适用年龄'+good_return.data.detailList[i].good_old+'</h4></div></a></div>' +
                                    '<div class="days-monny clear"><div class="fl" ><span>共租用'+good_return.data.detailList[i].days+'天</span></div><div class="fr"><span>' +
                                    '共'+'1'+'件商品合计：+¥'+good_return.data.detailList[i].money+'</span></div></div><div class="return-info">' +
                                    '<p>租期：'+good_return.data.detailList[i].confirm_time_new +'-'+good_return.data.detailList[i].back_time_new+'</p><p>寄回物流信息：' +
                                    good_return.data.detailList[i].back_express_no+'（'+good_return.data.detailList[i].back_express_title+'）</p><p>提交寄回物时间：' +
                                    good_return.data.detailList[i].back_time+'</p></div></li>';
                                break;
                            case '已验证':
                                dataList +='<li class="bg-white"><div class="top clear"><div class="fl"><i class="icon-logo"></i><span>玩玩具趣编程</span></div>' +
                                    '<div class="fr done">已验货确认</div></div><div class="good-detail clear"><a href="'+href+'">' +
                                    '<div class="fl"><img src="'+good_return.data.detailList[i].good_picture+'"></div><div class="fr"><h3>' +good_return.data.detailList[i].good_title+
                                    '</h3><p>市场参考价¥'+good_return.data.detailList[i].good_price+'</p><h4>适用年龄'+good_return.data.detailList[i].good_old+'</h4></div></a></div>' +
                                    '<div class="days-monny clear"><div class="fl" ><span>共租用'+good_return.data.detailList[i].days+'天</span></div><div class="fr"><span>' +
                                    '共'+'1'+'件商品合计：+¥'+good_return.data.detailList[i].money+'</span></div></div><div class="return-info">' +
                                    '<p>租期：'+good_return.data.detailList[i].confirm_time_new +'-'+good_return.data.detailList[i].back_time_new+'</p><p>寄回物流信息：' +
                                    good_return.data.detailList[i].back_express_no+'（'+good_return.data.detailList[i].back_express_title+'）</p><p>提交寄回物时间：' +
                                    good_return.data.detailList[i].back_time+'</p></div></li>';
                                break;
                            default:
                                break;
                        }
                    }
                    $(".detail-cont .detail-list ul").html(dataList).show();

                }else{
                    $(".detail-cont .detail-list ul").hide();
                    $(".detail-cont .top-tips ").hide();
                    var no_good_height = $(window).height();
                    $(".detail-cont .no-good").height(no_good_height).css({'background-color':'#fff'}).show();
                }
            })
        },
    };
    $(function () {
        good_return.init();
    })
</script>
<script>
    $(function () {
        //让会员卡回退到个人中心 或者首页
        pushHistory();
        /*----------避免下一页返回这一页调用这个函数-------------*/
        var bool=false;
        setTimeout(function(){
            bool=true;
        },500);
        //debugger;
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            //debugger;
            if(bool) {
                if(document.referrer.indexOf("/index/order_list")>-1){
                    var  url_last;
                    if(document.referrer.indexOf("?page")==-1){
                        url_last =document.referrer
                    }else{
                        url_last = document.referrer.slice(0,document.referrer.indexOf("?page"));
                    }
                    location.href=url_last+"?page="+localStorage.order_return_state;
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

{{--<script>
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
                if(bool) {
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
</script>--}}
{{--<script>
    $(function () {
        pushHistory();
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            location.href="{{url('wechat/index/order_list')}}";  //在这里指定其返回的地址  订单列表页面
        }, false);
    });
    function pushHistory() {
        var state = {
            title: "title",
            url: "{{url('wechat/index/order_return_detail1')}}"
        };
        window.history.pushState(state, state.title, state.url);
    }
</script>--}}
</body>
</html>
