<footer>
    <!--当点击某项时是active  如果玩家箱数量没有不要 <span>3</span>-->
    <table>
        <tr>
            <td class="{{isset($menu) && $menu=='index'?'active':''}}">
                <a href="{{route('wechat.index.index')}}">
                    <div><i class="icon-footer-home"></i></div>
                    <div class="font">首页</div>
                </a>
            </td>
            <td class="{{isset($menu) && $menu=='order_list'?'active':''}}">
                <a href="{{url('wechat/index/order_list')}}">
                    <div><i class="icon-footer-order"><span></span></i></div>
                    <div class="font">订单</div>
                </a>
            </td>
            <td class="{{isset($menu) && $menu=='cart'?'active':''}}">
                <a href="{{url('wechat/index/cart')}}">
                    <div><i class="icon-footer-shop-car"><span></span></i></div>
                    <div class="font">玩具箱 </div>
                </a>
            </td>
            <td class="{{isset($menu) && $menu=='center'?'active':''}}">
                <a href="{{route('wechat.user.center')}}">
                    <div><i class="icon-footer-user-center"></i></div>
                    <div class="font">我的</div>
                </a>
            </td>
        </tr>
    </table>
</footer>


{{--
<script type="text/javascript">
    //获取购物车数量
    var num,order_num;
    common.httpRequest('{{url('api/user/get_cart_order_num')}}','post',{user_id:'{{$user_id}}'},function (res) {
        //假数据
        console.log(res);
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
    }
    else
    {
        $('.icon-footer-order').html('');
    }
</script>--}}
