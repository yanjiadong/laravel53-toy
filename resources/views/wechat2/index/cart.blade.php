<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>玩具箱</title>
    <link href="{{ asset('wechat2/style/reset.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/common.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/style.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('wechat2/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('wechat2/js/main.js') }}"></script>
    <script src="{{ asset('wechat2/js/common.js') }}"></script>
</head>
<body>
<div class="toys-car">
    <div class="no-goods">
        <div class="tips">
            <img src="/wechat2/image/common/no-good4.png">
            <h4>您的玩具箱是空的</h4>
            <p>将想要租的玩具添加到玩具箱，就可以下单啦</p>
        </div>
    </div>
    <!--<div class="top-tips">&lt;!&ndash;<i class="icon-attion">!</i>&ndash;&gt;&lt;!&ndash;同一时间内只能持有一件玩具，待归还后才能再次租用&ndash;&gt;</div>-->
    <div class="list">
        <ul>
            <!-- <li class="clear">
                 <div class="fl">
                     <div class="radio active" onclick="">
                         <input type="radio" name="toys">
                     </div>
                 </div>
                 <div class="fl">
                     <a href="">
                         <img src="../image/other/3.png">
                     </a>
                     <span>暂无库存</span>
                 </div>
                 <div class="fl">
                 <a href="">
                     <h3>
                         WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人

                     </h3>
                     <h4>市场参考价¥2500.00</h4>
                     <p>适用年龄1-12岁</p>
                      </a>
                 </div>
                 <div class="fr">
                     <i class="icon icon_del"></i>
                 </div>

             </li>-->
        </ul>
    </div>
    <div class="btn">
        <button onclick="toys_car.goSubmitOrder()"> <!--class="active"-->立即租用</button>
        <input type="hidden" value="" id="good_id">
    </div>

    @include('wechat2.common.footer')
</div>

<script type="text/javascript">
    //获取购物车数量
    var num,order_num;
    var get_url = "{{ url('api/user/get_cart_order_num') }}";
    var user_id = "{{ $user_id }}";
    common.httpRequest(get_url,'post',{user_id:user_id},function (res) {
        //假数据
        num = res.info.cart_num;
        order_num = res.info.order_num;
        localStorage.shop_car_num = num;
        localStorage.order_num = order_num;
        //确定ul的长度
        var wid=0;
        var $li =$('.index-nav .nav li');
        if($li.length>0){
            for(var i=0;i<$li.length;i++){
                wid +=$($li[i]).outerWidth();
            }
            $('.index-nav .nav').width(wid+'px');
        }
    });
    if( localStorage.shop_car_num > 0)
    {
        $('.icon-footer-shop-car>span').text( localStorage.shop_car_num);
    }else {
        $('.icon-footer-shop-car').html('');
    }
    if(localStorage.order_num > 0)
    {
        $('.icon-footer-order>span').text(localStorage.order_num);
    }else
    {
        $('.icon-footer-order').html('');
    }
</script>
<script>
    var toys_car ={
        data:{
            info:{}
        },
        get_data:function () {
            common.httpRequest("{{ url('api/cart/cart_list') }}",'post',{user_id:"{{ $user_id }}"},function (res) {
                if(res){
                    //  toys_car.data.info = res
                    //假数据    / a为库存 a=0没库存  >0有库存
                    toys_car.data.info = {
                        /*list:[
                            {a:1,b:1,c:'../image/other/3.png',d:' WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人',
                                e:'#',f:'1-12岁',h:2500.00,g:131452365895,i:1,j:300.00,id:0}
                        ]*/
                        list:res.info.carts
                    };
                    //列表渲染
                    if(toys_car.data.info.list.length>0){
                        var list ='';
                        for(var i = 0;i<toys_car.data.info.list.length;i++){
                            $(".no-goods").hide();

                            var url = "{{url('wechat2/index/good')}}"+'/'+toys_car.data.info.list[i].id;
                            if(toys_car.data.info.list[i].store <= 0){
                                list +='<li class="clear"><div class="fl"><div class="radio" onclick="toys_car.choose('+i+')"><input type="radio" name="toys"></div></div><div class="fl">' +
                                    '<a href="'+url+'"><img src="'+toys_car.data.info.list[i].picture+'"><span>暂无库存</span></a></div>'+'<div class="fl"><a href="'+url+'"><h3>'+
                                    toys_car.data.info.list[i].title+'</h3> <h4>市场价¥'+Math.round(toys_car.data.info.list[i].price)+'</h4><p>适龄'+
                                    toys_car.data.info.list[i].old+'</p>' + '<div class="rent"><span class="money">'+toys_car.data.info.list[i].day_price+'</span><span class="unit">/元</span></div></a></div><div class="fr"><i class="icon icon_del" onclick="toys_car.delGood('+i+')"></i></div></li>';
                            }else{
                                list +='<li class="clear"><div class="fl"><div class="radio" onclick="toys_car.choose('+i+')"><input type="radio" name="toys"></div></div><div class="fl">' +
                                    '<a href="'+url+'"><img src="'+toys_car.data.info.list[i].picture+'"></a></div>'+'<div class="fl"><a href="'+url+'"><h3>'+
                                    toys_car.data.info.list[i].title+'</h3><h4>市场价¥'+Math.round(toys_car.data.info.list[i].price)+'</h4>' +
                                    '<p>适龄'+toys_car.data.info.list[i].old+'</p>' + '<div class="rent"><span class="money">'+toys_car.data.info.list[i].day_price+'</span><span class="unit">/元</span></div></a></div><div class="fr"><i class="icon icon_del" onclick="toys_car.delGood('+i+')"></i></div></li>';
                            }
                        }
                        $(".toys-car ul").html(list);
                        $(".toys-car .btn button").removeClass('active');
                        $(".toys-car .list").height($(window).outerHeight()-$("footer").outerHeight()-$(".btn").outerHeight());
                    }else{
                        $(".no-goods").height($(window).height()-50).show();
                        $(".list,.btn").hide();
                    }
                }
            })
        },
        choose:function (index) {
            $(".toys-car .list .fl .radio").removeClass('active');
            $(".toys-car .list .fl .radio").eq(index).addClass('active');
            //非会员
            //是会员 且无租用的订单  商品无库存
            if(toys_car.data.info.list[index].store<=0){
                $(".toys-car .btn button").removeClass('active');
            }else{
                $("#good_id").val(toys_car.data.info.list[index].id);
                $(".toys-car .btn button").addClass('active');
            }
        },
        delGood:function (index) {
            common.confirm_tip("亲爱的用户","确定将选中的商品从玩具箱删除吗？",null,function () {
                //删除商品
                //data = {id:toys_car.data.info.list[index].id};
                data = {good_id:toys_car.data.info.list[index].id,user_id:'{{$user_id}}'};

                common.httpRequest("{{url('api/cart/delete')}}",'post',data,function (res) {
                    $(".confirm-alert-wrap").remove();
                    var user_id='{{$user_id}}'; //假数据
                    var get_url = "{{ url('api/user/get_cart_order_num') }}";

                    common.getCarAndOrder(get_url,user_id); //获取订单数量和购物车数量
                    toys_car.get_data();
                })
            });
        },
        goSubmitOrder:function () {
            if($(".toys-car .btn button").hasClass('active')){
                var good_id = $("#good_id").val();
                location.href="{{url('wechat/index/submit_order')}}"+'/'+good_id;
                /*if(toys_car.data.info.state==1){
                    location.href="/view/choose_vip.html";
                }else{
                    location.href="/view/submit_order2.html";
                }*/
            }
        }
    };
    $(function () {
        toys_car.get_data();
    })
</script>
<script>
    $(function () {
        if(document.referrer.indexOf("index/submit_order")==-1){
            sessionStorage.setItem("toys_car_url",document.referrer)
        }
        pushHistory();
        /*----------避免下一页返回这一页调用这个函数-------------*/
        var bool=false;
        setTimeout(function(){
            bool=true;
        },1500);
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            if(bool) {
                location.href=sessionStorage.getItem('toys_car_url')?sessionStorage.getItem('toys_car_url'):document.referrer;  //在这里指定其返回的地址
            }
        }, false);
    });
    function pushHistory() {
        var state = {
            title: "title",
            url: "#"
        };
        window.history.pushState(state, state.title, state.url);
    }
</script>
</body>
</html>