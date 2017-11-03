<!DOCTYPE html>
<html lang="en" class="bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>会员抵用券</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">
    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
</head>
<body>
<div class="vip-voucher-wrap bg-white">
    {{--<div class="input">
        <input type="text" placeholder="请输入兑换码">
    </div>
    <div class="btn">
        <button onclick="vip_voucher.exchange()" disabled>兑换</button>
    </div>--}}
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
            <i class="icon-no-goods2"></i>
            <h4>您还没有可用的会员抵用券</h4>
        </div>
    </div>
</div>



<script>
    var vip_voucher ={
        data:{
            list:[],
            vip_id:common.getParam('id'),
            state:false                 //是不是从个人中心进入 true是   false为不是
        },
        init:function(){
            var data_vip_id = vip_voucher.data.vip_id;
            console.log(data_vip_id);

            var code = $('.vip-voucher-wrap .input input').val("");
            common.httpRequest('{{url('api/user/coupon_list')}}','post',{user_id:'{{$user_id}}',vip_card_id:data_vip_id},function (res) {
                /*vip_voucher.data.list=[
                    {id:0,money:100,cont:'新人专享优惠卷',time:'2017.8.27-2017.8.31',fanwei:'任意金额可用'},
                    {id:1,money:200,cont:'满减优惠卷',time:'2017.8.27-2017.8.31',fanwei:'满一千元可用'}
                ];*/
                console.log(res.info.coupons);
                vip_voucher.data.list=res.info.coupons;
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

                        if(vip_voucher.data.list[i].can_use)
                        {
                            cont+='<li class="clear"><div class="fl"><i class="icon-wave-left "></i><span>¥'+vip_voucher.data.list[i].price+'</span>'
                                +'</div><div class="fr"><i class="icon-wave-right"></i><h3>'+vip_voucher.data.list[i].title+'</h3>' +
                                '<p>有效期：<span>'+vip_voucher.data.list[i].new_start_time+'-'+vip_voucher.data.list[i].new_end_time+'</span></p><h5>'+fanwei+'</h5></div></li>';
                        }
                        else
                        {
                            cont+='<li class="clear disable"><div class="fl"><i class="icon-wave-left "></i><span>¥'+vip_voucher.data.list[i].price+'</span>'
                                +'</div><div class="fr"><i class="icon-wave-right"></i><h3>'+vip_voucher.data.list[i].title+'</h3>' +
                                '<p>有效期：<span>'+vip_voucher.data.list[i].new_start_time+'-'+vip_voucher.data.list[i].new_end_time+'</span></p><h5>'+fanwei+'</h5></div></li>';
                        }
                    }
                    $(".vip-voucher-wrap .list ul").html(cont);

                    vip_voucher.isCenter();
                    if(vip_voucher.data.state){
                        //$(".vip-voucher-wrap .list ul li").removeClass('disable');
                        $(".vip-voucher-wrap .footer").hide();
                    }else{
                        //$(".vip-voucher-wrap .list ul li").eq(max_index).addClass('active');
                        vip_voucher.choose();
                    }
                }
                else
                {
                    $(".vip-voucher-wrap .no-good").show();
                    $(".vip-voucher-wrap .list").hide();
                    $(".vip-voucher-wrap .footer").hide();
                }
            })
        },
        //是否为我的 页面进入
        isCenter:function () {
            if(document.referrer.toString().indexOf('center')>-1){
                vip_voucher.data.state = true;
            }
        },
        //选择优惠劵
        choose:function () {
            $item = $(".vip-voucher-wrap .list ul li").not(".disable");
            $item.click(function () {
                $item.removeClass('active');
                $(this).addClass('active');

                var index = $(this).index(".vip-voucher-wrap .list ul li");
                //提交选择
                //localStorage.vip_discount = JSON.stringify(vip_voucher.data.list[index]);

                /*common.httpRequest('{{url('api/user/choose_coupon')}}','post',{user_id:'{{$user_id}}','coupon_id':vip_voucher.data.list[index].id},function (res) {

                });*/

                location.href="{{url('wechat/index/choose_vip')}}"+'?vip_id='+vip_voucher.data.vip_id+'&vip_discount='+JSON.stringify(vip_voucher.data.list[index].price)+'&vip_discount_id='+vip_voucher.data.list[index].id;
            })
        },
        //不使用优惠劵
        noUser:function () {
            var submitData ="";
            localStorage.vip_discount="";
            common.httpRequest('{{url('api/user/del_choose_coupon')}}','post',{user_id:'{{$user_id}}'},function (res) {

            });
            location.href="{{url('wechat/index/choose_vip')}}";
        },
        //兑换
        exchange:function () {
            var code = $('.vip-voucher-wrap .input input').val();
            if(!code ){
                common.alert_tip('兑换码不可为空！');
                return false;
            }
            common.httpRequest('../js/test.json','get',null,function (res) {
                res ={
                    success:false,
                    error:'兑换码输入错误！'
                };
                if(res.success){
                    vip_voucher.init();
                    common.success_tip('兑换成功');
                }else{
                    common.alert_tip(res.error);
                }
            })
        }
    };
    $(function () {
        vip_voucher.init();
    })
</script>
</body>
</html>