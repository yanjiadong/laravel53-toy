<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>快速换玩具</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
</head>
<body>

<div class="order-return-wrap">
    <nav class="bg-white">
        <ul class="clear">
            <li class="fl active" data-tab="0"><span>可寄回更换</span></li>
            <li class="fr" data-tab="1"><span>归还详情</span></li>
        </ul>
    </nav>
    <div class="order-return-main">
        <div class="parent-box clear">
            <div class="return fl tab-page">
                <div class="top-tips">
                    <p></p>
                    <h4></h4>
                </div>
                <div class="title bg-white">
                    <i class="icon icon_position"></i>
                    <p>寄回地址</p>
                </div>


                <div class="info clear bg-white">
                    <table>
                        <tr>
                            <td>收件人：</td>
                            <td class="name"></td>
                        </tr>
                        <tr>
                            <td>电&nbsp;&nbsp;&nbsp;&nbsp;话：</td>
                            <td class="cell"></td>
                        </tr>
                        <tr>
                            <td>地&nbsp;&nbsp;&nbsp;&nbsp;址：</td>
                            <td class="address"></td>
                        </tr>
                    </table>
                </div>
                <div class="detail-list">
                    <div class="title bg-white">
                        <i class="icon icon_bear"></i>租用中的玩具
                    </div>
                    <div class="no-good">
                        <div class="tips">
                            <i class="icon-big icon-big-blankPage"></i>
                            <h4>没有可归还的玩具</h4>
                        </div>
                    </div>
                    <ul>

                    </ul>
                </div>
            </div>

            <div class="detail-cont fl tab-page">
                <div class="top-tips">
                    请完整的寄回租用的玩具，若玩具损坏或零件丢失请提前联系客服，否则将会影响下一次快速换玩具功能
                </div>
                <div class="detail-list">
                    <ul>

                    </ul>
                    <div class="no-good">
                        暂无归还玩具！
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
            //var page = common.getParam('page');
            var page = '{{$page}}';
            if(page=='1'){
                $(".order-return-wrap nav ul li").removeClass("active");
                $(".order-return-wrap nav ul li:eq(0)").addClass("active");
                $(".order-return-main .parent-box .tab-page").hide();
                $(".order-return-main .parent-box .tab-page").eq(0).show();
            }else{
                $(".order-return-wrap nav ul li").removeClass("active");
                $(".order-return-wrap nav ul li:eq(1)").addClass("active");
                $(".order-return-main .parent-box .tab-page").hide();
                $(".order-return-main .parent-box .tab-page").eq(1).show();
            }
            good_return.getList();
            good_return.getDetailList();
        },
        cont_width:$(".order-return-wrap").width(),
        //导航切换
        tab_change:function () {
            $(".order-return-wrap").height($(window).height());
            var tab_btn = $(".order-return-wrap nav ul li");
            tab_btn.click(function () {
                var num = $(this).attr("data-tab");
                $("body").scrollTop("0");
                tab_btn.removeClass("active");
                $(this).addClass("active");
                $(".order-return-main .parent-box .tab-page").hide();
                $(".order-return-main .parent-box .tab-page").eq(num).show()
            });
        },
        //可寄回更换 --数据加载
        getList:function () {
            //地址信息
            common.httpRequest('{{url('api/order/order_can_back')}}','post',{user_id:'{{$user_id}}'},function (res) {
                // good_return.returnInfo = res;
                //假数据
                good_return.returnInfo ={
                    a:'将租用中玩具通过以下地址寄回，优先使用顺丰快递（或圆通、中通、韵达），选择货到付款方式即可。',
                    c:res.info.name,
                    d:res.info.address,
                    h:res.info.telephone
                };
                $(".return .top-tips").text(good_return.returnInfo.a);
                $(".return .info table tr td.name").text(good_return.returnInfo.c);
                $(".return .info table tr td.cell").text(good_return.returnInfo.h);
                $(".return .info table tr td.address").text(good_return.returnInfo.d);

            });
            //列表
            common.httpRequest('{{url('api/order/order_can_back')}}','post',{user_id:'{{$user_id}}'},function (res) {
                    //  good_return.data.returnList = res;
                    /*good_return.data.list = [
                        {a:1,b:1,c:'../image/other/3.png',d:' WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人',
                            e:'#',f:'1-12岁',h:2500.00,g:131452365895,i:1,j:300.00,id:0},
                        {a:1,b:2,c:'../image/other/3.png',d:' WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人',
                            e:'#',f:'1-12岁',h:2500.00,g:131452365895,i:1,j:300.00,id:1},
                        {a:1,b:3,c:'../image/other/3.png',d:' WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人',
                            e:'#',f:'1-12岁',h:2500.00,g:131452365895,i:1,j:300.00,id:2}
                    ];*/

                    if(res.info.list.length > 0)
                    {
                        good_return.data.list = res.info.list;
                        var dataList ='';
                        for(var i=0;i<good_return.data.list.length;i++){
                            dataList +='<li><div class="top"><div class="cont bg-white"><div class="good-time">' +
                                '<h5>已租用'+good_return.data.list[i].days+'天</h5><div class="number">租赁订单编号：'+good_return.data.list[i].code+'</div></div>' +
                                '<div class="good-detail clear"><div class="fl"><a href="'+'#'+'"><img src="'+good_return.data.list[i].good_picture+'">' +
                                '</a></div><div class="fr"><h3><a href="'+'#'+'">'+good_return.data.list[i].good_title+'</a></h3><p>市场参考价¥'+good_return.data.list[i].good_price+'</p>' +
                                '<h4>适用年龄'+good_return.data.list[i].good_old+'岁</h4></div></div><div class="btn clear"><button onclick="good_return.goFillLogistics('+i+')">玩具已寄回，上传物流单号</button></div></div> </li>';
                        }
                        $(".return .detail-list ul").html(dataList).show();
                    }
                    else
                    {
                        $(".tips-bottom").hide();
                        $(".return .detail-list ul").hide();
                        $(".return .no-good").height($(window).height()-$(".return .top-tips").outerHeight()
                            -$(".return .title").height()-$(".return .info").height()-88-44+'px').show();
                    }
            })
        },
        getDetailList:function () {
            //列表
            common.httpRequest('{{url('api/order/order_back_list')}}','post',{'user_id':'{{$user_id}}'},function (res) {
                console.log(res);
                if(true){
                    //  good_return.data.detailList = res;
                    /*good_return.data.detailList = [
                        {a:15,b:1,c:'../image/other/3.png',d:' WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人',
                            e:'#',f:'1-12岁',h:2500.00,g:131452365895,i:1,j:300.00,k:'2017.8.12',l:'2017.8.12',m:'fsaf465465745145',id:0},
                        {a:15,b:2,c:'../image/other/3.png',d:' WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人',
                            e:'#',f:'1-12岁',h:2500.00,g:131452365895,i:1,j:300.00,k:'2017.8.12',l:'2017.8.12',m:'fsaf465465745145',id:0},
                    ];*/
                    good_return.data.detailList = res.info.list;
                    var dataList ='';
                    for(var i=0;i<good_return.data.detailList.length;i++){
                        switch (good_return.data.detailList[i].back_status){
                            case '待验证':
                                dataList +='<li class="bg-white"><div class="top clear"><div class="fl">' +
                                    '<p>租期：'+good_return.data.detailList[i].confirm_time_new+'-'+good_return.data.detailList[i].back_time_new+'<span>共'+good_return.data.detailList[i].days+'天</span></p><p>租赁订单编号：'+good_return.data.detailList[i].code+'</p>' +
                                    '</div><div class="fr">待平台验货确认</div></div><div class="good-detail clear"><div class="fl">' +
                                    '<a href="'+'#'+'"><img src="'+good_return.data.detailList[i].good_picture+'"></a></div><div class="fr"><h3>' +
                                    '<a href="'+good_return.data.detailList[i].e+'">'+good_return.data.detailList[i].good_title+'</a></h3><h4>适用年龄'+good_return.data.detailList[i].good_old+'</h4><p>市场参考价¥'+good_return.data.detailList[i].good_price+'</p></div></div>' +
                                    '<div class="return-info clear"><div class="fl"><p>寄回物流信息</p><h4>物流单号：'+good_return.data.detailList[i].back_express_no+'（'+good_return.data.detailList[i].back_express_title+'）</h4>' +
                                    '</div><div class="fr"></div></div></li>';
                                break;
                            case '已验证':
                                dataList +='<li class="bg-white"><div class="top clear"><div class="fl">' +
                                    '<p>租期：'+good_return.data.detailList[i].confirm_time_new+'-'+good_return.data.detailList[i].back_time_new+'<span>共'+good_return.data.detailList[i].days+'天</span></p><p>租赁订单编号：'+good_return.data.detailList[i].code+'</p>' +
                                    '</div><div class="fr done">已验货确认</div></div><div class="good-detail clear"><div class="fl">' +
                                    '<a href="'+'#'+'"><img src="'+good_return.data.detailList[i].good_picture+'"></a></div><div class="fr"><h3>' +
                                    '<a href="'+good_return.data.detailList[i].e+'">'+good_return.data.detailList[i].good_title+'</a></h3><h4>适用年龄'+good_return.data.detailList[i].good_old+'</h4><p>市场参考价¥'+good_return.data.detailList[i].good_price+'</p></div></div>' +
                                    '<div class="return-info clear"><div class="fl"><p>寄回物流信息</p><h4>物流单号：'+good_return.data.detailList[i].back_express_no+'（'+good_return.data.detailList[i].back_express_title+'）</h4>' +
                                    '</div><div class="fr"></div></div></li>';
                                break;
                            default:
                                break;
                        }

                    }
                    $(".detail-cont .detail-list ul").html(dataList).show();

                }else{
                    $(".detail-cont .detail-list ul").hide();
                    var no_good_height = $(window).height()-$(".detail-cont .top-tips").outerHeight()
                        -44+'px';
                    $(".detail-cont .no-good").height(no_good_height).show();
                    $(".detail-cont .no-good").css('line-height',no_good_height);
                }
            })
        },
        //确认已归还
        goFillLogistics:function (index) {
            localStorage.order_fill_logistics = JSON.stringify(good_return.data.list[index]);
            //localStorage.order_fill_logistics = good_return.data.list[index];
            //console.log(localStorage.order_fill_logistics);
            //alert(code);
            location.href = "{{url('wechat/index/fill_logistics')}}";
        }
    };
    $(function () {
        good_return.init();
        good_return.tab_change();
    })
</script>
</body>
</html>
