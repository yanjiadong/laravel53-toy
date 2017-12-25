<!DOCTYPE html>
<html lang="en" class="bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>优惠券</title>
    <link href="{{ asset('wechat2/style/reset.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/common.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/style.css') }}" rel="stylesheet" type="text/css">

</head>
<body>
<div class="submit-voucher-wrap bg-white">
    <!-- <div class="input">
         <input type="text" placeholder="请输入兑换码">
     </div>
     <div class="btn">
         <button onclick="vip_voucher.exchange()">兑换</button>
     </div>-->
    <div class="list">
        <ul>
            <!-- <li class="clear active">
                 <div class="fl">
                     <i class="icon-wave-left "></i>
                     <span>¥100</span>
                 </div>
                 <div class="fr">
                     <i class="icon-wave-right"></i>
                     <h3>新手专享优惠卷</h3>
                     <p>有效期：<span>2017.2.3-2017.3.3</span></p>
                     <h5>任意金额可用</h5>
                 </div>
             </li>
             <li class="clear">
                 <div class="fl">
                     <i class="icon-wave-left "></i>
                     <span>¥100</span>
                 </div>
                 <div class="fr">
                     <i class="icon-wave-right"></i>
                     <h3>新手专享优惠卷</h3>
                     <p>有效期：<span>2017.2.3-2017.3.3</span></p>
                     <h5>任意金额可用</h5>
                 </div>
             </li>-->
        </ul>
    </div>
    <div class="footer bg-white">
        <button onclick="vip_voucher.noUser()">不使用优惠劵</button>
    </div>
    <div class="no-good">
        <div class="tips">
            <img src="/wechat2/image/common/no-good3.png">
            <h4>您还没有可用的优惠券</h4>
        </div>
    </div>
</div>
<script src="{{ asset('wechat2/js/jquery-1.11.1.min.js') }}"></script>
<script src="{{ asset('wechat2/js/main.js') }}"></script>
<script src="{{ asset('wechat2/js/common.js') }}"></script>
<script>
    var vip_voucher ={
        data:{
            list:[],
            state:false,                //是不是从个人中心进入 true是   false为不是
            discount_car_id:sessionStorage.getItem('discount_car_id')?sessionStorage.getItem('discount_car_id'):"",       //优惠券卡id值/**/
            rentMoney:!common.getParam('rentMoney')?0: common.getParam('rentMoney'),      //租金
            good_id:common.getParam('good_id')
        },
        init:function(){
            common.httpRequest("{{ url('api/user/user_coupon_list') }}",'post',{user_id:'{{ $user_id }}'},function (res) {
                /*vip_voucher.data.list=[
                    {id:0,money:10,cont:'满减优惠券',time:'2017.8.27-2017.12.31',fanwei:'任意金额可用',rent:0},
                    {id:1,money:20,cont:'满减优惠卷',time:'2017.8.27-2017.12.31',fanwei:'满200元可用',rent:200},
                    {id:2,money:30,cont:'满减优惠卷',time:'2017.8.27-2017.12.31',fanwei:'满300元可用',rent:300}
                ];*/
                vip_voucher.data.list = res.info.coupons;
                console.log(vip_voucher.data);
                if(vip_voucher.data.list.length>0){
                    var cont='';
                    var max=0,max_index;
                    for(var i=0;i<vip_voucher.data.list.length;i++){
                        if(vip_voucher.data.list[i].condition == 0)
                        {
                            var fanwei = '任意金额可用';
                        }
                        else
                        {
                            var fanwei = '满'+vip_voucher.data.list[i].condition+'元可用';
                        }

                        if(vip_voucher.data.list[i].condition <= vip_voucher.data.rentMoney && vip_voucher.data.list[i].can_use){
                            /*-----之前选中优惠券再进入默认是选中------*/
                            if(vip_voucher.data.discount_car_id!=""&&vip_voucher.data.list[i].id==vip_voucher.data.discount_car_id){
                                cont+='<li class="clear active"><div class="fl"><i class="icon-wave-left "></i><span>¥'+vip_voucher.data.list[i].price+'</span>'
                                    +'</div><div class="fr"><i class="icon-wave-right"></i><h3>'+vip_voucher.data.list[i].title+'</h3>' +
                                    '<p>有效期：<span>'+vip_voucher.data.list[i].time+'</span></p><h5>'+fanwei+'</h5></div></li>';
                            }else{
                                cont+='<li class="clear"><div class="fl"><i class="icon-wave-left "></i><span>¥'+vip_voucher.data.list[i].price+'</span>'
                                    +'</div><div class="fr"><i class="icon-wave-right"></i><h3>'+vip_voucher.data.list[i].title+'</h3>' +
                                    '<p>有效期：<span>'+vip_voucher.data.list[i].time+'</span></p><h5>'+fanwei+'</h5></div></li>';
                            }
                            //筛选最大金额
                            if(max<vip_voucher.data.list[i].money){
                                max = vip_voucher.data.list[i].money;
                                max_index = i;
                            }
                        }else{
                            cont+='<li class="clear disable"><div class="fl"><i class="icon-wave-left "></i><span>¥'+vip_voucher.data.list[i].price+'</span>'
                                +'</div><div class="fr"><i class="icon-wave-right"></i><h3>'+vip_voucher.data.list[i].title+'</h3>' +
                                '<p>有效期：<span>'+vip_voucher.data.list[i].time+'</span></p><h5>'+fanwei+'</h5></div></li>';
                        }
                    }
                    $(".submit-voucher-wrap  .list ul").html(cont);
                    vip_voucher.choose();
                }else{
                    $(".submit-voucher-wrap  .no-good").show();
                    $(".submit-voucher-wrap  .list").hide();
                    $(".submit-voucher-wrap  .footer").hide();
                }
            })
        },
        //选择优惠劵
        choose:function () {
            $item = $(".submit-voucher-wrap  .list ul li").not(".disable");
            $item.click(function () {
                $item.removeClass('active');
                $(this).addClass('active');
                var index = $(this).index(".submit-voucher-wrap  .list ul li");
                //提交选择
                sessionStorage.discount_money = JSON.stringify(vip_voucher.data.list[index].price);
                sessionStorage.discount_car_id =vip_voucher.data.list[index].id;

                location.href="{{ url('wechat/index/submit_order') }}"+'/'+vip_voucher.data.good_id;
            })
        },
        //不使用优惠劵
        noUser:function () {
            var submitData ="";
            sessionStorage.discount_money="";
            sessionStorage.discount_car_id = "";
            location.href="{{ url('wechat/index/submit_order') }}"+'/'+vip_voucher.data.good_id;
        }
    };
    $(function () {
        vip_voucher.init();
    })
</script>
<script>
    $(function () {
        pushHistory();
        /*----------避免下一页返回这一页调用这个函数-------------*/
        var bool=false;
        setTimeout(function(){
            bool=true;
        },500);
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            if(bool) {
                history.back()
            }
        }, false);
    });
    function pushHistory() {
        var state = {
            title: "title",
            url: ""
        };
        window.history.pushState(state, state.title, state.url);
    }
</script>
</body>
</html>