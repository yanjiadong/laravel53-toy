<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>我的</title>
    <link href="{{ asset('wechat2/style/reset.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/common.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/style.css') }}" rel="stylesheet" type="text/css">

    <script src="{{ asset('wechat2/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('wechat2/js/common.js') }}"></script>
</head>
<body>
<div class="user-center-wrap">
    <div class="top">
        <table>
            <tr>
                <td class="name">败家小二二</td>
                <td rowspan="2" class="pic"><img src="" alt=""></td>
            </tr>
            <tr onclick="user_center.loadWeixin()">
                <td class="phone"><i class="user-center"></i><span></span></td>
            </tr>
        </table>
    </div>
    <div class="mid">
        <table class="table">
            <tr>
                <td onclick="user_center.exchangeToy()"><i class="user-center rent"></i></td>
                <td onclick="user_center.goDdeposit()"><i class="user-center yajin"></i></td>
                <td onclick="user_center.goChooseVoucher()"><i class="user-center discount"></i></td>
            </tr>
            <tr>
                <td onclick="user_center.exchangeToy()">正在租</td>
                <td onclick="user_center.goDdeposit()">我的押金</td>
                <td onclick="user_center.goChooseVoucher()">优惠券</td>
            </tr>
            <tr>
                <td onclick="user_center.exchangeToy()">3件</td>
                <td onclick="user_center.goDdeposit()">¥800</td>
                <td onclick="user_center.goChooseVoucher()">3张</td>
            </tr>
        </table>
        <div class="pic"><a href="#"><img src="/wechat2/image/other/lunbo2.jpg"></a></div>
        <div class="list">
            <ul>
                <li class="clear" onclick="user_center.zmxy()">
                    <div class="fl">
                        <span>免押金认证</span>
                    </div>
                    <div class="fr">
                        <span class="authentication">认证芝麻信用分</span>
                        <i class="icon icon_arrowRight_bold"></i>
                    </div>
                </li>
                <li class="clear" onclick="user_center.share()">
                    <div class="fl">
                        <span>我要分享</span>
                    </div>
                    <div class="fr">
                        <span>领取20元现金红包</span>
                        <i class="icon icon_arrowRight_bold"></i>
                    </div>
                </li>
            </ul>
        </div>
        <div class="contact">
            <a href="tel:4006360816">
                客服电话：400-636-0816（每天10:30-18:00）
            </a>
        </div>
    </div>
    @include('wechat2.common.footer')
</div>


<script>
    var user_center ={
        data:{
            userInfo:{}           //会员信息
        },
        //获取个人中心信息
        init:function () {
            common.httpRequest("{{ url('api/user/user_center') }}",'post',{user_id:'{{$user_id}}'},function (res) {
                //假数据
                //1、用户手机未绑定是返回的"" 绑定返回手机号
                //isAuthorize 标记芝麻是否认证  true为已认证  false为未认证
                console.log(res);
                user_center.data.userInfo = {
                    id:res.info.user.id,
                    isAuthorize:res.info.user.is_zhima,    //标记芝麻是否认证
                    img:res.info.user.wechat_avatar,//用户头像
                    name:res.info.user.wechat_nickname,  //用户名
                    num:res.info.order_num,           //正在租的数量
                    money:res.info.money,  //押金总额
                    cars:res.info.coupon_nums,         //优惠卡总张数
                    tel:res.info.tel, //客服电话
                    service_time:res.info.service_time, //客服电话
                    phone:res.info.user.telephone, //用户手机
                    active_pic:res.info.activity.picture, //活动图片，后台上传比例为960*300
                    active_url:res.info.activity.url
                };
                //赋值
                //console.log(user_center.data.userInfo.isAuthorize);
                $(".user-center-wrap .top table tr td.name").text(user_center.data.userInfo.name);
                $(".user-center-wrap .top table tr td.phone span").text(!user_center.data.userInfo.phone?'未绑定手机号':user_center.data.userInfo.phone);
                $(".user-center-wrap .top table tr td.pic img").attr('src',!user_center.data.userInfo.img?'/wechat2/image/common/photo_default.png':user_center.data.userInfo.img);
                $(".user-center-wrap .mid table.table tr:nth-child(3) td:first").text(user_center.data.userInfo.num+'件');
                $(".user-center-wrap .mid table.table tr:nth-child(3) td:eq(1)").text('¥'+user_center.data.userInfo.money);
                $(".user-center-wrap .mid table.table tr:nth-child(3) td:eq(2)").text(user_center.data.userInfo.cars+'张');
                $(".user-center-wrap .mid .pic img").attr('src',user_center.data.userInfo.active_pic);
                $(".user-center-wrap .mid .list ul li .fr:first span").text(!user_center.data.userInfo.isAuthorize?"免押金认证":"已认证");
                $(".user-center-wrap .mid .contact a").prop('href','tel:'+user_center.data.userInfo.tel);
                $(".user-center-wrap .mid .contact a").text('客服电话：'+((user_center.data.userInfo.tel).slice(0,3)+'-'+(user_center.data.userInfo.tel).slice(3,6)+'-'+(user_center.data.userInfo.tel).slice(6))+'（'+user_center.data.userInfo.service_time+'）');

                $(".user-center-wrap .mid .pic a").attr('href',user_center.data.userInfo.active_url);
            });
        },
        //分享给朋友
        share:function () {
            location.href='share.html?name='+user_center.data.userInfo.name+'&num='+user_center.data.userInfo.num;
        },
        //判断是否绑定手机号
        loadWeixin:function(){
            if($(".user-center-wrap .top table tr td.phone span").text()=='未绑定手机号'){
                $(".cover-user-center").fadeIn(500);
            }
        },
        //关闭绑定手机号弹框
        colseAuthorizeAlert:function () {
            $(".cover-user-center").fadeOut(200);
        },
        //绑定手机号提交
        agreeAuthorize:function () {
            common.httpRequest('../js/test.json','get',null,function (res) {
                $(".cover-user-center").fadeOut(500);
            })
        },

        //正在租玩具
        exchangeToy:function () {
            if(user_center.data.userInfo.num==0){
                common.alert_tip1("暂时没有可归还的玩具");
                return false;
            }else{
                location.href='logistics_info.html';
            }
        },
        //会员押金
        goDdeposit:function () {
            location.href="{{route('wechat2.user.my_deposit')}}";
        },
        //优惠抵用券
        goChooseVoucher:function () {
            location.href='vip_voucher.html';
        },
        //芝麻信用认证
        zmxy:function () {
            location.href="{{ url('wechat2/index/zmxy/index') }}";
        }
    };
    $(function(){
        var user_id='{{$user_id}}';
        var get_url = '{{url('api/user/get_cart_order_num')}}';
        common.getCarAndOrder(get_url,user_id); //获取订单数量和购物车数量

        user_center.init();
    })
</script>
</body>
</html>