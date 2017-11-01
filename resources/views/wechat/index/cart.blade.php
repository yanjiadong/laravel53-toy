<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>玩具箱</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
</head>
<body>
<div class="toys-car">
    <div class="no-goods">
        <div class="tips">
            <i class="icon-no-goods4"></i>
            <h4>您的玩具箱是空的</h4>
            <p>将想要租的玩具添加到玩具箱，就可以下单啦</p>
        </div>
    </div>
    <div class="top-tips"><!--<i class="icon-attion">!</i>--><!--同一时间内只能持有一件玩具，待归还后才能再次租用--></div>
    <div class="list">
        <ul>
            <!-- <li class="clear">
                 <div class="fl">
                     <input type="radio" name="toys">
                 </div>
                 <div class="fl">
                     <a href="">
                         <img src="../image/other/3.png">
                     </a>
                     <span>暂无库存</span>
                 </div>
                 <div class="fl">
                     <h3>
                         <a href="">WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人
                         </a>
                     </h3>
                     <h4>市场参考价¥2500.00</h4>
                     <p>适用年龄1-12岁</p>
                 </div>
                 <div class="fr">
                     <i class="icon icon_del"></i>
                 </div>
             </li>-->
        </ul>
    </div>
    <div class="btn">
        <button onclick="toys_car.goSubmitOrder()"> <!--class="active"-->寄这个玩具给我</button>
        <input type="hidden" value="" id="good_id">
    </div>

    @include('wechat.common.footer')
</div>

<script>
    var toys_car ={
        data:{
            info:{}
        },
        get_data:function () {
            var user_id = '{{$user_id}}';
            common.httpRequest('{{url('api/cart/index')}}','post',{user_id:user_id},function (res) {
                if(res){
                    console.log(res);
                    //  toys_car.data.info = res
                    //假数据  state   1 为非会员 2为会员   a为库存 a=0没库存  >0有库存    rent true为该账户有租用商品
                    toys_car.data.info = {
                        state:res.info.type,
                        list:
                            /*[{a:1,b:1,c:'/wechat/image/other/3.png',d:' WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人',
                                e:'#',f:'1-12岁',h:2500.00,g:131452365895,i:1,j:300.00,id:0},
                            {a:0,b:2,c:'/wechat/image/other/3.png',d:' WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人',
                                e:'#',f:'1-12岁',h:2500.00,g:131452365895,i:1,j:300.00,id:1},
                            {a:1,b:3,c:'/wechat/image/other/3.png',d:' WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人',
                                e:'#',f:'1-12岁',h:2500.00,g:131452365895,i:1,j:300.00,id:2}]*/

                            res.info.carts,
                        rent:res.info.rent
                    };
                    console.log(toys_car.data.info.list);
                    //列表渲染
                    if(toys_car.data.info.list.length>0){
                        var list ='';
                        for(var i = 0;i<toys_car.data.info.list.length;i++){
                            $(".no-goods").hide();
                            var url = "{{url('wechat/index/good')}}"+'/'+toys_car.data.info.list[i].id;
                            if(toys_car.data.info.list[i].store <= 0){
                                list +='<li class="clear"><div class="fl"><div class="radio" onclick="toys_car.choose('+i+')"><input type="radio" name="toys"></div></div><div class="fl">' +
                                    '<a href="'+url+'"><img src="'+toys_car.data.info.list[i].picture+'"></a><span>暂无库存</span></div>'+'<div class="fl"><a href="' +url+
                                    '"><h3>'+toys_car.data.info.list[i].title+'</h3> <h4>市场参考价¥'+toys_car.data.info.list[i].price+'</h4><p>适用年龄'+toys_car.data.info.list[i].old+'</p>' +
                                    '</div></a><div class="fr"><i class="icon icon_del" onclick="toys_car.delGood('+i+')"></i></div></li>';

                            }else{
                                list +='<li class="clear"><div class="fl"><div class="radio" onclick="toys_car.choose('+i+')"><input type="radio" name="toys"></div></div><div class="fl">' +
                                    '<a href="'+url+'"><img src="'+toys_car.data.info.list[i].picture+'"></a></div>'+'<div class="fl"><a href="' +url+
                                    '"><h3>'+toys_car.data.info.list[i].title+'</h3> <h4>市场参考价¥'+toys_car.data.info.list[i].price+'</h4><p>适用年龄'+toys_car.data.info.list[i].old+'</p>' +
                                    '</div></a><div class="fr"><i class="icon icon_del" onclick="toys_car.delGood('+i+')"></i></div></li>';
                            }
                        }
                        $(".toys-car ul").html(list);

                        switch(toys_car.data.info.state){
                            case 1:   //为非会员 提示
                                $(".top-tips").addClass('red').html('<i class="icon-attion">!</i>办理任意一种会员后即可下单，享受免费租、随意换。').show();
                                $(".toys-car .list").css({'margin-top':$(".top-tips").outerHeight()+'px'});
                                $(".toys-car .btn button").addClass('active');
                                break;
                            case 2: //会员 提示
                                $(".top-tips").hide();
                                $(".toys-car .btn button").removeClass('active');
                                break;
                            case 3:
                                $(".top-tips").addClass('red').html('<i class="icon-attion">!</i>当前账户已有正在租用的物品，归还后才能再下单').show();
                                $(".toys-car .list").css({'margin-top':$(".top-tips").outerHeight()+'px'});
                                $(".toys-car .btn button").removeClass('active');
                                break;
                        }

                        $(".toys-car .list").height($(window).height()-$("footer").height()-$(".btn").height()-$(".top-tips").height());
                    }else{
                        $(".no-goods").height($(window).height()-50).show();
                        $(".list,.btn,.top-tips").hide();
                    }
                }

            })
        },
        choose:function (index) {
            $(".toys-car .list .fl .radio").removeClass('active');
            $(".toys-car .list .fl .radio").eq(index).addClass('active');
            if(toys_car.data.info.state==1){
                $(".top-tips").html('<i class="icon-attion">!</i>办理任意一种会员后即可下单，享受免费租、随意换。').show();
                //$(".toys-car .list").css({'margin-top':$(".top-tips").outerHeight()+'px'});
                $(".toys-car .btn button").addClass('active');
            }else if(toys_car.data.info.state==3){
                $(".top-tips").html('<i class="icon-attion">!</i>当前账户已有正在租用的物品，归还后才能再下单').show();
                $(".toys-car .list").css({'margin-top':$(".top-tips").outerHeight()+'px'});
                $(".toys-car .btn button").removeClass('active');
            }else{
                //是会员 且无租用的订单  商品无库存
                if(toys_car.data.info.list[index].store<=0){
                    $(".toys-car .btn button").removeClass('active');
                    $(".top-tips").hide();
                }else{
                    $(".toys-car .btn button").addClass('active');
                    $(".top-tips").hide();
                }
            }

            $("#good_id").val(toys_car.data.info.list[index].id);
        },
        delGood:function (index) {
            console.log($(".toys-car ul li:eq("+index+") input")[0]);
            /* if($(".toys-car ul li:eq(index) input")){

             }*/
            common.confirm_tip("亲爱的用户","确定将选中的商品从玩具箱删除吗？",null,function () {
                //删除商品
                data = {good_id:toys_car.data.info.list[index].id,user_id:'{{$user_id}}'};
                common.httpRequest('{{url('api/cart/delete')}}','post',data,function (res) {
                    $(".confirm-alert-wrap").remove();
                    toys_car.get_data();
                    location.reload();
                })
            });

            /*if($(".toys-car ul li:eq("+index+") input").prop("checked")){
                common.confirm_tip("亲爱的用户","确定将选中的商品从玩具箱删除吗？",null,function () {
                    //删除商品
                    data = {good_id:toys_car.data.info.list[index].id,user_id:'{{$user_id}}'};
                    common.httpRequest('{{url('api/cart/delete')}}','post',data,function (res) {
                        $(".confirm-alert-wrap").remove();
                        toys_car.get_data();
                    })
                });
            }else{
                common.alert_tip("请选择您要删除的商品？");
                return false;
            }*/
        },
        goSubmitOrder:function () {
            if($(".toys-car .btn button").hasClass('active')){
                var good_id = $("#good_id").val();
                if(toys_car.data.info.state==1){
                    location.href="{{url('wechat/index/choose_vip')}}";
                }else{
                    location.href="{{url('wechat/index/submit_order')}}"+'/'+good_id;
                }
            }
        }
    };
    $(function () {
        $(".toys-car").height($(window).height()-50);
        toys_car.get_data();
    })
</script>
{{--<script>
    $(function () {
        pushHistory();
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            location.href=document.referrer;  //在这里指定其返回的地址
        }, false);
    })
    function pushHistory() {
        var state = {
            title: "title",
            url: "{{url('wechat/index/cart')}}"
        };
        window.history.pushState(state, state.title, state.url);
    }
</script>--}}
</body>
</html>