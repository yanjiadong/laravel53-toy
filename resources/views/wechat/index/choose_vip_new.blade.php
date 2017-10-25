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
</head>
<body>
<div class="choose-vip-wrap-new">
    <div class="vip-info">
        <p>您的会员有效期剩余：0天</p>
        <div class="sort">
            <ul>
                <li>
                    <img src="/wechat/image/common/month.png">
                </li>
                <li class="active">
                    <img src="/wechat/image/common/half_year.png">
                </li>
                <li>
                    <img src="/wechat/image/common/quarter.png">
                </li>

            </ul>
        </div>
        <div class="dot">
            <span></span>
            <span class="active"></span>
            <span></span>
        </div>
    </div>
    <div class="help">
        <i class="icon-choose-vip3"></i>
        <table>
            <tr>
                <td><i class="icon-choose-vip4"></i></td>
                <td><i class="icon-choose-vip1"></i></td>
                <td><i class="icon-choose-vip5"></i></td>
                <td><i class="icon-choose-vip2"></i></td>
            </tr>
            <tr>
                <td>所有玩具免费租</td>
                <td>不限次数更换</td>
                <td>往返免邮费</td>
                <td>不租不扣时间</td>
            </tr>
        </table>
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
                <p>会员有效期结束后，可在“会员押金”提现退还</p>
            </div>
            <div class="fr">
            </div>
        </div>
        <div class="coupon clear" onclick="choose_vip.chooseCars()">
            <div class="fl">
                <h3>优惠券</h3>
                <p>优惠券仅用于会员卡金额的减免</p>
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
            <span>¥899</span>
            <p></p>
        </div>
        <div class="fr">
            <button onclick="choose_vip.pay()">去支付 <span>（微信支付）</span></button>
            <input type="hidden" value="" id="vip_card_id">
        </div>
    </div>
</div>

<script>
    var choose_vip={
        data:{
            time:'{{$days}}',
            sortList:[],
            discount:localStorage.vip_discount?JSON.parse(localStorage.vip_discount):"",       //优惠券卡/**/
            vip_id:"",             //会员卡id,
            count:1          //会员卡 0为月卡 1为半年卡 2为季卡
        },
        init:function () {
            if(eval(choose_vip.data.time)){
                $(".choose-vip-wrap-new>p").text('您的会员有效期剩余：'+choose_vip.data.time+'天');
            }
            //获取会员卡数据
            common.httpRequest('{{url('api/user/vip_cards')}}','post',null,function (res) {
                /*choose_vip.data.sortList =[
                    {time:30,money:399,yajin:600,id:1},
                    {time:90,money:899,yajin:600,id:2},
                    {time:180,money:1399,yajin:0,id:3}
                ];*/
                choose_vip.data.sortList = res.info.list;

                choose_vip.data.sortList.forEach(function (item,index) {
                    if(item.type==3){
                        choose_vip.data.vip_id = localStorage.vip_id?localStorage.vip_id:item.id;
                    }
                });

                localStorage.vip_id = choose_vip.data.vip_id;
                $("#vip_card_id").val(choose_vip.data.vip_id);

                var cont='';
                for(var i=0;i<choose_vip.data.sortList.length;i++){
                    if(choose_vip.data.sortList[i].id==choose_vip.data.vip_id){
                        switch(choose_vip.data.sortList[i].type){
                            case 1:
                                choose_vip.data.count = 0;
                                $(".info .select .fl span").text("月卡（+30天）");
                                break;
                            case 2:
                                choose_vip.data.count = 2;
                                $(".info .select .fl span").text("季卡（+90天）");
                                break;
                            case 3:
                                choose_vip.data.count = 1;
                                $(".info .select .fl span").text("半年卡（+180天）");
                                break;
                            default:
                                break;
                        }
                        choose_vip.slide(choose_vip.data.count);
                        var money = choose_vip.data.sortList[i].price;
                        var yajin = choose_vip.data.sortList[i].money;

                        $(".info .select .fr").text('¥'+money);
                        $(".info .deposit .fr").text('¥'+yajin);
                        $(".submit .fl p").text('（其中包含押金¥'+yajin+'）');
                        if(!choose_vip.data.discount){
                            /* {user_id:'34',vip_card_id:choose_vip.data.vip_id}*/
                            //显示几张优惠券
                            common.httpRequest('{{url('api/user/coupon_list')}}','post',{user_id:'{{$user_id}}',vip_card_id:choose_vip.data.sortList[i].id},function (res) {

                                if(res.info.can_use_count>0){
                                    $(".info .coupon .fr span").text(res.info.can_use_count+'张可用');
                                }else{
                                    $(".info .coupon .fr span").text('无可用优惠券');
                                }

                                $(".submit .fl span:eq(1)").text('¥'+(money+yajin));
                            });
                        }else{
                            $(".info .coupon .fr span").text('-¥'+choose_vip.data.discount.price);
                            $(".submit .fl span:eq(1)").text('¥'+(choose_vip.data.sortList[i].price+choose_vip.data.sortList[i].money-choose_vip.data.discount.price));
                        }

                    }
                }
            })
        },
        //选择会员卡
        choose:function () {
            //滑动效果
            var cont=1;
            var $swiperCont =  $(".choose-vip-wrap-new .vip-info");
            //滑动
            //向左右滑动
            var x,x1;
            $swiperCont[0].addEventListener('touchstart',function (e) {
                x = e.touches[0].pageX;
            });
            $swiperCont[0].addEventListener('touchend',function (e) {
                x1 = e.changedTouches[0].pageX;
                if(x-x1>100){
                    cont++;
                }
                if(x1-x>100){
                    cont--;
                }
                if(cont>=2){
                    cont = 2
                }else if(cont<=0){
                    cont=0
                }
                choose_vip.slide(cont);
                $(".info .select .fr").text($(this).find(".fr").text());
                switch(cont){
                    case 0:
                        $(".info .select .fl span").text("月卡（+30天）");
                        $(".info .select .fr").text('¥'+choose_vip.data.sortList[0].price);
                        $(".info .deposit .fr").text('¥'+choose_vip.data.sortList[0].money);
                        $(".submit .fl p").text('（其中包含押金¥'+choose_vip.data.sortList[0].money+'）');
                        $(".submit .fl span:eq(1)").text('¥'+(choose_vip.data.sortList[0].price+choose_vip.data.sortList[0].money));
                        choose_vip.data.vip_id = choose_vip.data.sortList[0].id;
                        localStorage.vip_id = choose_vip.data.vip_id;
                        break;
                    case 2:
                        $(".info .select .fl span").text("季卡（+90天）");
                        $(".info .select .fr").text('¥'+choose_vip.data.sortList[1].price);
                        $(".info .deposit .fr").text('¥'+choose_vip.data.sortList[1].money);
                        $(".submit .fl span:eq(1)").text('¥'+(choose_vip.data.sortList[1].price+choose_vip.data.sortList[1].money));
                        $(".submit .fl p").text('（其中包含押金¥'+choose_vip.data.sortList[1].money+'）');
                        choose_vip.data.vip_id = choose_vip.data.sortList[1].id;
                        localStorage.vip_id = choose_vip.data.vip_id;
                        break;
                    case 1:
                        $(".info .select .fl span").text("半年卡（+180天）");
                        $(".info .select .fr").text('¥'+choose_vip.data.sortList[2].price);
                        $(".info .deposit .fr").text('¥'+choose_vip.data.sortList[2].money);
                        $(".submit .fl span:eq(1)").text('¥'+(choose_vip.data.sortList[2].price+choose_vip.data.sortList[2].money));
                        $(".submit .fl p").text('（其中包含押金¥'+choose_vip.data.sortList[2].money+'）');
                        choose_vip.data.vip_id = choose_vip.data.sortList[2].id;
                        localStorage.vip_id = choose_vip.data.vip_id;
                        break;
                }

                $("#vip_card_id").val(choose_vip.data.vip_id);

                common.httpRequest('{{url('api/user/coupon_list')}}','post',{user_id:'{{$user_id}}',vip_card_id:choose_vip.data.vip_id},function (res) {

                    if(res.info.can_use_count>0){
                        $(".info .coupon .fr span").text(res.info.can_use_count+'张可用');
                    }else{
                        $(".info .coupon .fr span").text('无可用优惠券');
                    }
                });
            });
        },
        //选择优惠券
        chooseCars:function () {
            location.href='{{url('wechat/user/choose_coupon')}}';
        },
        //微信支付
        pay:function () {
            var vip_card_id = $("#vip_card_id").val();
            location.href="{{url('wechat/index/pay_vip_card')}}"+'/'+vip_card_id;
        },
        slide:function(cont){
            var $swiperContItem =  $(".choose-vip-wrap-new .vip-info ul");
            $(".choose-vip-wrap-new .vip-info ul li").removeClass('active');
            $(".choose-vip-wrap-new .vip-info ul li").eq(cont).addClass('active');
            $(".choose-vip-wrap-new .dot span").removeClass('active');
            $(".choose-vip-wrap-new .dot span").eq(cont).addClass('active');
            switch (cont){
                case 0:
                    $swiperContItem.animate({'left':'15%'},1000);
                    break;
                case 1:
                    $swiperContItem.animate({'left':'-50%'},1000);
                    break;
                case 2:
                    $swiperContItem.animate({'left':'-116%'},1000);
                    break;
            }

        }
    };
    $(function () {
        choose_vip.init();
        choose_vip.choose();
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