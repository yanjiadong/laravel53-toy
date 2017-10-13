<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>订单详情</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
</head>
<body>
<div class="order-detail-wrap">
    <div class="top-states">
        <!-- <div class="stay">
             <i class="icon-big icon-big-state-daifahuo"></i>
             <h2>待发货</h2>
             <h4>平台将在24小时内发货，请耐心等待</h4>
         </div>-->
    </div>
    <!--  <div class="top-states">
          <div class="stay">
              <i class="icon-big icon-big-state-daishouhuo"></i>
              <h2>已发货</h2>
              <h4>确认收货后，即可享受玩具随意更换服务</h4>
          </div>
      </div>
      <div class="top-states">
          <div class="stay">
              <i class="icon-big icon-big-state-zuyongzhong"></i>
              <h2>租用中</h2>
              <h4>如需要换玩具，请点击“归还玩具”，上传寄回的物流单号，即可再次下单</h4>
          </div>
      </div>-->
    <div class="logistics bg-white">
        <!--<div class="logistics-info clear">
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
        <div class="operate-btn">
            <button>查看物流</button>
            <button>确认收获</button>
        </div>-->
    </div>
    <!--  <div class="logistics bg-white">
          <div class="logistics-info clear">
              <div class="fl">
                  <i class="icon icon_state_qianshou"></i>
              </div>
              <div class="fl">
                  <h3>快件已签收</h3>
                  <p>2017-2-21 10:21</p>
              </div>
              <div class="fr">
                  <i class="icon icon_arrowRight_bold"></i>
              </div>
          </div>
          <div class="operate-btn">
              <button>查看物流</button>
              <button>归还玩具</button>
          </div>
      </div>-->
    <div class="address">
        <div class="title">
            <div class="border">
                <i class="icon icon_position"></i>
                <h5>收货地址</h5>
            </div>
        </div>
        <div class="address_detail clear  hide" onclick="order_obj.addAddress()">
            <div class="fl">
                <h4><b class="name"></b><span class="phone"></span></h4>
                <p><span></span><span></span><span></span></p>
                <h6></h6>
            </div>
        </div>
        <div class="separate"></div>
    </div>
    <div class="order-detail">
        <div class="title">
            <div class="border">
                <i class="icon icon_orderDetail"></i>
                <h5>订单详情</h5>
            </div>
        </div>
        <div class="no-goods">
            玩具箱居然是空的！
        </div>
        <div class="detail-list">
            <ul>
                <li>
                    <div class="good_show clear">
                        <div class="fl">
                            <a href="">
                                <img src="/wechat/image/other/3.png">
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
                    <div class="money-detail">
                        <ul>
                            {{--<li class="clear">
                                <div class="fl">
                                    <i class="icon_order2"></i>
                                    <span>押金</span>
                                </div>
                                <div class="fr">
                                </div>
                            </li>--}}
                            <li  class="clear">
                                <div class="fl">
                                    <i class="icon_order3"></i>
                                    <span>包装清理费</span>
                                </div>
                                <div class="fr">
                                </div>
                            </li>
                            <li class="clear">
                                <div class="fl">
                                    <i class="icon-order1"></i>
                                    <div>
                                        <h3>邮费</h3>
                                        <p>每个自然月内提供2次往返免邮服务</p>
                                    </div>
                                </div>
                                <div class="fr">
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
            <div class="total">
                共 <span class="num"></span>件商品，合计： <span class="money"></span>
            </div>
        </div>
    </div>
    <div class="order-info">
        <div class="title">
            <div class="border">
                <i class="icon icon_orderDetail"></i>
                <h5>订单信息</h5>
            </div>
        </div>
        <div class="order-info-cont">
            <div class="number clear">
                <div class="fl">
                    租赁订单编号
                </div>
                <div class="fr">
                    <span>{{$order_code}}</span>
                    <input type="hidden" id="copy" value="{{$order_code}}" readonly>
                    <button id="copy_btn" onclick="order_detail.copy()">复制</button>
                </div>
            </div>
            <div class="time clear">
                <div class="fl">
                    下单时间
                </div>
                <div class="fr">
                    <span>2017-4-21 11:21</span>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var order_detail = {
        data: {
            logistics_state:{}          //物流状态
        },
        init:function () {
            //获取物流状态信息
            common.httpRequest('{{url('api/order/order_info')}}', 'post', {code:'{{$order_code}}'}, function (res) {
                //res = [];
//              order_detail.data.logistics_state = res;
                console.log(res.info);
                //假数据
                //state 1为待发货 2 已发货 3租用中 4已归还
                order_detail.data.logistics_state = {
                    state: res.info.order.status,
                    address: {
                        a: res.info.order.receiver,
                        b: res.info.order.receiver_telephone,
                        c: res.info.order.receiver_province,
                        d: res.info.order.receiver_city,
                        e: res.info.order.receiver_area,
                        f: res.info.order.receiver_address,
                        g: res.info.order.express_no,
                        h: res.info.order.created_at
                    },
                    logistics:{cont:res.info.logistics.context,time:res.info.logistics.time},
                    good: {
                        a: res.info.order.good_picture,
                        b: res.info.order.good_title,
                        c: res.info.order.good_brand.title,
                        d: res.info.order.good_price,
                        e: res.info.order.money,
                        f: res.info.order.clean_price,
                        g: res.info.order.express_price,
                        h: '{{url('wechat/index/good')}}'+'/'+res.info.order.good_id,
                        total_num: 1,
                        allPrice: res.info.order.price
                    }
                };
                var logistics_cont = "", logistics_info = "";
                switch (order_detail.data.logistics_state.state) {
                    case '待发货':
                        logistics_cont = '<div class="stay"><i class="icon-big icon-big-state-daifahuo"></i>' +
                            '<h2>待发货</h2><h4>平台将在24小时内发货，请耐心等待</h4></div>';
                        break;
                    case '已发货':
                        logistics_cont = '<div class="stay"><i class="icon-big icon-big-state-daishouhuo"></i>' +
                            '<h2>已发货</h2><h4>确认收货后，即可享受玩具随意更换服务</h4></div>';

                        logistics_info = '<div class="logistics-info clear" onclick="order_detail.goLogisticsDetail()"><div class="fl"><i class="icon icon_state_car"></i></div>' +
                            '<div class="fl"><h3>' + order_detail.data.logistics_state.logistics.cont + '</h3><p>' + order_detail.data.logistics_state.logistics.time + '</p></div>' +
                            '<div class="fr"><i class="icon icon_arrowRight_bold"></i></div></div><div class="operate-btn"><button onclick="order_detail.goLogisticsDetail()">查看物流</button><button onclick="order_detail.receipt()">确认收货</button></div>';
                        break;
                    case '租用中':
                        logistics_cont = '<div class="stay"><i class="icon-big icon-big-state-zuyongzhong"></i><h2>租用中</h2>' +
                            '<h4>将租用中的玩具归还后，才能重新选择玩具再次下单</h4></div>';
                        logistics_info = '<div class="logistics-info clear"  onclick="order_detail.goLogisticsDetail()"><div class="fl"><i class="icon icon_state_qianshou"></i>' +
                            '</div><div class="fl"><h3>快件已签收</h3><p>' + order_detail.data.logistics_state.logistics.time + '</p></div>' +
                            '<div class="fr"><i class="icon icon_arrowRight_white"></i></div></div><div class="operate-btn">' +
                            '<button  onclick="order_detail.goLogisticsDetail()">查看物流</button><button onclick="order_detail.goOrderReturn()">归还玩具</button></div>';
                        break;
                    case '已归还':
                        logistics_cont = '<div class="stay"><i class="icon-big icon-big-state-yiguihuan"></i><h2>已归还</h2><div class="btn">' +
                            '<button onclick="order_detail.lookReturn()"><span>查看归还详情</span><i class="icon icon_arrowRight_white"></i></button></div>' +
                            '<h4>玩具已归还，感谢您的使用</h4></div>';
                        logistics_info = '<div class="logistics-info clear"  onclick="order_detail.goLogisticsDetail()"><div class="fl"><i class="icon icon_state_qianshou"></i>' +
                            '</div><div class="fl"><h3>快件已签收</h3><p>' + common.dateFormat(order_detail.data.logistics_state.logistics.time) + '</p></div>' +
                            '<div class="fr"><i class="icon icon_arrowRight_white"></i></div></div><div class="operate-btn">' +
                            '<button  onclick="order_detail.goLogisticsDetail()">查看物流</button></div>';
                        break;

                    default:
                        break;
                }
                $(".top-states").html(logistics_cont);
                if (!logistics_info) {
                    $(".logistics").remove();
                } else {
                    $(".logistics").html(logistics_info);
                }
                //收件人地址详细
                $(".address .address_detail .name").text(order_detail.data.logistics_state.address.a);
                $(".address .address_detail .phone").text(order_detail.data.logistics_state.address.b);
                $(".address .address_detail p span:eq(0)").text(order_detail.data.logistics_state.address.c);
                $(".address .address_detail p span:eq(1)").text(order_detail.data.logistics_state.address.d);
                $(".address .address_detail p span:eq(2)").text(order_detail.data.logistics_state.address.e);
                $(".address .address_detail h6").text(order_detail.data.logistics_state.address.f);

                console.log(order_detail.data.logistics_state.good.g);
                //商品详情
                if (!order_detail.data.logistics_state.good) {
                    $(".no-goods").show();
                    $(".detail-list").hide();
                } else {
                    $(".no-goods").hide();
                    $(".detail-list").show();
                    $(".detail-list .good_show a").attr('href', order_detail.data.logistics_state.good.h);
                    $(".detail-list .good_show .fl img").attr('src', order_detail.data.logistics_state.good.a);
                    $(".detail-list .good_show .fr h3 a").text(order_detail.data.logistics_state.good.b);
                    $(".detail-list .good_show .fr h4").text('市场参考价¥' + order_detail.data.logistics_state.good.d);
                    $(".detail-list .good_show .fr p").text(order_detail.data.logistics_state.good.c);
                    //$(".detail-list .money-detail .fr:eq(0)").text('+¥' + order_detail.data.logistics_state.good.e);
                    $(".detail-list .money-detail .fr:eq(0)").text('+¥' + order_detail.data.logistics_state.good.f);
                    $(".detail-list .money-detail .fr:eq(1)").text('+¥' + order_detail.data.logistics_state.good.g);
                    $(".detail-list .total .num").text(order_detail.data.logistics_state.good.total_num);
                    $(".detail-list .total .money").text('+¥' + order_detail.data.logistics_state.good.allPrice);

                }
                //物流编号 下单时间
                $(".order-info .number .fr input").val(order_detail.data.logistics_state.address.g);
                //$(".order-info .time .fr span").text(common.dateFormat(order_detail.data.logistics_state.address.h));
                $(".order-info .time .fr span").text(order_detail.data.logistics_state.address.h);
            })
        },
        //复制
        copy:function () {
            var Url2=document.getElementById("copy");
            Url2.select(); // 选择对象
            document.execCommand("Copy"); // 执行浏览器复制命令
            common.success_tip("订单号已复制成功！");
        },
        //确认收货
        receipt:function () {
            common.confirm_tip("确认收货","确定已经收到寄出的玩具？",null,function () {
                //order_detail.data.logistics_state
                var code = '{{$order_code}}';
                common.httpRequest('{{url('api/order/confirm_order')}}', 'post', {code:code}, function (res) {
                    $(".confirm-alert-wrap").remove();
                    location.reload();
                })
            })
        },
        //查看物流
        goLogisticsDetail:function () {
            location.href="{{url('wechat/index/logistics_detail')}}"+'/'+'{{$order_code}}';
        },
        //归还玩具
        goOrderReturn:function () {
            location.href="{{url('wechat/index/order_return_detail')}}";
        },
        //查看归还详情
        lookReturn:function () {
            location.href="{{url('wechat/index/order_return_detail')}}"+'/2';
        }
    };

    $(function () {
        order_detail.init();
    })
</script>
</body>
</html>