<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>租赁订单</title>
    <!--下拉刷新-->
    <link rel="stylesheet" href="{{ asset('wechat2/style/weui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('wechat2/style/jquery-weui.min.css') }}">

    <link href="{{ asset('wechat2/style/reset.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/common.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/style.css') }}" rel="stylesheet" type="text/css">

    <script src="{{ asset('wechat2/js/jquery-1.11.1.min.js') }}"></script>
    <!-- 下拉刷新 -->
    <script src="{{ asset('wechat2/js/jquery-weui.min.js') }}"></script>

    <script src="{{ asset('wechat2/js/main.js') }}"></script>
    <script src="{{ asset('wechat2/js/common.js') }}"></script>
</head>
<body style="overflow-x: hidden;">

<div class="lease-order">
    <nav class="bg-white">
        <ul>
            <li class="tab-btn active" data-tab="0"><span>进行中</span></li>
            <li class="tab-btn" data-tab="1"><span>已结束</span></li>
        </ul>
    </nav>
    <div class="order-detail-main">
        <div class="weui-pull-to-refresh__layer">
            <div class='weui-pull-to-refresh__arrow'></div>
            <div class='weui-pull-to-refresh__preloader'></div>
            <div class="down">下拉刷新</div>
            <div class="up">释放刷新</div>
            <div class="refresh">正在刷新</div>
        </div>
        <div class="detail-cont tab-page">
            <ul class="detail-list">
                <li class="bg-white">
                    <div class="top clear">
                        <div class="fl">
                            <i class="order-list-logo"></i>
                            <span>玩玩具趣编程</span>
                        </div>
                        <div class="fr">待发货</div>
                    </div>
                    <div class="good-detail clear">
                        <div class="fl">
                            <a href="">
                                <img src="../image/other/3.png">
                            </a>
                        </div>
                        <div class="fr">
                            <h3>
                                <a href="">
                                    WewWee Miposaur恐龙机器机龙机器机龙机器机器机器机器机器人
                                </a>
                            </h3>
                            <p>市场价¥2500.00</p>
                            <h4>适龄1-12岁</h4>
                            <span class="num">×1</span>
                        </div>
                    </div>
                    <div class="order-number">
                        <div class="top-line">
                            <div class="i-return-show red">
                                <div class="cont"></div>
                            </div>
                            <div class="info">实付款： ¥300.00（含押金¥150)</div>
                        </div>
                    </div>
                    <div class="total clear">
                        <a href="tel:40021223121"><div class="contact"><i class="icon-phone"></i><span>联系客服</span></div></a>
                        <button class="logistics-btn">查看物流</button>
                        <button class="confirm-btn">确认收货</button>
                    </div>
                </li>
            </ul>
            <div class="no-good">
                <div class="tips">
                    <img src="/wechat2/image/common/no-good1.png">
                    <h4>您还没有相关的订单</h4>
                </div>
            </div>
        </div>
        <div class="return tab-page">
            <ul class="detail-list">
                <li class="bg-white">
                    <div class="top clear">
                        <div class="fl">
                            <i class="order-list-logo"></i>
                            <span>玩玩具趣编程</span>
                        </div>
                        <div class="fr red"><a href="">已归还，查看归还详情</a></div>
                    </div>
                    <div class="good-detail clear">
                        <div class="fl">
                            <a href="">
                                <img src="../image/other/3.png">
                            </a>
                        </div>
                        <div class="fr">
                            <h3>
                                <a href="">
                                    WewWee Miposaur恐龙机器机龙机器机龙机器机龙机
                                </a>
                            </h3>
                            <h4>适用年龄1-12岁</h4>
                            <p>市场参考价¥2500.00</p>
                            <span class="num">×1</span>
                        </div>
                    </div>
                    <div class="pay">实付款： ¥300.00（含押金¥150)</div>
                    <div class="order-number">
                        <div class="top-line">
                            <div class="i-return-show red">
                                <div class="cont">逾期5天</div>
                            </div>
                            <span>租期15天（2017.2.1-2017.12.31）</span>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="no-good">
                <div class="tips">
                    <img src="/wechat2/image/common/no-good1.png">
                    <h4>您还没有相关的订单</h4>
                </div>
            </div>
        </div>
    </div>
    @include('wechat2.common.footer')
</div>

<script>
    var orderDtail = {
        data:{
            list:[],            //进行中列表
            returnList:[],       //已结束列表
            page:common.getParam("page")?common.getParam("page"):0
        },
        init:function () {
            orderDtail.getList();
            orderDtail.getReturnList();
        },
        cont_width:$(".lease-wrap").width(),
        //导航切换
        tab_change:function () {
            var tab_btn = $(".lease-order nav .tab-btn");
            localStorage.order_return_state = 0;
            if(orderDtail.data.page==1){
                tab_btn.removeClass("active");
                tab_btn.eq(orderDtail.data.page).addClass("active");
                $(".order-detail-main  .tab-page").hide();
                $(".order-detail-main  .tab-page").eq(orderDtail.data.page).show();
                localStorage.order_return_state = 1;
            }
            tab_btn.click(function () {
                var num = $(this).attr("data-tab");
                $("body").scrollTop("0");
                tab_btn.removeClass("active");
                $(this).addClass("active");
                $(".order-detail-main  .tab-page").hide();
                $(".order-detail-main  .tab-page").eq(num).show();
                localStorage.order_return_state = localStorage.order_return_state==1?0:1;
            })
        },
        //进行中 --数据加载
        getList:function () {
            common.httpRequest("{{url('api/order/get_order_list')}}",'post',{user_id:'{{ $user_id }}',type:1},function (res) {
                /*res ={
                    code:200,
                    info:{
                        list:[
                            {
                                tatus: "租用中",
                                href:"order_detail.html",    //点击详情跳转链接
                                good_picture: "http://ougu95ew5.bkt.clouddn.com/toys/93e8067211ba801a58d9d5b098d2c960.jpg", //商品图片
                                good_title: "测试商品002",  //商品标题
                                good_price: "100.00",         //市场价
                                good_old: "1-3",           //适龄
                                days: 0,
                                good_num:1,    //商品的件数
                                price: 300.00,  //实付金额
                                yajin:150,     //押金
                                phone:'4006360816',
                                out_trade_no: "p201710136511579415",
                                s_time:"1513872778232",    //租用开始时间
                                e_time:"1514131200000"    //租用结束时间
                            }
                        ]
                    }
                };*/

                console.log(res);

                if(res.info.list.length>0) {
                    $(".detail-cont .no-good").hide();
                    //  orderDtail.data.returnList = res;
                    //tatus为发货状态  1为待发货 2是已发货 3.租用中
                    orderDtail.data.list = res.info.list;
                    var dataList = '';
                    for (var i = 0; i < orderDtail.data.list.length; i++) {
                        //var rentTime = orderDtail.timeGap(orderDtail.data.list[i].s_time,orderDtail.data.list[i].e_time);
                        var href = "{{url('wechat2/index/order_detail')}}"+'/'+orderDtail.data.list[i].code;
                        switch (orderDtail.data.list[i].status) {
                            case "待发货":
                                dataList += ' <li class="bg-white"><div class="top clear"><div class="fl"><i class="order-list-logo"></i><span>玩玩具趣编程</span>' +
                                    '</div><div class="fr">待发货</div></div><div class="good-detail clear"><a href="'+href+'"><div class="fl"><img src="'+orderDtail.data.list[i].good_picture+'">' +
                                    '</div><div class="fr"><h3>'+orderDtail.data.list[i].good_title+'</h3><p>市场价¥'+Math.round(orderDtail.data.list[i].good_price)+'</p>' +
                                    '<h4>适龄'+orderDtail.data.list[i].good_old+'</h4><span class="num">×'+orderDtail.data.list[i].good_num+'</span></div></a></div><div class="order-number"><div class="top-line"><div class="info1"><span class="rent-time">租期'+orderDtail.data.list[i].days+'天</span>实付款：¥'+orderDtail.data.list[i].price+'（含押金¥'+Math.round(orderDtail.data.list[i].money)+'）</div></div></div><div class="total clear">' +
                                    '<a href="tel:'+res.info.phone+'"><div class="contact"><i class="icon-phone"></i><span>联系客服</span></div></a></div></li>';
                                break;
                            case "已发货":
                                dataList += ' <li class="bg-white"><div class="top clear"><div class="fl"><i class="order-list-logo"></i><span>玩玩具趣编程</span>' +
                                    '</div><div class="fr">已发货</div></div><div class="good-detail clear"><a href="'+href+'"><div class="fl"><img src="'+orderDtail.data.list[i].good_picture+'">' +
                                    '</div><div class="fr"><h3>'+orderDtail.data.list[i].good_title+'</h3><p>市场价¥'+Math.round(orderDtail.data.list[i].good_price)+'</p>' +
                                    '<h4>适龄'+orderDtail.data.list[i].good_old+'</h4><span class="num">×'+orderDtail.data.list[i].good_num+'</span></div></a></div><div class="order-number"><div class="top-line"><div class="info1"><span class="rent-time">租期'+orderDtail.data.list[i].days+'天</span>实付款：¥'+orderDtail.data.list[i].price+'（含押金¥'+Math.round(orderDtail.data.list[i].money)+'）</div></div></div><div class="total clear">' +
                                    '<a href="tel:'+res.info.phone+'"><div class="contact"><i class="icon-phone"></i><span>联系客服</span></div></a><button class="logistics-btn" onclick="orderDtail.goLogisticsDetail(\''+orderDtail.data.list[i].code+'\')">查看物流</button><button class="confirm-btn"  onclick="orderDtail.receipt(\''+orderDtail.data.list[i].id+'\')">确认收货</button></div></li>';
                                break;
                            case "租用中":
                                //var nowTime = new Date().getTime();

                                if(orderDtail.data.list[i].over_days <= 0){
                                    if(orderDtail.data.list[i].days2 <= 0)
                                    {
                                        var content = '今天到期';
                                    }
                                    else
                                    {
                                        var content = orderDtail.data.list[i].days2+'天后到期';
                                    }
                                    dataList += ' <li class="bg-white"><div class="top clear"><div class="fl"><i class="order-list-logo"></i><span>玩玩具趣编程</span>' +
                                        '</div><div class="fr">租用中</div></div><div class="good-detail clear"><a href="'+href+'"><div class="fl"><img src="'+orderDtail.data.list[i].good_picture+'">' +
                                        '</div><div class="fr"><h3>'+orderDtail.data.list[i].good_title+'</h3><p>市场价¥'+Math.round(orderDtail.data.list[i].good_price)+'</p>' +
                                        '<h4>适龄'+orderDtail.data.list[i].good_old+'</h4><span class="num">×'+orderDtail.data.list[i].good_num+'</span></div></a></div><div class="order-number"><div class="top-line"><div class="info1">'+'实付款：¥'+orderDtail.data.list[i].price+'（含押金¥'+Math.round(orderDtail.data.list[i].money)+'）</div><div class="i-return-show red"><div class="cont">'+content+'</div></div><div class="info2">租期'+orderDtail.data.list[i].days+'天（'+orderDtail.data.list[i].start_time_new+'-'+orderDtail.data.list[i].end_time_new+')</div></div></div><div class="total clear">' +
                                        '<a href="tel:'+res.info.phone+'"><div class="contact"><i class="icon-phone"></i><span>联系客服</span></div></a><button class="logistics-btn" onclick="orderDtail.goLogisticsDetail(\''+orderDtail.data.list[i].code+'\')">查看物流</button><button class="confirm-btn" onclick="orderDtail.goReturn(\''+orderDtail.data.list[i].code+'\')">归还器具</button></div></li>';
                                }else{
                                    dataList += ' <li class="bg-white"><div class="top clear"><div class="fl"><i class="order-list-logo"></i><span>玩玩具趣编程</span>' +
                                        '</div><div class="fr">租用中</div></div><div class="good-detail clear"><a href="'+href+'"><div class="fl"><img src="'+orderDtail.data.list[i].good_picture+'">' +
                                        '</div><div class="fr"><h3>'+orderDtail.data.list[i].good_title+'</h3><p>市场价¥'+Math.round(orderDtail.data.list[i].good_price)+'</p>' +
                                        '<h4>适龄'+orderDtail.data.list[i].good_old+'</h4><span class="num">×'+orderDtail.data.list[i].good_num+'</span></div></a></div><div class="order-number"><div class="top-line"><div class="info1">'+'实付款：¥'+orderDtail.data.list[i].price+'（含押金¥'+Math.round(orderDtail.data.list[i].money)+'）</div><div class="i-return-show red"><div class="cont">逾期'+orderDtail.data.list[i].over_days+'天</div></div><div class="info2">租期'+orderDtail.data.list[i].days+'天（'+orderDtail.data.list[i].start_time_new+'-'+orderDtail.data.list[i].end_time_new+')</div></div></div><div class="total clear">' +
                                        '<a href="tel:'+res.info.phone+'"><div class="contact"><i class="icon-phone"></i><span>联系客服</span></div></a><button class="logistics-btn" onclick="orderDtail.goLogisticsDetail(\''+orderDtail.data.list[i].code+'\')">查看物流</button><button class="confirm-btn" onclick="orderDtail.goReturn(\''+orderDtail.data.list[i].code+'\')">归还器具</button></div></li>';
                                }
                                break;
                            default:
                                break;
                        }
                    }
                    $(".detail-cont .detail-list").html(dataList).show();

                }else{
                    $(".order-detail-main .detail-cont .detail-list").hide();
                    $(".order-detail-main .detail-cont .no-good").height($(window).outerHeight()-$(".lease-wrap nav").outerHeight()- $("footer").outerHeight()).show();
                }
            })
        },
        //计算租期时间差
        timeGap:function (start,end) {
            var day = Math.ceil((end - start)/1000/(60*60*24));
            return day;
        },
        //已结束 --数据加载
        getReturnList:function(){
            //debugger
            common.httpRequest("{{url('api/order/get_order_list')}}",'post',{user_id:'{{ $user_id }}',type:2},function (res) {
                // res.length=0;
                /*res ={
                    code:200,
                    info:{
                        list:[
                            {
                                status: true,            //是否平台确认归还了   true为确认
                                href:"order_detail.html",    //点击详情跳转链接
                                good_picture: "http://ougu95ew5.bkt.clouddn.com/toys/93e8067211ba801a58d9d5b098d2c960.jpg", //商品图片
                                good_title: "测试商品002",  //商品标题
                                good_price: "100.00",         //市场价
                                good_old: "1-3",           //适龄
                                days: 0,
                                good_num:1,    //商品的件数
                                price: 300.00,  //实付金额
                                yajin:150,     //押金
                                phone:'4006360816',
                                out_trade_no: "p201710136511579415",
                                s_time:"1513872778232",    //租用开始时间
                                e_time:"1514131200000",    //租用结束时间
                                return_time:"1518872788232"  //归还的时间
                            }
                        ]
                    }
                };*/
                if(res.info.list.length>0){
                    //  orderDtail.data.returnList = res;
                    //假数据
                    orderDtail.data.returnList = res.info.list;
                    console.log(res.info.list);
                    var dataList ='';
                    for(var i=0;i<orderDtail.data.returnList.length;i++){
                        var href = "{{url('wechat2/index/order_detail')}}"+'/'+orderDtail.data.returnList[i].code;
                        //var href = "http://toy.yanjiadong.net/wechat/index/order_detail"+'/'+orderDtail.data.returnList[i].code;
                        if(orderDtail.data.returnList[i].status=='已归还' && orderDtail.data.returnList[i].back_status=='已验证'){   //平台确认归还了
                            if(orderDtail.data.returnList[i].over_days > 0){   //逾期
                                dataList +='<li class="bg-white"><div class="top clear"><div class="fl"><i class="order-list-logo"></i>' +
                                    '<span>玩玩具趣编程</span></div><div class="fr">归还成功</div></div>' +
                                    '<div class="good-detail clear"><a href="'+href+'"><div class="fl"><img src="'+orderDtail.data.returnList[i].good_picture+'">' +
                                    '</div><div class="fr"><h3>'+orderDtail.data.returnList[i].good_title+'</h3>' +
                                    '<p>市场价¥'+Math.round(orderDtail.data.returnList[i].good_price)+'</p><h4>适龄'+orderDtail.data.returnList[i].good_old+'</h4><span class="num">×1</span></div></a></div>' +
                                    '<div class="pay">实付款： ¥'+orderDtail.data.returnList[i].price+'（含押金¥'+Math.round(orderDtail.data.returnList[i].money)+')</div><div class="order-number"><div class="top-line">' +
                                    '<div class="i-return-show red"><div class="cont">逾期'+ orderDtail.data.returnList[i].over_days+'天</div></div><span>租期'+orderDtail.data.returnList[i].days+'天（'+orderDtail.data.returnList[i].start_time_new+'-'+orderDtail.data.returnList[i].end_time_new+')</span></div></div></li>';
                            }else{ //未逾期
                                dataList +='<li class="bg-white"><div class="top clear"><div class="fl"><i class="order-list-logo"></i>' +
                                    '<span>玩玩具趣编程</span></div><div class="fr">归还成功</div></div>' +
                                    '<div class="good-detail clear"><a href="'+href+'"><div class="fl"><img src="'+orderDtail.data.returnList[i].good_picture+'">' +
                                    '</div><div class="fr"><h3>'+orderDtail.data.returnList[i].good_title+'</h3>' +
                                    '<p>市场价¥'+Math.round(orderDtail.data.returnList[i].good_price)+'</p><h4>适龄'+orderDtail.data.returnList[i].good_old+'</h4><span class="num">×1</span></div></a></div>' +
                                    '<div class="pay">实付款： ¥'+orderDtail.data.returnList[i].price+'（含押金¥'+Math.round(orderDtail.data.returnList[i].money)+')</div><div class="order-number"><div class="top-line">' +
                                    '<div class="i-return-show green"><div class="cont">已按期归还</div></div><span>租期'+orderDtail.data.returnList[i].days+'天（'+orderDtail.data.returnList[i].start_time_new+'-'+orderDtail.data.returnList[i].end_time_new+')</span></div></div></li>';
                            }
                        }else{
                            if(orderDtail.data.returnList[i].over_days>0){   //逾期
                                dataList +='<li class="bg-white"><div class="top clear"><div class="fl"><i class="order-list-logo"></i>' +
                                    '<span>玩玩具趣编程</span></div><div class="fr red">已寄回，待平台收货确认</div></div>' +
                                    '<div class="good-detail clear"><a href="'+href+'"><div class="fl"><img src="'+orderDtail.data.returnList[i].good_picture+'">' +
                                    '</div><div class="fr"><h3>'+orderDtail.data.returnList[i].good_title+'</h3>' +
                                    '<p>市场价¥'+Math.round(orderDtail.data.returnList[i].good_price)+'</p><h4>适龄'+orderDtail.data.returnList[i].good_old+'</h4><span class="num">×1</span></div></a></div>' +
                                    '<div class="pay">实付款： ¥'+orderDtail.data.returnList[i].price+'（含押金¥'+Math.round(orderDtail.data.returnList[i].money)+')</div><div class="order-number"><div class="top-line">' +
                                    '<div class="i-return-show red"><div class="cont">逾期'+orderDtail.data.returnList[i].over_days+'天</div></div><span>租期'+orderDtail.data.returnList[i].days+'天（'+orderDtail.data.returnList[i].start_time_new+'-'+orderDtail.data.returnList[i].end_time_new+')</span></div></div></li>';
                            }else{ //未逾期
                                dataList +='<li class="bg-white"><div class="top clear"><div class="fl"><i class="order-list-logo"></i>' +
                                    '<span>玩玩具趣编程</span></div><div class="fr red">已寄回，待平台收货确认</div></div>' +
                                    '<div class="good-detail clear"><a href="'+href+'"><div class="fl"><img src="'+orderDtail.data.returnList[i].good_picture+'">' +
                                    '</div><div class="fr"><h3>'+orderDtail.data.returnList[i].good_title+'</h3>' +
                                    '<p>市场价¥'+Math.round(orderDtail.data.returnList[i].good_price)+'</p><h4>适龄'+orderDtail.data.returnList[i].good_old+'</h4><span class="num">×1</span></div></a></div>' +
                                    '<div class="pay">实付款： ¥'+orderDtail.data.returnList[i].price+'（含押金¥'+Math.round(orderDtail.data.returnList[i].money)+')</div><div class="order-number"><div class="top-line">' +
                                    '<div class="i-return-show green"><div class="cont">已按期归还</div></div><span>租期'+orderDtail.data.returnList[i].days+'天（'+orderDtail.data.returnList[i].start_time_new+'-'+orderDtail.data.returnList[i].end_time_new+')</span></div></div></li>';
                            }
                        }

                        /*    dataList='<li class="bg-white"><div class="top clear"><div class="fl"><i class="icon-logo"></i><span>玩玩具趣编程</span></div>' +
                                '<div class="fr"><a href="'+href2+'"><span>已归还，查看归还详情</span><i class="icon icon_arrowRight_red"></i></a></div>' +
                                '</div><div class="good-detail clear"><a href="/view/order_detail.html"><div class="fl"><img src="'+orderDtail.data.returnList[i].good_picture+'">' +
                                '</div><div class="fr"><h3>'+orderDtail.data.returnList[i].good_title+'</h3><h4>适用年龄'+orderDtail.data.returnList[i].good_old+'</h4><p>市场参考价' +
                                '¥'+orderDtail.data.returnList[i].good_price+'</p></div></a></div><div class="order-number clear">' +
                                '<div class="fl"><span>共租用'+orderDtail.data.returnList[i].days+'天</span></div><div class="fr">' +
                                '<span>共'+orderDtail.data.returnList[i].good_num+'件商品 合计：+¥'+orderDtail.data.returnList[i].price+'</span></div></div></li>';*/
                    }
                    //console.log(dataList);
                    $(".return .detail-list").html(dataList).show();
                }else{
                    $(".order-detail-main .return .detail-list").hide();
                    $(".order-detail-main .return .detail-list").hide();
                    $(".order-detail-main .return .no-good").height($(window).outerHeight()-$(".lease-wrap nav").outerHeight()- $("footer").outerHeight()).show();
                }
            })
        },
        //确认收货
        receipt:function (id) {
            common.confirm_tip("提示","确定已经收货完成？",null,function () {
                common.httpRequest("{{ url('api/order/confirm_order') }}",'post',{id:id},function (res) {
                    if(res.code == 200){
                        $(".confirm-alert-wrap").remove();
                        orderDtail.init();
                    }
                })
            });
            //debugger;
        },
        //查看物流
        goLogisticsDetail:function(code) {
            location.href="{{url('wechat2/index/logistics_detail')}}"+'/'+code;
            //location.href="/view/logistics_detail.html";
        },
        //
        goReturn:function (out_trade_no) {
            localStorage.out_trade_no = out_trade_no;
            location.href="{{ route('wechat2.index.logistics_info') }}";
        },
        //查看归还详情
        goReturned:function () {
            location.href="{{ route('wechat2.index.order_return_detail') }}";
            //location.href="/view/order_return_detail.html1";
        }
    };
    $(function () {
        var user_id="{{ $user_id }}";
        var get_url = '{{url('api/user/get_cart_order_num')}}';
        common.getCarAndOrder(get_url,user_id);
        orderDtail.tab_change();
        orderDtail.init();

        //下拉刷新
        $(".order-detail-main").css({height:$(window).outerHeight()+'px'});
        $(".order-detail-main").pullToRefresh();
        $(".order-detail-main").on("pull-to-refresh", function() {
            var refreshClose = $(this);
            /*-------下拉刷新的内容-------------------*/
            orderDtail.init();
            /*-------下拉刷新的内容结束-------------------*/
            setTimeout(function () {
                refreshClose.pullToRefreshDone();
            },500);
        });
        $("order-detail-main").pullToRefreshDone();
    })
</script>
</body>
</html>
