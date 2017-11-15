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
                    <div class="vip-name"></div>
                    <div class="vip-price"><span></span></div>
                    <div class="vip-yajin"></div>
                    <div class="vip-use">可累计使用</div>
                    <div class="vip-time"></div>
                    <div class="vip-free">每月<span>2</span>次往返包邮</div>
                </li>
                <li class="active">
                    <img src="/wechat/image/common/half_year.png">
                    <div class="vip-name"></div>
                    <div class="vip-price"><span></span></div>
                    <div class="vip-yajin"></div>
                    <div class="vip-use">可累计使用</div>
                    <div class="vip-time"></div>
                    <div class="vip-free">每月<span>2</span>次往返包邮</div>
                </li>
                <li>
                    <img src="/wechat/image/common/quarter.png">
                    <div class="vip-name"></div>
                    <div class="vip-price"><span></span></div>
                    <div class="vip-yajin"></div>
                    <div class="vip-use">可累计使用</div>
                    <div class="vip-time"></div>
                    <div class="vip-free">每月<span>2</span>次往返包邮</div>
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
                <td>所有器具免费租</td>
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
            <table>
                <tr>
                    <td rowspan="3" class="name">会员卡押金</td>
                    <td><span><s>¥600</s></span></td>
                </tr>
                <tr>
                    <td>¥600</td>
                </tr>
                <tr>
                    <td><a href="javascript:void(0);" class="link_info"><span class="info"></span></a></td>
                </tr>
            </table>
        </div>
        {{--<div class="deposit clear">
            <div class="fl">
                <h3>押金</h3>
                <p>押金可随时申请提现</p>
            </div>
            <div class="fr">
            </div>
        </div>
        <div class="deposit-discount clear">
            <div class="fl">
                <span>押金减免</span>
            </div>
            <div class="fr">
                <div class="flag1">
                    <span class="tip">您的押金最多可减免¥3000</span>
                    <span>-¥600</span>
                </div>
                <div class="flag2" onclick="choose_vip.goZmxy()">
                    <span>认证芝麻信用分</span>
                    <i class="icon icon_arrowRight_bold"></i>
                </div>
            </div>
        </div>--}}

        <div class="coupon clear" onclick="choose_vip.chooseCars()">
            <div class="fl">
                <h3>会员卡抵用券</h3>
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

<div class="choose-vip-new-cover">
    <div class="choose-vip-new-cover-main">
        <div class="title">进行芝麻信用分认证后，可以减免会员卡押金哟~</div>
        <div class="btn-wrap">
            <button class="get" onclick="choose_vip.goZmxy()">芝麻信用分</button>
            <button class="cancel" onclick="choose_vip.cancelZmxy()">不认证</button>
        </div>
    </div>
</div>

<script>
    var choose_vip={
        data:{
            sortList:[],
            discount:"",       //优惠券卡/**/
            vip_discount_id:"",       //优惠券卡id/**/
            vip_id:"",             //会员卡id,
            count:1,          //会员卡动画控制  0为月卡 1为半年卡 2为季卡
            //first_choose_vip:localStorage.first_choose_vip?localStorage.first_choose_vip:false,    //false代表第一次进入这个页面 true代表不是,用localStorage是为了避免下一个页面返回不请求接口问题
            first_choose_vip:'{{$first_choose_vip}}',    //false代表第一次进入这个页面 true代表不是,用localStorage是为了避免下一个页面返回不请求接口问题
            zmxy_money:0    //芝麻信用抵扣的押金
        },
        init:function () {
            if(sessionStorage.choose_vip_discount){
                choose_vip.data.discount = sessionStorage.choose_vip_discount;
                sessionStorage.choose_vip_discount=""
            }
            if(sessionStorage.choose_vip_car){
                choose_vip.data.vip_discount_id = sessionStorage.choose_vip_car;
                sessionStorage.choose_vip_car ="";
            }

            choose_vip.data.time = '{{$days}}';
            $(".choose-vip-wrap-new>.vip-info>p").text('您的会员有效期剩余：'+choose_vip.data.time+'天');

            //获取会员卡数据
            common.httpRequest("{{url('api/user/vip_cards')}}",'post',{user_id:'{{$user_id}}'},function (res) {
                /*choose_vip.data.sortList =[
                    {created_at: "2017-09-24 22:58:25",days:0,id:1,money:1,price:2,title:"月卡",type:1},
                    {created_at: "2017-09-24 22:58:25",days:0,id:4,money:3,price:0,title:"半年卡",type:3},
                    {created_at: "2017-09-24 22:58:25",days:0,id:3,money:1,price:2,title:"季卡",type:2}
                ];*/
                console.log(res);
                choose_vip.data.sortList = res.info.list;
                choose_vip.data.zmxy_money = res.info.user.zhima_money;

                //根据type进行由小到大排序  数组为 月卡  季卡  半年卡
                choose_vip.data.sortList.sort(function (a,b) {
                    return a.type-b.type;
                });
                //如果是优惠券页进来 为之前的会员，否则默认是半年卡
                choose_vip.data.sortList.forEach(function (item,index) {
                    if(item.type==3){
                        if(sessionStorage.choose_vip_id){
                            choose_vip.data.vip_id =sessionStorage.choose_vip_id;
                            sessionStorage.choose_vip_id="";
                        }else{
                            choose_vip.data.vip_id = item.id
                        }
                    }
                });

                localStorage.vip_id = choose_vip.data.vip_id;
                $("#vip_card_id").val(choose_vip.data.vip_id);

                var cont='';
                for(var i=0;i<choose_vip.data.sortList.length;i++){
                    //会员卡卡片遍历
                    switch(choose_vip.data.sortList[i].type){
                        case 1:
                            $(".sort li:eq(0) .vip-name").text(choose_vip.data.sortList[i].title);  //卡名称
                            $(".sort li:eq(0) .vip-price").html('<span>¥</span>'+choose_vip.data.sortList[i].price); //会员卡费用
                            if(choose_vip.data.sortList[i].money<=0){
                                $(".sort li:eq(0) .vip-yajin").text("免押金");  //押金
                            }
                            $(".sort li:eq(0) .vip-time").text(30+'天');  //使用天数
                            $(".info .select .fl span").text("月卡（+30天）");
                            break;
                        case 2:
                            $(".sort li:eq(2) .vip-name").text(choose_vip.data.sortList[i].title);  //卡名称
                            $(".sort li:eq(2) .vip-price").html('<span>¥</span>'+choose_vip.data.sortList[i].price); //会员卡费用
                            if(choose_vip.data.sortList[i].money<=0){
                                $(".sort li:eq(2) .vip-yajin").text("免押金");  //押金
                            }
                            $(".sort li:eq(2) .vip-time").text(90+'天');  //使用天数
                            $(".info .select .fl span").text("季卡（+90天）");
                            break;
                        case 3:
                            $(".sort li:eq(1) .vip-name").text(choose_vip.data.sortList[i].title);  //卡名称
                            $(".sort li:eq(1) .vip-price").html('<span>¥</span>'+choose_vip.data.sortList[i].price); //会员卡费用
                            if(choose_vip.data.sortList[i].money<=0){
                                $(".sort li:eq(1) .vip-yajin").text("免押金");  //押金
                            }
                            $(".sort li:eq(1) .vip-time").text(180+'天');  //使用天数
                            $(".info .select .fl span").text("半年卡（+180天）");
                            break;
                        default:
                            break;
                    }
                    if(choose_vip.data.sortList[i].id==choose_vip.data.vip_id){
                        switch(choose_vip.data.sortList[i].type){
                            case 1:
                                choose_vip.data.count = 0;
                                break;
                            case 2:
                                choose_vip.data.count = 2;
                                break;
                            case 3:
                                choose_vip.data.count=1;
                                break;
                            default:
                                break;
                        }
                        choose_vip.slide(choose_vip.data.count,true);
                        var money = choose_vip.data.sortList[i].price;
                        var yajin = choose_vip.data.sortList[i].money;
                        //var old_yajin = choose_vip.data.sortList[i].old_money;

                        $(".info .select .fr").text('¥'+money);
                        $(".deposit table tr:nth-child(2) td").text('¥'+yajin);
                        var free_deposit;

                        //判断是否是第一次进入会员卡页面
                        if(choose_vip.data.first_choose_vip != '1'){
                            // $(".choose-vip-new-cover").show();
                            $(".deposit .info").addClass("red").text("认证芝麻信用分减免押金");
                            $(".deposit .link_info").attr('href',"{{url('wechat/index/zmxy/index')}}");
                            $(".deposit .info").after('<i class="icon icon_arrowRight_bold" style="margin-left: 10px"></i>');
                            $(".deposit table tr:first-child  td:nth-child(2)").hide();
                            free_deposit=0;
                        }else{
                            free_deposit = choose_vip.data.sortList[i].jianmian_money;
                            $(".deposit table tr:first-child td:nth-child(2) span s").text('¥'+yajin);
                            $(".deposit table tr:nth-child(2) td:nth-child(1)").text('¥'+(yajin-free_deposit));
                            $(".deposit table tr:nth-child(3) td:nth-child(1) .info").text('信用认证已减免'+free_deposit+"元押金");
                        }

                        if(yajin<=0){
                            $(".submit .fl p").text('免押金');
                        }else{
                            $(".submit .fl p").text('其中包含押金¥'+(yajin-free_deposit));
                        }


                        if(!choose_vip.data.discount){
                            /* {user_id:'34',vip_card_id:choose_vip.data.vip_id}*/
                            //显示几张优惠券
                            common.httpRequest('{{url('api/user/coupon_list')}}','post',{user_id:'{{$user_id}}',vip_card_id:choose_vip.data.sortList[i].id},function (res) {
                                if(res.info.can_use_count>0){
                                    $(".info .coupon .fr span").text(res.info.can_use_count+'张可用');
                                }else{
                                    $(".info .coupon .fr span").text('无可用优惠券');
                                }

                                $(".submit .fl span:eq(1)").text('¥'+(money+yajin-free_deposit));
                            });
                        }else{
                            $(".info .coupon .fr span").text('-¥'+choose_vip.data.discount);
                            $(".submit .fl span:eq(1)").text('¥'+(choose_vip.data.sortList[i].price+choose_vip.data.sortList[i].money-choose_vip.data.discount-free_deposit));
                        }


                    }
                }

            });
        },
        //选择会员卡
        choose:function () {
            //滑动效果
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
                    choose_vip.data.count++;
                }
                if(x1-x>100){
                    choose_vip.data.count--;
                }
                if(choose_vip.data.count>=2){
                    choose_vip.data.count = 2
                }else if(choose_vip.data.count<=0){
                    choose_vip.data.count=0
                }
                // debugger;
                choose_vip.slide(choose_vip.data.count);
                $(".info .select .fr").text($(this).find(".fr").text());
                switch(choose_vip.data.count){
                    case 0:
                        $(".info .select .fl span").text("月卡（+30天）");
                        $(".info .select .fr").text('¥'+choose_vip.data.sortList[0].price);
                        $(".info .deposit .fr").text('¥'+choose_vip.data.sortList[0].money);
                        choose_vip.data.vip_id = choose_vip.data.sortList[0].id;
                        localStorage.vip_id = choose_vip.data.vip_id;
                        var free_deposit=0;
                        if(choose_vip.data.first_choose_vip != '1'){
                            $(".deposit .info").addClass("red").text("认证芝麻信用分减免押金");
                            $(".deposit .link_info").attr('href',"{{url('wechat/index/zmxy/index')}}");
                        }else{
                            free_deposit = choose_vip.data.sortList[0].jianmian_money;
                            $(".deposit table tr:nth-child(3) td:nth-child(1) .info").text('信用认证已减免'+free_deposit+"元押金");
                        }
                        $(".deposit table tr:first-child td:nth-child(2) span s").text('¥'+choose_vip.data.sortList[0].money);
                        $(".deposit table tr:nth-child(2) td:nth-child(1)").text('¥'+(choose_vip.data.sortList[0].money-free_deposit));
                        $(".submit .fl span:eq(1)").text('¥'+(choose_vip.data.sortList[0].money+choose_vip.data.sortList[0].price-free_deposit));
                        $(".submit .fl p").text('其中包含押金¥'+(choose_vip.data.sortList[0].money-free_deposit));
                        break;
                    case 2:
                        $(".info .select .fl span").text("季卡（+90天）");
                        $(".info .select .fr").text('¥'+choose_vip.data.sortList[1].price);
                        $(".info .deposit .fr").text('¥'+choose_vip.data.sortList[1].money);
                        choose_vip.data.vip_id = choose_vip.data.sortList[1].id;
                        localStorage.vip_id = choose_vip.data.vip_id;
                        var free_deposit=0;
                        if(choose_vip.data.first_choose_vip != '1'){
                            $(".deposit .info").addClass("red").text("认证芝麻信用分减免押金");
                            $(".deposit .link_info").attr('href',"{{url('wechat/index/zmxy/index')}}");
                        }else{
                            free_deposit = choose_vip.data.sortList[1].jianmian_money;
                            $(".deposit table tr:nth-child(3) td:nth-child(1) .info").text('信用认证已减免'+free_deposit+"元押金");
                        }
                        $(".deposit table tr:first-child td:nth-child(2) span s").text('¥'+choose_vip.data.sortList[1].money);
                        $(".deposit table tr:nth-child(2) td:nth-child(1)").text('¥'+(choose_vip.data.sortList[1].money-free_deposit));
                        $(".submit .fl span:eq(1)").text('¥'+(choose_vip.data.sortList[1].money+choose_vip.data.sortList[1].price-free_deposit));
                        $(".submit .fl p").text('其中包含押金¥'+(choose_vip.data.sortList[1].money-free_deposit));
                        break;
                    case 1:
                        $(".info .select .fl span").text("半年卡（+180天）");
                        $(".info .select .fr").text('¥'+choose_vip.data.sortList[2].price);
                        $(".info .deposit .fr").text('¥'+choose_vip.data.sortList[2].money);
                        choose_vip.data.vip_id = choose_vip.data.sortList[2].id;
                        localStorage.vip_id = choose_vip.data.vip_id;
                        var free_deposit=0;
                        if(choose_vip.data.first_choose_vip != '1'){
                            $(".deposit .info").addClass("red").text("认证芝麻信用分减免押金");
                            $(".deposit .link_info").attr('href',"{{url('wechat/index/zmxy/index')}}");
                        }else{
                            free_deposit = choose_vip.data.sortList[2].jianmian_money;
                            $(".deposit table tr:nth-child(3) td:nth-child(1) .info").text('信用认证已减免'+free_deposit+"元押金");
                        }
                        $(".deposit table tr:first-child td:nth-child(2) span s").text('¥'+choose_vip.data.sortList[2].money);
                        $(".deposit table tr:nth-child(2) td:nth-child(1)").text('¥'+(choose_vip.data.sortList[2].money-free_deposit));
                        $(".submit .fl span:eq(1)").text('¥'+(choose_vip.data.sortList[2].money+choose_vip.data.sortList[2].price-free_deposit));
                        $(".submit .fl p").text('其中包含押金¥'+(choose_vip.data.sortList[2].money-free_deposit));
                        break;
                }
                common.httpRequest('{{url('api/user/coupon_list')}}','post',{user_id:'{{$user_id}}',vip_card_id:choose_vip.data.vip_id},function (res) {

                    if(res.info.can_use_count>0){
                        $(".info .coupon .fr span").text(res.info.can_use_count+'张可用');
                    }else{
                        $(".info .coupon .fr span").text('无可用优惠券');
                    }
                });

                $("#vip_card_id").val(choose_vip.data.vip_id);
                choose_vip.data.vip_discount_id = '';
            });
            //点击会员卡图片选择会员卡
            var $img =  $(".choose-vip-wrap-new .vip-info .sort ul li");
            $img.click(function (ev) {
                ev.preventDefault();
                switch ($(this).find(".vip-time").text()){
                    case "30天":
                        choose_vip.data.count = 0;
                        $(".info .select .fl span").text("月卡（+30天）");
                        $(".info .select .fr").text('¥'+choose_vip.data.sortList[0].price);
                        $(".info .deposit .fr").text('¥'+choose_vip.data.sortList[0].money);
                        $(".submit .fl p").text('其中包含押金¥'+choose_vip.data.sortList[0].money);
                        $(".submit .fl span:eq(1)").text('¥'+(choose_vip.data.sortList[0].money+choose_vip.data.sortList[0].price));
                        choose_vip.data.vip_id = choose_vip.data.sortList[0].id;
                        localStorage.vip_id = choose_vip.data.vip_id;
                        var free_deposit=0;
                        if(choose_vip.data.first_choose_vip != '1'){
                            $(".deposit .info").addClass("red").text("认证芝麻信用分减免押金");
                            $(".deposit .link_info").attr('href',"{{url('wechat/index/zmxy/index')}}");
                        }else{
                            free_deposit = choose_vip.data.sortList[0].jianmian_money;
                            $(".deposit table tr:nth-child(3) td:nth-child(1) .info").text('信用认证已减免'+free_deposit+"元押金");
                        }
                        $(".deposit table tr:first-child td:nth-child(2) span s").text('¥'+choose_vip.data.sortList[0].money);
                        $(".deposit table tr:nth-child(2) td:nth-child(1)").text('¥'+(choose_vip.data.sortList[0].money-free_deposit));
                        $(".submit .fl span:eq(1)").text('¥'+(choose_vip.data.sortList[0].money+choose_vip.data.sortList[0].price-free_deposit));
                        $(".submit .fl p").text('其中包含押金¥'+(choose_vip.data.sortList[0].money-free_deposit));
                        break;
                    case "90天":
                        choose_vip.data.count = 2;
                        $(".info .select .fl span").text("季卡（+90天）");
                        $(".info .select .fr").text('¥'+choose_vip.data.sortList[1].price);
                        $(".info .deposit .fr").text('¥'+choose_vip.data.sortList[1].money);
                        choose_vip.data.vip_id = choose_vip.data.sortList[1].id;
                        var free_deposit=0;
                        if(choose_vip.data.first_choose_vip != '1'){
                            $(".deposit .info").addClass("red").text("认证芝麻信用分减免押金");
                            $(".deposit .link_info").attr('href',"{{url('wechat/index/zmxy/index')}}");
                        }else{
                            free_deposit = choose_vip.data.sortList[1].jianmian_money;
                            $(".deposit table tr:nth-child(3) td:nth-child(1) .info").text('信用认证已减免'+free_deposit+"元押金");
                        }
                        $(".deposit table tr:first-child td:nth-child(2) span s").text('¥'+choose_vip.data.sortList[1].money);
                        $(".deposit table tr:nth-child(2) td:nth-child(1)").text('¥'+(choose_vip.data.sortList[1].money-free_deposit));
                        $(".submit .fl span:eq(1)").text('¥'+(choose_vip.data.sortList[1].money+choose_vip.data.sortList[1].price-free_deposit));
                        $(".submit .fl p").text('其中包含押金¥'+(choose_vip.data.sortList[1].money-free_deposit));
                        break;
                    case "180天":
                        choose_vip.data.count=1;
                        $(".info .select .fl span").text("半年卡（+180天）");
                        $(".info .select .fr").text('¥'+choose_vip.data.sortList[2].price);
                        $(".info .deposit .fr").text('¥'+choose_vip.data.sortList[2].money);
                        choose_vip.data.vip_id = choose_vip.data.sortList[2].id;
                        var free_deposit=0;
                        if(choose_vip.data.first_choose_vip != '1'){
                            $(".deposit .info").addClass("red").text("认证芝麻信用分减免押金");
                            $(".deposit .link_info").attr('href',"{{url('wechat/index/zmxy/index')}}");
                        }else{
                            free_deposit = choose_vip.data.sortList[2].jianmian_money;
                            $(".deposit table tr:nth-child(3) td:nth-child(1) .info").text('信用认证已减免'+free_deposit+"元押金");
                        }
                        $(".deposit table tr:first-child td:nth-child(2) span s").text('¥'+choose_vip.data.sortList[2].money);
                        $(".deposit table tr:nth-child(2) td:nth-child(1)").text('¥'+(choose_vip.data.sortList[2].money-free_deposit));
                        $(".submit .fl span:eq(1)").text('¥'+(choose_vip.data.sortList[2].money+choose_vip.data.sortList[2].price-free_deposit));
                        $(".submit .fl p").text('其中包含押金¥'+(choose_vip.data.sortList[2].money-free_deposit));
                        break;
                    default:
                        break;

                }
                choose_vip.slide(choose_vip.data.count);
                common.httpRequest('{{url('api/user/coupon_list')}}','post',{user_id:'{{$user_id}}',vip_card_id:choose_vip.data.vip_id},function (res) {
                    if(res.info.can_use_count>0){
                        $(".info .coupon .fr span").text(res.info.can_use_count+'张可用');
                    }else{
                        $(".info .coupon .fr span").text('无可用优惠券');
                    }
                });

                $("#vip_card_id").val(choose_vip.data.vip_id);
                choose_vip.data.vip_discount_id = '';
            });
        },
        //跳转到芝麻信用
        goZmxy:function () {
            choose_vip.data.first_choose_vip = true;
            localStorage.first_choose_vip = true;
            location.href="{{url('wechat/index/zmxy/index')}}";
            /*common.httpRequest('../js/test.json','get',null,function (res) {
                location.href="zhimaxinyong.html";
            })*/
        },
        //不认证
        cancelZmxy:function () {
            choose_vip.data.first_choose_vip = true;
            localStorage.first_choose_vip = true;
            $(".choose-vip-new-cover").fadeOut();
            $(".deposit-discount").show().find(".flag2").show();

            /*common.httpRequest('/wechat/js/test.json','get',null,function (res) {
                $(".choose-vip-new-cover").fadeOut();
                $(".deposit-discount").show().find(".flag2").show();
            })*/
        },
        //选择优惠券
        chooseCars:function () {
            location.href='{{url('wechat/user/choose_coupon')}}'+'?id='+choose_vip.data.vip_id+'&vip_discount_id='+choose_vip.data.vip_discount_id;
        },
        //微信支付
        pay:function () {
            var vip_card_id = $("#vip_card_id").val();
            location.href="{{url('wechat/index/pay_vip_card')}}"+'/'+vip_card_id+'?vip_discount_id='+choose_vip.data.vip_discount_id;
        },
        slide:function(cont,backState){  //backState 判断是不是从优惠券那页返回的或者刚进入这个页面
            var $swiperContItem =  $(".choose-vip-wrap-new .vip-info ul");
            if(backState){
                switch (cont){
                    case 0:
                        $swiperContItem.css({'left':'15%'});
                        break;
                    case 1:
                        $swiperContItem.css({'left':'-50%'});
                        break;
                    case 2:
                        $swiperContItem.css({'left':'-116%'});
                        break;
                }
            }else{
                switch (cont){
                    case 0:
                        $swiperContItem.animate({'left':'15%'},500);
                        break;
                    case 1:
                        $swiperContItem.animate({'left':'-50%'},500);
                        break;
                    case 2:
                        $swiperContItem.animate({'left':'-116%'},500);
                        break;
                }
                $(".choose-vip-wrap-new .vip-info ul li").css({"transition":"transform 0.6s ease"});
            }
            $(".choose-vip-wrap-new .vip-info ul li").removeClass('active');
            $(".choose-vip-wrap-new .vip-info ul li").eq(cont).addClass('active');
            $(".choose-vip-wrap-new .dot span").removeClass('active');
            $(".choose-vip-wrap-new .dot span").eq(cont).addClass('active');
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
<script>
    $(function () {
        //让会员卡回退到个人中心 或者首页
        if(document.referrer.indexOf("index/index")>-1||document.referrer.indexOf("user/center")>-1||document.referrer.indexOf("index/cart")>-1||document.referrer.indexOf("index/children_interesting_compilation")>-1){
            sessionStorage.setItem("choose_vip_back_url",document.referrer)
        }
        pushHistory();
        /*----------避免下一页返回这一页调用这个函数-------------*/
        var bool=false;
        setTimeout(function(){
            bool=true;
        },500);
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            if(bool) {
                if(bool) {
                    location.href=sessionStorage.getItem('choose_vip_back_url')?sessionStorage.getItem('choose_vip_back_url'):document.referrer;  //在这里指定其返回的地址
                }
            }
        }, false);
    });
    function pushHistory() {
        var state = {
            title: "title",
            url: location.href
        };
        window.history.pushState(state, state.title, state.url);
    }
</script>
</body>
</html>