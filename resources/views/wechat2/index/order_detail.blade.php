<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>订单详情</title>
    <link href="{{ asset('wechat2/style/reset.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/common.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/style.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('wechat2/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('wechat2/js/main.js') }}"></script>
    <script src="{{ asset('wechat2/js/common.js') }}"></script>
</head>
<body>
<div class="order-detail-wrap">
    <div class="top-states">
        <div class="stay">
            <i class="icon-order-detail return"></i>
            <h2>已寄回，待平台收货确认</h2>
            <h4>在平台收货并确认后，才可以申请押金提现哦！</h4>
        </div>
    </div>
    <div class="logistics bg-white">
        <div class="logistics-info clear" onclick="order_detail.goLogisticsDetail()">
            <div class="fl">
                <i class="icon icon_state_car"></i>
            </div>
            <div class="fl">
                <h3>快件已经在海口中转处，准备发往北京</h3>
                <p>2017-2-21 10:21</p>
            </div>
            <div class="fr">
                <i class="icon icon_arrowRight_bold"></i>
            </div>
        </div>
        <div class="address">
            <div class="name-phone">
                <table>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><i class="icon-order-detail local"></i></td>
                        <td colspan="2"></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="separate"></div>
    </div>
    <div class="order-detail">
        <div class="good_show">
            <a href="">
                <table>
                    <tr>
                        <td rowspan="3">
                            <img src="">
                        </td>
                        <td class="title">
                        </td>
                    </tr>
                    <tr>
                        <td class="price"> <h4>市场价 ¥</h4></td>
                    </tr>
                    <tr>
                        <td class="year"> <p>适龄 岁</p></td>
                    </tr>
                </table>
                <div class="num"></div>
            </a>
        </div>
        <div class="list">
            <ul>
                <li class="clear">
                    <div class="fl">
                        <span>租期</span>
                    </div>
                    <div class="fr">
                        <span>天</span>
                    </div>
                </li>
                <li class="clear">
                    <div class="fl">
                        <span>配送方式</span>
                    </div>
                    <div class="fr">
                        <span></span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="detail-list">
        <ul>
            <li class="clear">
                <div class="fl">
                    <i class="icon-order-detail i-rent"></i><span>租金</span>
                </div>
                <div class="fr">
                    <span>¥</span>
                </div>
            </li>
            <li class="clear">
                <div class="fl">
                    <i class="icon-order-detail i-logistics"></i><span>邮费</span>
                </div>
                <div class="fr">
                    <span>¥</span>
                </div>
            </li>
            <li class="clear">
                <div class="fl">
                    <i class="icon-order-detail i-discount"></i><span>优惠券</span>
                </div>
                <div class="fr">
                    <span>-¥</span>
                </div>
            </li>
            <li class="clear">
                <div class="fl">
                    <i class="icon-order-detail i-yajin"></i><span>押金</span>
                </div>
                <div class="fr">
                    <span>¥</span>
                </div>
            </li>
        </ul>
        <div class="total">
            总计：<span>+¥40.00</span>
        </div>
    </div>
    <div class="order-info">
        <div class="title">
            <i class="icon-order-detail i-info"></i>
            <h5>订单信息</h5>
        </div>
        <div class="order-info-cont">
            <ul>
                <li><span>租赁订单编号：</span></li>
                <li><span>付款时间：</span></li>
                <li><span>平台发货时间：</span></li>
                <li><span>租期开始时间：</span></li>
                <li><span>租期结束时间：</span></li>
            </ul>
            <div id="copy_btn" data-clipboard-text="">复制</div>
        </div>
    </div>
    <div class="return-info">
        <div class="title">
            <i class="icon-order-detail i-return"></i>
            <h5>归还信息</h5>
        </div>
        <div class="order-info-cont">
            <ul>
                <li><span>寄回物流信息：（）</span></li>
                <li><span>提交寄回物流时间：</span><div class="delay-time"><span>已逾期天</span></div></li>
                <li><span>平台收货确认时间：</span></li>
            </ul>
        </div>
    </div>
    <div class="footer">
        <a href="tel:"><i class="icon-phone"></i><span>联系客服</span></a>
        <button onclick="order_detail.goLogisticsDetail()">查看物流</button>
        <button class="btn-confirm" onclick="order_detail.receipt(this)">确认收货</button>
    </div>
</div>

<!--复制-->
<script src="{{ asset('wechat2/js/clipboard.min.js') }}"></script>

<script>
    var order_detail = {
        data: {
            logistics_state:{}          //物流状态
        },
        init:function () {
            //获取物流状态信息
            common.httpRequest("{{ url('api/order/order_detail') }}", 'post', {code:'{{$order_code}}'}, function (res) {
                console.log(res.info);
                //res = [];
//              order_detail.data.logistics_state = res;
                //假数据
                //state 1为待发货 2 已发货 3租用中 4已寄回  5归还成功
                order_detail.data.logistics_state = {
                    state: res.info.order.status,
                    address: {
                        a: res.info.order.receiver,
                        b: res.info.order.receiver_telephone,
                        c: res.info.order.receiver_province,
                        c1:res.info.order.receiver_city,
                        c2:res.info.order.address,
                        g: res.info.order.code,   //订单编号
                        h: res.info.order.pay_success_time,  //付款时间
                        j: res.info.order.send_time,  //平台发货时间
                        k: res.info.order.start_time_new,   //租期开始时间
                        l: res.info.order.end_time_new,   //租期结束时间
                        order_id:res.info.order.id
                    },
                    logistics:{cont:res.info.logistics.context,time:res.info.logistics.time,item3:res.info.order.send_time,name:res.info.order.express_title},//time为物流时间 item3是发货时间
                    good: {
                        a: res.info.order.good_picture,
                        b: res.info.order.good_title,
                        c: res.info.order.good_old,
                        d: res.info.order.good_price,  //市场参考价
                        e: 100.00,
                        f: 100.00,
                        g: 100.00,
                        h: '{{url('wechat/index/good')}}'+'/'+res.info.order.good_id,
                        total_num: 1,
                        allPrice: res.info.order.price,
                        rent:res.info.order.total_price,   //租金
                        postage:res.info.order.express_price,  //邮费
                        discount:res.info.order.coupon_price,   //优惠券
                        yajin:res.info.order.money,
                        item4:res.info.order.days,//item4是租期
                        rent_time:res.info.order.has_days,//已租用天数
                        per_price:res.info.order.good_day_price, //日租金
                        over_days:res.info.order.over_days,   //逾期天数
                        days2:res.info.order.days2  //剩余天数
                    },
                    return_logistics:{
                        a:res.info.order.back_express_title,
                        b:res.info.order.back_express_no,
                        c:res.info.order.back_time,  //提交寄回物流时间
                        d:res.info.order.confirm_time,   //平台收货确认时间
                        tell:res.info.tel  //联系客服电话
                    }
                };

                if(res.info.order.status=='已归还' && res.info.order.back_status=='已验证')
                {
                    order_detail.data.logistics_state.state = '归还成功';
                }
                var logistics_cont = "", logistics_info = "",logistics_address="";
                console.log(order_detail.data.logistics_state.state);
                switch (order_detail.data.logistics_state.state) {  //state 1为待发货 2 已发货 3租用中 4已寄回  5归还成功
                    case '待发货':
                        logistics_cont ='<div class="stay"><i class="icon-order-detail send"></i><h2>待发货</h2><h4>租期从您收到器具后的第二天才开始计算</h4></div>';
                        //$(".order-detail-wrap .order-detail .list ul li .fr:first span").html(order_detail.data.logistics_state.good.item4+'天');
                        $(".order-detail-wrap .order-detail .list ul li .fr:first span").html(order_detail.data.logistics_state.good.item4+'天(<small>¥</small>'+order_detail.data.logistics_state.good.per_price+'/天)');
                        //物流信息
                        $(".logistics .logistics-info").hide();
                        //订单信息标题
                        $(".order-detail-wrap .order-info .title").hide();
                        //订单信息内容项
                        $(".order-detail-wrap .order-info .order-info-cont ul li:eq(2) span").hide();
                        $(".order-detail-wrap .order-info .order-info-cont ul li:eq(3) span").hide();
                        $(".order-detail-wrap .order-info .order-info-cont ul li:eq(4) span").hide();
                        //归还信息隐藏
                        $(".order-detail-wrap .return-info").hide();
                        break;
                    case '已发货':
                        logistics_cont ='<div class="stay"><i class="icon-order-detail return"></i><h2>已发货</h2><h4>租期从您收到器具后的第二天才开始计算</h4></div>';
                        logistics_info ='<div class="fl"><i class="icon icon_state_car"></i></div><div class="fl"><h3>'+order_detail.data.logistics_state.logistics.cont+'</h3><p>'+order_detail.data.logistics_state.logistics.time+'</p></div><div class="fr"><i class="icon icon_arrowRight_bold"></i></div>';

                        //物流信息
                        $(".order-detail-wrap .order-detail .list ul li .fr:first span").html(order_detail.data.logistics_state.good.item4+'天(<small>¥</small>'+order_detail.data.logistics_state.good.per_price+'/天)');
                        //订单信息标题
                        $(".order-detail-wrap .order-info .title").hide();
                        //订单信息内容项
                        $(".order-detail-wrap .order-info .order-info-cont ul li:eq(3) span").hide();
                        $(".order-detail-wrap .order-info .order-info-cont ul li:eq(4) span").hide();
                        //归还信息隐藏
                        $(".order-detail-wrap .return-info").hide();
                        //确认收货按钮显示
                        $(".order-detail-wrap .footer button.btn-confirm").show();
                        break;
                    case '租用中':
                        if(order_detail.data.logistics_state.good.over_days > 0)
                        {
                            logistics_cont ='<div class="stay"><i class="icon-order-detail return"></i><h2>租用中</h2><button class="rest">已逾期：'+(order_detail.data.logistics_state.good.over_days)+'天</button><h4 style="margin-top: 5px">如逾期归还，将收取逾期费（逾期天数*日租金）</h4></div>';
                        }
                        else
                        {
                            if(order_detail.data.logistics_state.good.days2 <= 0)
                            {
                                var content = '今天到期';
                            }
                            else
                            {
                                var content = order_detail.data.logistics_state.good.days2+'天后到期';
                            }
                            logistics_cont ='<div class="stay"><i class="icon-order-detail return"></i><h2>租用中</h2><button class="rest">'+content+'</button><h4 style="margin-top: 5px">如逾期归还，将收取逾期费（逾期天数*日租金）</h4></div>';
                        }

                        logistics_info ='<div class="fl"><i class="icon icon_state_car"></i></div><div class="fl"><h3>'+order_detail.data.logistics_state.logistics.cont+'</h3><p>'+order_detail.data.logistics_state.logistics.time+'</p></div><div class="fr"><i class="icon icon_arrowRight_bold"></i></div>';
                        //物流信息
                        $(".order-detail-wrap .order-detail .list ul li .fr:first span").html(order_detail.data.logistics_state.good.item4+'天（<small>¥</small>'+order_detail.data.logistics_state.good.per_price+'/天）');
                        //订单信息标题
                        $(".order-detail-wrap .order-info .title").hide();
                        //归还信息隐藏
                        $(".order-detail-wrap .return-info").hide();
                        //确认收货按钮显示
                        $(".order-detail-wrap .footer button.btn-confirm").text("归还器具").show();
                        break;
                    case '已归还':
                        logistics_cont ='<div class="stay"><i class="icon-order-detail return"></i><h2>已寄回，待平台收货确认</h2><h4>在平台收货并确认后，才可以申请押金提现哦！</h4></div>';
                        logistics_info ='<div class="fl"><i class="icon icon_state_car"></i></div><div class="fl"><h3>'+order_detail.data.logistics_state.logistics.cont+'</h3><p>'+order_detail.data.logistics_state.logistics.time+'</p></div><div class="fr"><i class="icon icon_arrowRight_bold"></i></div>';
                        //物租期
                        $(".order-detail-wrap .order-detail .list ul li .fr:first span").html(order_detail.data.logistics_state.good.item4+'天（<small>¥</small>'+order_detail.data.logistics_state.good.per_price+'/天）');
                        //物流信息
                        $(".return-info .order-info-cont ul li:eq(2)").hide();
                        break;
                    case '归还成功':
                        logistics_cont ='<div class="stay"><i class="icon-order-detail return"></i><h2>归还成功</h2><h4>您归还的器具平台已收货并确认，感谢您的使用！</h4></div>';
                        logistics_info ='<div class="fl"><i class="icon icon_state_car"></i></div><div class="fl"><h3>'+order_detail.data.logistics_state.logistics.cont+'</h3><p>'+order_detail.data.logistics_state.logistics.time+'</p></div><div class="fr"><i class="icon icon_arrowRight_bold"></i></div>';
                        //物流信息
                        $(".order-detail-wrap .order-detail .list ul li .fr:first span").html(order_detail.data.logistics_state.good.item4+'天（<small>¥</small>'+order_detail.data.logistics_state.good.per_price+'/天）');
                        break;
                    default:
                        break;
                }
                //收货人信息
                logistics_address ='<table><tr><td></td><td>'+order_detail.data.logistics_state.address.a+'</td><td>'+order_detail.data.logistics_state.address.b+'</td></tr><tr><td><i class="icon-order-detail local"></i></td><td colspan="2">'+order_detail.data.logistics_state.address.c+'</td></tr></table>';
                logistics_address ='<table><tr><td></td><td>'+order_detail.data.logistics_state.address.a+'</td><td>'+order_detail.data.logistics_state.address.b+'</td></tr><tr><td><i class="icon-order-detail local"></i></td>' +
                    '<td colspan="2"><span>'+order_detail.data.logistics_state.address.c+'</span><span>'+order_detail.data.logistics_state.address.c1+'</span><span>'+order_detail.data.logistics_state.address.c2+'</span></td></tr></table>';
                $(".top-states").html(logistics_cont);
                //物流信息
                $('.order-detail-wrap .logistics .logistics-info').html(logistics_info);
                //收件人地址详细
                $(".logistics .address .name-phone").html(logistics_address);

                //商品详情
                $(".order-detail .good_show a").attr('href', order_detail.data.logistics_state.good.h);
                $(".order-detail .good_show table td[rowspan='3'] img").attr('src', order_detail.data.logistics_state.good.a);
                $(".order-detail .good_show table td.title").text(order_detail.data.logistics_state.good.b);
                $(".order-detail .good_show td.price h4").text('市场参考价¥' + order_detail.data.logistics_state.good.d);
                $(".order-detail .good_show td.year p").text('适用年龄' + order_detail.data.logistics_state.good.c);
                $(".order-detail .good_show .num").text('x' +order_detail.data.logistics_state.good.total_num);
                $(".order-detail-wrap .order-detail .list ul li .fr:eq(1) span").text(order_detail.data.logistics_state.logistics.name);
                //租金 邮费 优惠券 押金
                $(".order-detail-wrap .detail-list ul li .fr:eq(0) span").text('¥'+order_detail.data.logistics_state.good.rent);
                $(".order-detail-wrap .detail-list ul li .fr:eq(1) span").text('¥'+Math.round(order_detail.data.logistics_state.good.postage));
                $(".order-detail-wrap .detail-list ul li .fr:eq(2) span").text('-¥'+Math.round(order_detail.data.logistics_state.good.discount));
                $(".order-detail-wrap .detail-list ul li .fr:eq(3) span").text('¥'+Math.round(order_detail.data.logistics_state.good.yajin));
                //共计
                $(".order-detail-wrap .detail-list .total span").text('¥'+order_detail.data.logistics_state.good.allPrice);

                //订单信息
                console.log(order_detail.data.logistics_state.address);
                $("#copy_btn").attr({"data-clipboard-text":order_detail.data.logistics_state.address.g});
                $(".order-detail-wrap .footer a").attr({"href":'tel:'+order_detail.data.logistics_state.return_logistics.tell});
                $(".order-detail-wrap .order-info .order-info-cont ul li:eq(0) span").text('租赁订单编号：'+order_detail.data.logistics_state.address.g);
                $(".order-detail-wrap .order-info .order-info-cont ul li:eq(1) span").text('付款时间：'+order_detail.data.logistics_state.address.h);
                $(".order-detail-wrap .order-info .order-info-cont ul li:eq(2) span").text('平台发货时间：'+order_detail.data.logistics_state.address.j);
                $(".order-detail-wrap .order-info .order-info-cont ul li:eq(3) span").text('租期开始时间：'+order_detail.data.logistics_state.address.k+'（物流被签收的第二天）');
                $(".order-detail-wrap .order-info .order-info-cont ul li:eq(4) span").text('租期结束时间：'+order_detail.data.logistics_state.address.l);

                //归还信息
                $(".return-info .order-info-cont ul li:eq(0) span").text('寄回物流信息：'+order_detail.data.logistics_state.return_logistics.a+'（'+order_detail.data.logistics_state.return_logistics.b+'）');
                //$(".return-info .order-info-cont ul li:eq(1) span").text('提交寄回物流时间：'+common.dateFormat1(order_detail.data.logistics_state.return_logistics.c,true));
                $(".return-info .order-info-cont ul li:eq(1) span").text('提交寄回物流时间：'+order_detail.data.logistics_state.return_logistics.c);
                //$(".return-info .order-info-cont ul li:eq(2) span").text('平台收货确认时间：'+common.dateFormat1(order_detail.data.logistics_state.return_logistics.d,true));
                $(".return-info .order-info-cont ul li:eq(2) span").text('平台收货确认时间：'+order_detail.data.logistics_state.return_logistics.d);
                //$(".return-info .order-info-cont ul li .delay-time span").text('逾期'+(order_detail.timeGap(order_detail.data.logistics_state.address.k,order_detail.data.logistics_state.address.l)-order_detail.data.logistics_state.good.item4)+'天');
                if(order_detail.data.logistics_state.good.over_days > 0)
                {
                    $(".return-info .order-info-cont ul li .delay-time span").text('逾期'+(order_detail.data.logistics_state.good.over_days)+'天');
                }
                else
                {
                    $(".return-info .order-info-cont ul li .delay-time").hide();
                }
                order_detail.copy()
            })
        },
        //计算租期时间差
        timeGap:function (start,end) {
            var day = Math.ceil((end - start)/1000/(60*60*24));
            return day;
        },
        //复制
        copy:function () {
            var btn = document.getElementById('copy_btn');
            var clipboard = new Clipboard(btn);
            clipboard.on('success', function(e) {
                common.success_tip("订单号已复制成功！")
            });

            clipboard.on('error', function(e) {
                console.log(e);
            });
        },
        //确认收货  归还器具
        receipt:function () {
            if($(".btn-confirm").text()=="确认收货"){
                //确认收货
                common.confirm_tip("确认收货","确定已经收到寄出的玩具？",null,function () {
                    //order_detail.data.logistics_state
                    common.httpRequest("{{ url('api/order/confirm_order') }}", 'post', {id:order_detail.data.logistics_state.address.order_id}, function (res) {
                        $(".confirm-alert-wrap").remove();
                        order_detail.init();
                    })
                })
            }else{
                //归还器具
                localStorage.out_trade_no = order_detail.data.logistics_state.address.g;
                location.href="/view/logistics_info.html";
            }

        },
        //查看物流
        goLogisticsDetail:function () {
            location.href="{{route('wechat2.index.logistics_detail',['order_code'=>$order_code])}}";
        }
    };

    $(function () {
        order_detail.init();
    })
</script>
<script>
    $(function () {
        /*document.referrer.indexOf("index/logistics_info")>-1||*/
        if(document.referrer.indexOf("lease_order")>-1||document.referrer.indexOf("index/order_list")>-1||
            document.referrer.indexOf("pay_success")>-1){
            sessionStorage.setItem("order_detail_back_url",document.referrer)
        }
        /*----------避免下一页返回这一页调用这个函数-------------*/
        var bool=false;
        setTimeout(function(){
            pushHistory();
            bool=true;
        },1000);
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            if(bool) {
                if(sessionStorage.getItem('order_detail_back_url')){
                    if(sessionStorage.getItem('order_detail_back_url').indexOf("/index/order_list")>-1){
                        var  url_last;
                        if(sessionStorage.getItem('order_detail_back_url').indexOf("?page")==-1){
                            url_last =sessionStorage.getItem('order_detail_back_url')
                        }else{
                            url_last = sessionStorage.getItem('order_detail_back_url').slice(0,sessionStorage.getItem('order_detail_back_url').indexOf("?page"));
                        }
                        location.href=url_last+"?page="+localStorage.order_return_state;
                    }else{
                        location.href=sessionStorage.getItem('order_detail_back_url')
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