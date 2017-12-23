<footer>
    <!--当点击某项时是active  如果玩家箱数量没有不要 <span>3</span>-->
    <table>
        <tr>
            <td class="{{isset($menu) && $menu=='index'?'active':''}}">
                <a href="{{route('wechat2.index.index')}}">
                    <div><i class="icon-footer-home"></i></div>
                    <div class="font">首页</div>
                </a>
            </td>
            <td class="{{isset($menu) && $menu=='order_list'?'active':''}}">
                <a href="{{ route('wechat2.index.order_list') }}">
                    <div><i class="icon-footer-order"><span></span></i></div>
                    <div class="font">订单</div>
                </a>
            </td>
            <td class="{{isset($menu) && $menu=='cart'?'active':''}}">
                <a href="{{ route('wechat2.index.cart') }}">
                    <div><i class="icon-footer-shop-car"><span></span></i></div>
                    <div class="font">玩具箱 </div>
                </a>
            </td>
            <td class="{{isset($menu) && $menu=='user_center'?'active':''}}">
                <a href="{{ route('wechat2.user.user_center') }}">
                    <div><i class="icon-footer-user-center"></i></div>
                    <div class="font">我的</div>
                </a>
            </td>
        </tr>
    </table>
</footer>