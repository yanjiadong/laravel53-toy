<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>选择会员类型</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
    <!--微信js-sdk-->
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
</head>
<body>
<div class="choose-vip-wrap">
    <p>您的会员有效期剩余：0天</p>
    <div class="sort">
        <ul>
            <!--<li class="clear bg-white">
                <div class="name fl">
                    <div class="time"><span>月卡</span></div>
                    <p>会员有效期+30天</p>
                </div>
                <div class="fr">
                    ¥399
                </div>
            </li>
            <li class="clear bg-white">
                <div class="name fl">
                    <div class="time">季卡</span></div>
                    <p>会员有效期+90天</p>
                </div>
                <div class="fr">
                    ¥899
                </div>

            </li>
            <li class="clear bg-white">
                <div class="name fl">
                    <div class="time"><span>半年卡</span><i class="icon-big icon-big-label-yajin"></i></div>
                    <p>会员有效期+180天</p>
                </div>
                <div class="fr">
                    ¥1499
                </div>
            </li>-->
        </ul>
    </div>
    <div class="help bg-white clear">
        <div class="fl">
            <i class="icon icon_attention"></i>
        </div>
        <div class="fr">
            <ul>
                <li>
                    <span></span>每次可挑选任意一款玩具
                </li>
                <li>
                    <span></span>不限次数更换，每个自然月提供2次往返免邮服务
                </li>
                <li>
                    <span></span>没有租用中的玩具时，会员有效期计时自动暂停
                </li>
            </ul>
        </div>
    </div>
    <div class="info bg-white">
        <div class="select clear">
            <div class="fl">
                <span></span>
            </div>
            <div class="fr">
            </div>
        </div>
        <div class="deposit clear">
            <div class="fl">
                <h3>押金</h3>
                <p>会员有效期活动后，可在“我的押金”提现退还</p>
            </div>
            <div class="fr">
            </div>
        </div>
        <div class="coupon clear" onclick="choose_vip.chooseCars()">
            <div class="fl">
                <h3>优惠券</h3>
            </div>
            <div class="fr">
                <span></span>
                <i class="icon icon_arrowRight_bold"></i>
            </div>
        </div>
    </div>
    <div class="submit clear bg-white">
        <div class="fl">
            <span>总价：</span>
            <span>¥0</span>
        </div>
        <div class="fr">
            <button onclick="choose_vip.pay()" disabled="" id="submit">去支付 <span>（微信支付）</span></button>
            <input type="hidden" value="" id="vip_card_id">
        </div>
    </div>
</div>

<script>
    var choose_vip={
        data:{
            time:'{{$days}}',
            sortList:[],
            discount:localStorage.vip_discount?JSON.parse(localStorage.vip_discount):""       //优惠券卡
        },
        init:function () {
            if(eval(choose_vip.data.time)){
                $(".choose-vip-wrap>p").text('您的会员有效期剩余：'+choose_vip.data.time+'天');
            }
            console.log(choose_vip.data.discount);
            //获取会员卡数据
            common.httpRequest('{{url('api/user/vip_cards')}}','post',null,function (res) {
                /*choose_vip.data.sortList =[
                    {time:30,money:399,yajin:600,cars:{money:100}},
                    {time:90,money:899,yajin:600,cars:{money:200}},
                    {time:120,money:1499,yajin:0,cars:{money:200}}
                ];*/

                choose_vip.data.sortList = res.info.list;
                console.log(choose_vip.data.sortList);
                var cont='';
                for(var i=0;i<choose_vip.data.sortList.length;i++){
                    switch(choose_vip.data.sortList[i].type){
                        case 1:
                            cont+='<li class="clear bg-white"><div class="name fl"><div class="time"><span>月卡</span></div>'+
                                '<p>会员有效期+30天</p></div><div class="fr">¥'+choose_vip.data.sortList[i].price+'</div></li>';
                            break;
                        case 2:
                            cont+='<li class="clear bg-white"><div class="name fl"><div class="time"><span>季卡</span></div>'+
                                '<p>会员有效期+90天</p></div><div class="fr">¥'+choose_vip.data.sortList[i].price+'</div><span class="check-bg"></span> <span class="check">√</span></li>';
                            //$(".info .select .fl span").text("季卡（+90天）");
                            //$(".info .select .fr").text('¥'+choose_vip.data.sortList[i].price);
                            //$(".info .deposit .fr").text('¥'+choose_vip.data.sortList[i].money);
                            //$(".info .coupon .fr span").text('-¥'+0);
                            //$(".submit .fl span:eq(1)").text('¥'+(choose_vip.data.sortList[i].price+choose_vip.data.sortList[i].money));
                            break;
                        case 3:
                            cont+='<li class="clear bg-white"><div class="name fl"><div class="time"><span>半年卡</span><i class="icon-big icon-big-label-yajin"></i></div>'+
                                '<p>会员有效期+180天</p></div><div class="fr">¥'+choose_vip.data.sortList[i].price+'</div></li>';
                            //$(".info .deposit .fr").text('0.00');
                            break;
                        default:
                            break;
                    }
                }
                $(".sort ul").html(cont);
                choose_vip.choose();
            })
        },
        //选择会员卡
        choose:function () {
            var $item =$(".choose-vip-wrap .sort ul li");
            $item.click(function () {
                $item.removeClass("active");
                $item.find(".check-bg").remove();
                $item.find(".check").remove();
                $(this).addClass("active");
                $(this).append('<span class="check-bg"></span><span class="check">√</span>');
                var time =parseInt($(this).find("p").text().substr(6));
                var cont='';
                switch(time){
                    case 30:
                        $(".info .select .fl span").text("月卡（+30天）");
                        break;
                    case 90:
                        $(".info .select .fl span").text("季卡（+90天）");
                        break;
                    case 180:
                        $(".info .select .fl span").text("半年卡（+180天）");
                        break;
                }
                $(".info .select .fr").text($(this).find(".fr").text());
                var index =$(this).index(".choose-vip-wrap .sort ul li");
                $(".info .deposit .fr").text('¥'+choose_vip.data.sortList[index].money);

                if(!choose_vip.data.discount){
                    $(".info .coupon .fr span").text('请选择');
                    $(".submit .fl span:eq(1)").text('¥'+(choose_vip.data.sortList[index].price+choose_vip.data.sortList[index].money));
                }else{
                    $(".info .coupon .fr span").text('-¥'+choose_vip.data.discount.price);
                    $(".submit .fl span:eq(1)").text('¥'+(choose_vip.data.sortList[index].price+choose_vip.data.sortList[index].money-choose_vip.data.discount.price));
                }
                console.log(choose_vip.data.discount);
                //$(".info .coupon .fr span").text('-¥'+0);
                //$(".submit .fl span:eq(1)").text('¥'+(choose_vip.data.sortList[index].price+choose_vip.data.sortList[index].money-0));

                $("#vip_card_id").val(choose_vip.data.sortList[index].id);
                $("#submit").attr("disabled", false);
            })
        },
        //选择优惠卷
        //选择优惠卷
        chooseCars:function () {
            location.href='{{url('wechat/user/choose_coupon')}}';
        },
        //微信支付
        pay:function () {
            var vip_card_id = $("#vip_card_id").val();
            if(!choose_vip.data.discount){
                var coupon_id = 0;
            }else{
                var coupon_id = choose_vip.data.discount.id
            }

            location.href="{{url('wechat/index/pay_vip_card')}}"+'/'+vip_card_id+'/'+coupon_id;
            /*common.alert_tip("请前往个人中心查看会员详情",'#323232','支付成功',function () {
                location.href="user_center.html";
            });*/
            /* wx.chooseWXPay({
             timestamp: 0, // 支付签名时间戳，注意微信jssdk中的所有使用timestamp字段均为小写。但最新版的支付后台生成签名使用的timeStamp字段名需大写其中的S字符
             nonceStr: '', // 支付签名随机串，不长于 32 位
             package: '', // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=***）
             signType: '', // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
             paySign: '', // 支付签名
             success: function (res) {
             // 支付成功后的回调函数
             common.alert_tip("请前往个人中心查看会员详情",'#323232','支付成功',function () {
             location.href="user_center.html";

             });
             }
             });*/
        }


    };
    $(function () {
        choose_vip.init();
        /*wx.config({
         debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
         appId: '', // 必填，公众号的唯一标识
         timestamp: , // 必填，生成签名的时间戳
         nonceStr: '', // 必填，生成签名的随机串
         signature: '',// 必填，签名，见附录1
         jsApiList: [] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
         });*/

        //
    })
</script>
</body>
</html>