<footer>
    <!--当点击某项时是active  如果玩家箱数量没有不要 <span>3</span>-->
    <table>
        <tr>
            <td class="active">
                <a href="{{route('wechat.index.index')}}">
                    <div><i class="icon-footer-home"></i></div>
                    <div class="font">首页</div>
                </a>
            </td>
            <td>
                <a href="/view/lease_order.html">
                    <div><i class="icon-footer-order"></i></div>
                    <div class="font">订单</div>
                </a>
            </td>
            <td>
                <a href="/view/toys_car.html">
                    <div><i class="icon-footer-shop-car"><span>3</span></i></div>
                    <div class="font">玩具箱 </div>
                </a>
            </td>
            <td>
                <a href="{{route('wechat.user.center')}}">
                    <div><i class="icon-footer-user-center"></i></div>
                    <div class="font">我的</div>
                </a>
            </td>
        </tr>
    </table>
</footer>

<script type="text/javascript">
    //获取购物车数量
    var num;
    common.httpRequest('/wechat/js/test.json','get',null,function (res) {
        //假数据
        num = 3;
        $('.icon-footer-shop-car>span').text(num);

        //确定ul的长度
        var wid=0;
        var $li =$('.index-nav .nav li');
        if($li.length>0){
            for(var i=0;i<$li.length;i++){
                wid +=$($li[i]).outerWidth();
            }
            $('.index-nav .nav').width(wid+'px');
        }
    })
</script>