<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>我的</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
</head>
<body>
<div class="user-center1-wrap">
    <div class="top">
        <div class="photo">
            <table>
                <tr>
                    <td rowspan="2"><img src="/wechat/image/common/photo_default.png" alt=""></td>
                    <td class="name"><span></span><i class="icon-user_center1"></i></td>
                </tr>
                <tr>
                    <td class="phone">绑定手机:</td>
                </tr>
            </table>
        </div>
        <div class="progress">
            <div class="grey-strip">
                <div class="day-info">
                    <span class="info">会员剩余24天</span>
                    <span class="line"></span>
                </div>
                <div class="white-strip"></div>
            </div>
            <div class="time clear">
                <div class="max fl">月卡</div>
                <div class="min fr">0天</div>
            </div>
        </div>
    </div>
    <div class="continue">
        <table>
            <tr>
                <td><i class="icon-user_center3"></i></td>
                <td>未租用玩具时，会员计时将自动暂停</td>
                <td><button onclick="user_center.renew()">会员续费</button></td>
            </tr>
        </table>
    </div>
    <div class="vip-img" onclick="user_center.renew()">
        <img src="/wechat/image/common/webwxgetmsgimg.jpg">
    </div>
    <div class="items-mid bg-white">
        <table>
            <tr>
                <td onclick="user_center.exchangeToy()"><i class="icon-user_center4"></i></td>
                <td onclick="user_center.goDdeposit()"><i class="icon-user_center6"></i></td>
                <td onclick="user_center.goChooseVoucher()"><i class="icon-user_center5"></i></td>
            </tr>
            <tr>
                <td onclick="user_center.exchangeToy()">归还玩具</td>
                <td onclick="user_center.goDdeposit()">会员押金</td>
                <td onclick="user_center.goChooseVoucher()">会员抵用券</td>
            </tr>
            <tr>
                <td>正在玩件</td>
                <td>¥</td>
                <td>张</td>
            </tr>
        </table>
    </div>
    <div class="list bg-white">
        <ul>
            <li class="clear" onclick="user_center.zhima()">
                <div class="fl">
                    <div class="icon-box"><i class="icon-zmxy3"></i></div>
                    <span>免押金认证</span>
                </div>
                <div class="fr">
                    <span class="authentication"></span>
                    <i class="icon icon_arrowRight_bold"></i>
                </div>
            </li>

            <li class="clear" onclick="user_center.share()">
                <div class="fl">
                    <div class="icon-box"><i class="icon-user_center7"></i></div>
                    <span>我要分享</span>
                </div>
                <div class="fr">
                    <span>领取20元现金红包</span>
                    <i class="icon icon_arrowRight_bold"></i>
                </div>
            </li>
            <li class="clear" onclick="user_center.help()">
                <div class="fl">
                    <div class="icon-box"><i class="icon-user_center9"></i></div>
                    <span>使用帮助</span>
                </div>
                <div class="fr">
                    <i class="icon icon_arrowRight_bold"></i>
                </div>
            </li>
            <li class="clear">
                <a href="tel:{{$phone}}">
                    <div class="fl">
                        <div class="icon-box"><i class="icon-user_center8"></i></div>
                        <span>联系客服</span>
                    </div>
                    <div class="fr">
                        <span>{{$phone}}</span>
                        <i class="icon icon_arrowRight_bold"></i>
                    </div>
                </a>
            </li>
        </ul>
    </div>

    @include('wechat.common.footer')
</div>

<script>
    var user_center ={
        data:{
            userInfo:{}           //会员信息
        },
        init:function () {
            common.httpRequest('{{url('api/user/center')}}','post',{user_id:'{{$user_id}}'},function (res) {
                //假数据
                //isAuthorize false为未登录  isVip false为不是会员 isOutTime 为true为会员失效
                console.log(res);
                user_center.data.userInfo = {
                    id:res.info.user.id,
                    isAuthorize:true,
                    isVip:res.info.is_vip,
                    //isOutTime:res.info.card.isOutTime,
                    img:res.info.user.wechat_avatar,
                    name:res.info.user.wechat_nickname,
                    num:res.info.count,           //正在玩的件数
                    money:Number(res.info.user.can_use_money)+Number(res.info.user.not_can_use_money),  //押金
                    cash:true,    //是否可以提现
                    cars:res.info.coupon_nums,         //优惠卡劵
                    carSort:res.info.card.vip_card_type_str,   //卡的类型
                    time:res.info.days,
                    tel:'{{$phone}}',
                    phone:res.info.user.telephone,
                    cardType:res.info.card.vip_card_type
                };

                localStorage.out_trade_no = res.info.order_code;

                //console.log(user_center.data.userInfo);

                //判断是否登录
                if(user_center.data.userInfo.isAuthorize) {
                    //是否为会员
                    if (user_center.data.userInfo.isVip) {
                        $(".photo table tr:last,.progress,.continue").show();
                        $(".user-center1-wrap .vip-img").hide();

                        if(!user_center.data.userInfo.phone){
                            $(".photo table td.phone").remove();
                            $(".photo table tr:first td.name").prop('rowSpan', 2).find("i").show();
                        }else{
                            $(".photo table td.phone").text("绑定手机:" + user_center.data.userInfo.phone);
                        }

                        $(".user-center1-wrap .list ul li:last .fr span").text(user_center.data.userInfo.tel);
                        $(".user-center1-wrap .list ul li:last a").prop('href','tel:'+user_center.data.userInfo.tel);

                        //$(".photo table td.phone").text("绑定手机:" + user_center.data.userInfo.phone);
                        $(".photo table tr:first td.name i").prop("class", "icon-user_center1");
                        var day = 0;

                        switch (user_center.data.userInfo.cardType) {
                            case 1:
                                day = 30;
                                break;
                            case 2:
                                day = 90;
                                break;
                            case 3:
                                day = 180;
                                break;
                        }
                        var radio = user_center.data.userInfo.time * 100 / day;
                        $(".white-strip").width(radio + '%');
                        if (user_center.data.userInfo.time == 0) {
                            $(".day-info .info").css({'right': '0', 'transform': 'translateX(0)'});
                            $(".day-info .line").css({'right': '2px'});
                            $(".day-info .info").text("会员已过期").css({'background-color': '#9a9a9a','color': '#fff'});
                            $(".photo table tr:first td.name i").prop("class", "icon-user_center2");
                            $(".white-strip").css({'width': '6px'});
                        } else if (user_center.data.userInfo.time >= day) {
                            $(".day-info .line").css({'left': '2px'});
                            $(".day-info .info").css({'left': '0', 'transform': 'translateX(0)'});
                            $(".day-info .info").text("还可免费玩" + user_center.data.userInfo.time + "天");
                            $(".white-strip").css({'width': '100%'})
                        } else {
                            $(".day-info .info").text("还可免费玩" + user_center.data.userInfo.time + "天");
                            if (Math.ceil(radio) > 88) {
                                $(".day-info .info").css({'left': '12%'});
                                $(".day-info .line").css({'right': radio + '%'});
                            } else if (Math.ceil(radio) < 12) {
                                $(".day-info .info").css({'right': '0', 'transform': 'translateX(0)'});
                                $(".day-info .line").css({'left': (1 - user_center.data.userInfo.time / day) * 100 + '%'});
                            } else if (12 <= Math.ceil(radio) && Math.ceil(radio) <= 50) {
                                $(".day-info .info").css({'right': radio + '%', 'transform': 'translateX(50%)'});
                                $(".day-info .line").css({'right': radio+ '%'});
                            } else {
                                $(".day-info .info").css({
                                    'left': (1 - user_center.data.userInfo.time / day) * 100 + '%',
                                    'transform': 'translateX(-50%)'
                                });
                                $(".day-info .line").css({'left': (1 - user_center.data.userInfo.time / day) * 100 + '%'});
                            }
                        }
                    } else {
                        $(".top .photo table td img").attr('src', user_center.data.userInfo.img);
                        $(".photo table tr:last,.progress,.continue").hide();
                        $(".photo table tr:first td.name").prop('rowSpan', 2).find("i").hide();
                        $(".user-center1-wrap .top .photo").css({"padding-bottom": "40px", "padding-top": "40px"});
                        $(".user-center1-wrap .vip-img").show();
                    }
                    $(".progress .time .max").text(user_center.data.userInfo.carSort);

                    $(".top .photo table td img").attr('src',user_center.data.userInfo.img);
                    $(".photo table tr:first td.name span").text(user_center.data.userInfo.name);
                    $(".items-mid table tr:eq(2) td:first").text('正在玩'+user_center.data.userInfo.num+'件');
                    $(".items-mid table tr:eq(2) td:eq(1)").text('¥'+user_center.data.userInfo.money);
                    $(".items-mid table tr:eq(2) td:eq(2)").text(user_center.data.userInfo.cars+'张');
                }

                if(res.info.user.is_zhima==1){
                    $(".authentication").text("已认证");
                }else{
                    $(".authentication").text("未认证");
                }
            })
        },
        //续费
        renew:function(){
            var href = '{{url('wechat/index/choose_vip')}}';
            location.href = href;
            /*if(user_center.data.userInfo.isVip){
                location.href='choose_vip.html?time='+user_center.data.userInfo.num;
            }else{
                location.href='choose_vip.html?time=0';
            }*/
        },
        zhima:function () {
            location.href='{{url('wechat/index/zmxy/index')}}';
        },
        //分享给朋友
        share:function () {
            //location.href='share.html?name='+user_center.data.userInfo.name+'&num='+user_center.data.userInfo.num;
            location.href='{{url('wechat/user/share')}}';
        },
        //使用帮助
        help:function () {
            location.href='{{route('wechat.user.help')}}';
        },
        //判断是否授权
        loadWeixin:function(){
            $(".cover-user-center").fadeIn(200);
        },
        //关闭授权弹框
        colseAuthorizeAlert:function () {
            $(".cover-user-center").fadeOut(200);
        },
        //允许授权
        agreeAuthorize:function () {
            common.httpRequest('../js/test.json','get',null,function (res) {
                $(".cover-user-center").fadeOut(500);
            })
        },
        //快速换玩具
        exchangeToy:function () {
            if(user_center.data.userInfo.num==0){
                common.alert_tip1("暂时没有可归还的玩具");
                return false;
            }else{
                location.href="{{url('wechat/index/logistics_info')}}";
            }

        },
        //会员押金
        goDdeposit:function () {
            //location.href='deposit.html?yajin='+user_center.data.userInfo.money+'&id='+user_center.data.userInfo.id+'&cashState='+user_center.data.userInfo.cash;
            location.href="{{url('wechat/user/deposit')}}";
        },
        //优惠抵用券
        goChooseVoucher:function () {
            location.href='{{url('wechat/user/user_coupon')}}';
            //location.href='vip_voucher.html';
        }
    };
    $(function () {
        var user_id='{{$user_id}}';
        var get_url = '{{url('api/user/get_cart_order_num')}}';
        common.getCarAndOrder(get_url,user_id); //获取订单数量和购物车数量

        user_center.init();
    })
</script>
</body>
</html>