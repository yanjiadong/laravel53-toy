<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>租赁订单</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
</head>
<body>

<div class="order-detail-wrap">
    <nav class="bg-white">
        <ul class="clear">
            <li class="fl tab-btn active" data-tab="0"><span>进行中</span></li>
            <li class="fr tab-btn" data-tab="1"><span>已归还</span></li>
        </ul>
    </nav>
    <div class="order-detail-main">
        <div class="parent-box clear">
            <div class="detail-cont tab-page fl">
                <div class="top-tips">
                    同一时间内只能持有一件玩具，待归还后才能再次租用，如需归还租用中的玩具，请点击“归还玩具”并上传物流单号，即可再次下单
                </div>
                <ul class="detail-list">
                    <!--  <li class="bg-white">
                          <div class="top clear">
                              <div class="fl">已租用1天</div>
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
                                          WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人
                                      </a>
                                  </h3>
                                  <h4>适用年龄1-12岁</h4>
                                  <p>市场参考价¥2500.00</p>
                              </div>
                          </div>
                          <div class="order-number clear">
                              <div class="fl">租赁订单编号</div>
                              <div class="fr">13243213435</div>
                          </div>
                          <div class="total clear">
                              <div class="fl">
                                  <p>共1件商品</p>
                                  <h3>合计：<span>+¥300.00</span></h3>
                              </div>
                              <div class="fr">
                                  <button>确认收货</button>
                                  <button>查看物流</button>
                              </div>
                          </div>
                      </li>-->
                </ul>
            </div>
            <div class="return tab-page fl">
                <ul class="detail-list">
                    <!--  <li class="bg-white">
                          <div class="top clear">
                              <div class="fl">共租用1天</div>
                              <div class="fr"><a href="">已归还，查看归还详情</a><i class="icon icon_arrowRight_red"></i></div>
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
                                          WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人
                                      </a>
                                  </h3>
                                  <h4>适用年龄1-12岁</h4>
                                  <p>市场参考价¥2500.00</p>
                              </div>
                          </div>
                          <div class="order-number clear">
                              <div class="fl">租赁订单编号</div>
                              <div class="fr">13243213435</div>
                          </div>
                          <div class="total clear">
                              <div class="fl">
                                  <p>共1件商品</p>
                                  <h3>合计：<span>+¥300.00</span></h3>
                              </div>
                              <div class="fr">
                                  <button>确认收货</button>
                                  <button>查看物流</button>
                              </div>
                          </div>
                      </li>
                      <li class="bg-white">
                          <div class="top clear">
                              <div class="fl">共租用1天</div>
                              <div class="fr"><a href="">已归还，查看归还详情</a><i class="icon icon_arrowRight_red"></i></div>
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
                                          WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人
                                      </a>
                                  </h3>
                                  <h4>适用年龄1-12岁</h4>
                                  <p>市场参考价¥2500.00</p>
                              </div>
                          </div>
                          <div class="order-number clear">
                              <div class="fl">租赁订单编号</div>
                              <div class="fr">13243213435</div>
                          </div>
                          <div class="total clear">
                              <div class="fl">
                                  <p>共1件商品</p>
                                  <h3>合计：<span>+¥300.00</span></h3>
                              </div>
                          </div>
                      </li>-->
                </ul>
            </div>
        </div>
    </div>

    @include('wechat.common.footer')
</div>


<script>
    var orderDtail = {
        data:{
            list:[],            //进行中列表
            returnList:[]       //已归还列表
        },
        init:function () {
            orderDtail.getList();
            orderDtail.getReturnList();
        },
        cont_width:$(".order-detail-wrap").width(),
        //导航切换
        tab_change:function () {
            $(".order-detail-wrap").height($(window).height());
            $(".order-detail-main").height($(".tab-page").eq(0).height()+"px");
            var tab_btn = $(".order-detail-wrap nav ul li");
            tab_btn.click(function () {
                var num = $(this).attr("data-tab");
                $("body").scrollTop("0");
                $(".order-detail-main").height($($(".tab-page")[num]).height()+"px");
                tab_btn.removeClass("active");
                $(this).addClass("active");
                $(".order-detail-main .parent-box").animate({left:-num*orderDtail.cont_width+"px"},1000);
            })
        },
        //进行中 --数据加载
        getList:function () {
            common.httpRequest('{{url('api/order/order_list')}}','post',{type:1,user_id:'{{$user_id}}'},function (res) {
                if(true){

                    //  orderDtail.data.returnList = res;
                    //b为发货状态  1为待发货 2是已发货 3.租用中
                    /*orderDtail.data.list = [
                        {a:1,b:1,c:'../image/other/3.png',d:' WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人',
                            e:'/view/good_detail.html',f:'1-12岁',h:2500.00,g:131452365895,i:1,j:300.00,id:0},
                        {a:1,b:2,c:'../image/other/3.png',d:' WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人',
                            e:'/view/good_detail.html',f:'1-12岁',h:2500.00,g:131452365895,i:1,j:300.00,id:1},
                        {a:1,b:3,c:'../image/other/3.png',d:' WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人',
                            e:'/view/good_detail.html',f:'1-12岁',h:2500.00,g:131452365895,i:1,j:300.00,id:2}
                    ];*/

                    orderDtail.data.list = res.info.list;
                    console.log(res.info.list);
                    var dataList ='';
                    for(var i=0;i<orderDtail.data.list.length;i++){
                        switch(orderDtail.data.list[i].status){
                            case '待发货':
                                dataList +='<li class="bg-white"><div class="top clear"><div class="fl">已租用'+orderDtail.data.list[i].days+'天</div>' +
                                    '<div class="fr">待发货</div></div><div class="good-detail clear"><div class="fl">' +
                                    '<a href="'+orderDtail.data.list[i].e+'"><img src="'+orderDtail.data.list[i].good_picture+'"/></a></div><div class="fr"><h3><a href="'+'{{url('wechat/index/good')}}'+'/'+orderDtail.data.list[i].id+'">'+orderDtail.data.list[i].good_title+'</a>' +
                                    '</h3><h4>'+orderDtail.data.list[i].good_brand.title+'</h4><p>市场参考价¥'+orderDtail.data.list[i].good_price+'</p></div></div><div class="order-number clear"><div class="fl">租赁订单编号</div>' +
                                    '<div class="fr">'+orderDtail.data.list[i].code+'</div></div><div class="total clear"><div class="fl"><p>共'+'1'+'件商品</p>' +
                                    '<h3>合计：<span>+¥'+orderDtail.data.list[i].price+'</span></h3></div></div></li>';
                                break;
                            case '已发货':
                                dataList +='<li class="bg-white"><div class="top clear"><div class="fl">已租用'+orderDtail.data.list[i].days+'天</div>' +
                                    '<div class="fr">已发货</div></div><div class="good-detail clear"><div class="fl">' +
                                    '<a href="'+orderDtail.data.list[i].e+'"><img src="'+orderDtail.data.list[i].good_picture+'"/></a></div><div class="fr"><h3><a href="'+'{{url('wechat/index/good')}}'+'/'+orderDtail.data.list[i].id+'">'+orderDtail.data.list[i].good_title+'</a>' +
                                    '</h3><h4>'+orderDtail.data.list[i].good_brand.title+'</h4><p>市场参考价¥'+orderDtail.data.list[i].good_price+'</p></div></div><div class="order-number clear"><div class="fl">租赁订单编号</div>' +
                                    '<div class="fr">'+orderDtail.data.list[i].code+'</div></div><div class="total clear"><div class="fl"><p>共'+'1'+'件商品</p>' +
                                    '<h3>合计：<span>+¥'+orderDtail.data.list[i].price+'</span></h3></div><div class="fr"><button class="confirm-receipt" onclick="orderDtail.receipt('+orderDtail.data.list[i].code+')">确认收货</button><button class="logistics" onclick="orderDtail.goLogisticsDetail()">查看物流</button></div></div></li>';
                                break;
                            case '租用中':
                                dataList +='<li class="bg-white"><div class="top clear"><div class="fl">已租用'+orderDtail.data.list[i].days+'天</div>' +
                                    '<div class="fr">租用中</div></div><div class="good-detail clear"><div class="fl">' +
                                    '<a href="'+orderDtail.data.list[i].e+'"><img src="'+orderDtail.data.list[i].good_picture+'"/></a></div><div class="fr"><h3><a href="'+'{{url('wechat/index/good')}}'+'/'+orderDtail.data.list[i].id+'">'+orderDtail.data.list[i].good_title+'</a>' +
                                    '</h3><h4>'+orderDtail.data.list[i].good_brand.title+'</h4><p>市场参考价¥'+orderDtail.data.list[i].good_price+'</p></div></div><div class="order-number clear"><div class="fl">租赁订单编号</div>' +
                                    '<div class="fr">'+orderDtail.data.list[i].code+'</div></div><div class="total clear"><div class="fl"><p>共'+'1'+'件商品</p>' +
                                    '<h3>合计：<span>+¥'+orderDtail.data.list[i].price+'</span></h3></div><div class="fr"><button class="confirm-receipt" onclick="orderDtail.goReturn()">归还玩具</button><button class="logistics" onclick="orderDtail.goLogisticsDetail()">查看物流</button></div></div></li>';
                                break;
                            default:
                                break;
                        }
                    }
                    $(".detail-cont .detail-list").html(dataList).show();
                    $(".order-detail-main").height($(".tab-page").eq(0).height()+"px");

                }
            })
        },
        //已归还 --数据加载
        getReturnList:function(){
            common.httpRequest('{{url('api/order/order_list')}}','post',{type:2,user_id:'{{$user_id}}'},function (res) {
                if(true){
                    //  orderDtail.data.returnList = res;
                    //假数据
                    /*orderDtail.data.returnList = [
                        {a:1,b:1,c:'../image/other/3.png',d:' WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人',
                            e:'#',f:'1-12岁',h:2500.00,g:131452365895,i:1,j:300.00},
                        {a:1,b:2,c:'../image/other/3.png',d:' WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人',
                            e:'#',f:'1-12岁',h:2500.00,g:131452365895,i:1,j:300.00},
                        {a:1,b:3,c:'../image/other/3.png',d:' WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人',
                            e:'#',f:'1-12岁',h:2500.00,g:131452365895,i:1,j:300.00}
                    ];*/

                    orderDtail.data.returnList = res.info.list;
                    var dataList ='';
                    for(var i=0;i<orderDtail.data.returnList.length;i++){
                        dataList +='<li class="bg-white"><div class="top clear"><div class="fl">共租用'+orderDtail.data.returnList[i].a+'天</div><div class="fr" onclick="orderDtail.goReturned()">' +
                            '<a href="javascript:;">已归还，查看归还详情</a><i class="icon icon_arrowRight_red"></i></div></div>' +
                            '<div class="good-detail clear"><div class="fl"> <a href="'+orderDtail.data.returnList[i].e+'"><img src="'+orderDtail.data.returnList[i].c+'"></a></div>' +
                            '<div class="fr"><h3><a href="'+orderDtail.data.returnList[i].e+'">'+orderDtail.data.returnList[i].d+'</a></h3><h4>适用年龄'+orderDtail.data.returnList[i].f+'</h4><p>市场参考价¥'+orderDtail.data.returnList[i].h+'</p></div></div>' +
                            '<div class="order-number clear"><div class="fl">租赁订单编号</div><div class="fr">'+orderDtail.data.returnList[i].g+'</div></div>' +
                            '<div class="total clear"><div class="fl"><p>共'+orderDtail.data.returnList[i].i+'件商品</p><h3>合计：<span>+¥'+orderDtail.data.returnList[i].j+'</span></h3></div>' +
                            '</div></li>';
                    }
                    $(".return .detail-list").html(dataList).show();
                }
            })
        },
        //确认收货
        receipt:function (code) {
            common.confirm_tip("提示","确定已经收货完成？",null,function () {
                common.httpRequest('{{url('api/order/confirm_order')}}','post',{code:code},function (res) {
                    if(res.code==200){
                        $(".confirm-alert-wrap").remove();
                        //location.reload();
                    }else{

                    }
                })
            });
            //debugger;
        },
        //查看物流
        goLogisticsDetail:function () {
            location.href="/view/logistics_detail.html";
        },
        //归还玩具
        goReturn:function () {
            location.href="{{url('wechat/index/order_return_detail')}}";
        },
        //查看归还详情
        goReturned:function () {
            location.href="index/order_return_detail";
        }
    };
    $(function () {
        orderDtail.tab_change();
        orderDtail.init();
    })
</script>

</body>
</html>
