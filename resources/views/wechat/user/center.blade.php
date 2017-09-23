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
<div class="user-center-wrap">
    <div class="photo clear bg-white">
        <div class="fl">
            <img src="/wechat/image/common/photo_default.png">
        </div>
        <div class="fl vip">
            <!-- <h3>WeChat Name</h3>
             <div class="state-icon"><i class="icon-big icon-big-not-vip"></i></div>
             <div class="state-icon"><i class="icon-big icon-big-vip"></i></div>
             <div class="no-vip"></div>-->
        </div>
        <div class="fr">
            <button onclick="user_center.loadWeixin()">微信登录</button>
        </div>
    </div>
    <div class="items-mid bg-white">
        <table>
            <tr>
                <td onclick="user_center.exchangeToy()"><i class="icon icon_changeBear"></i></td>
                <td onclick="user_center.goDdeposit()"><i class="icon icon_yajin"></i></td>
                <td onclick="user_center.goChooseVoucher()"><i class="icon icon_coupon"></i></td>
            </tr>
            <tr>
                <td onclick="user_center.exchangeToy()">快速换玩具</td>
                <td onclick="user_center.goDdeposit()">会员押金</td>
                <td onclick="user_center.goChooseVoucher()">会员抵用券</td>
            </tr>
            <tr>
                <td>正在玩0件</td>
                <td>¥0.00</td>
                <td>3张</td>
            </tr>
        </table>
    </div>
    <div class="vip-img" onclick="user_center.renew()">
        <img src="/wechat/image/common/webwxgetmsgimg.jpg">
    </div>
    <div class="renew clear bg-white">
        <div class="fl">
            <i class="icon icon_crown"></i>
            <h3>我的会员 <span></span></h3>
        </div>
        <div class="fr">
            <span>已过期</span>
            <button onclick="user_center.renew()">续费</button>
        </div>
    </div>
    <div class="list bg-white">
        <ul>
            <li class="clear" onclick="user_center.share()">
                <div class="fl">
                    <div class="icon-box"><i class="icon icon_share"></i></div>
                    <span>我要分享</span>
                </div>
                <div class="fr">
                    <span>觉得不错，就分享给好友吧</span>
                    <i class="icon icon_arrowRight_bold"></i>
                </div>
            </li>
            <li class="clear" onclick="user_center.help()">
                <div class="fl">
                    <div class="icon-box"><i class="icon icon_help"></i></div>
                    <span>使用帮助</span>
                </div>
                <div class="fr">
                    <i class="icon icon_arrowRight_bold"></i>
                </div>
            </li>
            <li class="clear">
                <a href="tel:40021223121">
                    <div class="fl">
                        <div class="icon-box"><i class="icon icon-ic-face"></i></div>
                        <span>联系客服</span>
                    </div>
                    <div class="fr">
                        <span>400-212-23121</span>
                        <i class="icon icon_arrowRight_bold"></i>
                    </div>
                </a>
            </li>
        </ul>
    </div>

    @include('wechat.common.footer')

</div>
<div class="cover-user-center">
    <div class="cover-user-main">
        <div class="title">
            <h3>微信授权</h3>
        </div>
        <div class="tip">
            <div class="icon-tip"><i class="icon icon_bind_weixin"></i></div>
            <div class="cont">书香月亮湾微前台申请获得以下权限：</div>
        </div>
        <div class="info">
            <p><span></span><span>获得你的公开信息（昵称、头像等）</span></p>
        </div>
        <div class="btn">
            <button onclick="user_center.colseAuthorizeAlert()">拒绝</button>
            <button onclick="user_center.agreeAuthorize()">允许</button>
        </div>
    </div>
</div>

<script>
    var user_center ={
        data:{
            userInfo:{}           //会员信息
        },
        init:function () {
            common.httpRequest('../js/test.json','get',null,function (res) {
                //假数据
                //isAuthorize false为未登录  isVip false为不是会员 isOutTime 为true为会员失效
                user_center.data.userInfo = {
                    id:1,
                    isAuthorize:true,
                    isVip:true,
                    isOutTime:false,
                    img:'/wechat/image/other/3.png',
                    name:'WeChat Name',
                    num:3,           //正在玩的件数
                    money:500.00,  //押金
                    cash:true,    //是否可以提现
                    cars:3,         //优惠卡劵
                    carSort:'季度卡',   //卡的类型
                    time:5

                };
                //判断是否登录
                if(user_center.data.userInfo.isAuthorize){
                    //是否为会员
                    if( user_center.data.userInfo.isVip){
                        $(".photo .fl img").attr('src',user_center.data.userInfo.img);
                        $(".items-mid table tr:eq(2) td:first").text('正在玩'+user_center.data.userInfo.num+'件');
                        $(".items-mid table tr:eq(2) td:eq(1)").text('¥'+user_center.data.userInfo.money.toFixed(2));
                        $(".items-mid table tr:eq(2) td:eq(2)").text(user_center.data.userInfo.cars+'张');
                        $(".renew").show();
                        $(".renew h3 span").text('('+user_center.data.userInfo.carSort+')');

                        //会员是否到期
                        if(user_center.data.userInfo.isOutTime){
                            $(".photo .vip").empty();
                            $(".photo .vip").append('<h3>'+user_center.data.userInfo.name+'</h3><div class="state-icon"><i class="icon-big icon-big-not-vip"></i></div>')
                            $(".renew").show();
                            $(".renew h3 span").text('('+user_center.data.userInfo.carSort+')');
                        }else{
                            $(".photo .vip").empty();
                            $(".photo .vip").append('<h3>'+user_center.data.userInfo.name+'</h3><div class="state-icon"><i class="icon-big icon-big-vip"></i></div>')
                            $(".renew .fr span").text(user_center.data.userInfo.time+'天后到期');
                        }
                    }else{
                        $(".photo .fl img").attr('src',user_center.data.userInfo.img);
                        $(".photo .vip").empty();
                        $(".photo .vip").append('<div class="no-vip">'+user_center.data.userInfo.name+'</div>');
                        $(".photo .fr").hide();
                        $(".items-mid table tr:eq(2)").remove();
                        $(".vip-img").show();
                    }
                }else{
                    $(".photo .fr").show();
                    $(".photo .vip").hide();
                    $(".items-mid table tr:eq(2)").remove();
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
        //分享给朋友
        share:function () {
            location.href='share.html?name='+user_center.data.userInfo.name+'&num='+user_center.data.userInfo.num;
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
            location.href='order_return_detail.html?page=1';
        },
        //会员押金
        goDdeposit:function () {
            location.href='deposit.html?yajin='+user_center.data.userInfo.money+'&id='+user_center.data.userInfo.id+'&cashState='+user_center.data.userInfo.cash;
        },
        //优惠抵用券
        goChooseVoucher:function () {
            location.href='vip_voucher.html';
        }
    };
    $(function () {
        user_center.init();
    })
</script>
</body>
</html>