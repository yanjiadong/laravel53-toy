<!DOCTYPE html>
<html style="overflow: hidden">
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>小Q编程</title>
    <!--下拉刷新-->
    <link rel="stylesheet" href="{{ asset('wechat2/style/weui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('wechat2/style/jquery-weui.min.css') }}">

    <link href="{{ asset('wechat2/style/reset.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/common.css') }}" rel="stylesheet" type="text/css">
    <!--轮播样式-->
    <link rel="stylesheet" href="{{ asset('wechat2/style/swiper.min.css') }}">
    <link href="{{ asset('wechat2/style/style.css') }}" rel="stylesheet" type="text/css">

    <script src="{{ asset('wechat2/js/jquery-1.11.1.min.js') }}"></script>
    <!-- 下拉刷新 -->
    <script src="{{ asset('wechat2/js/jquery-weui.min.js') }}"></script>

    <!-- 如果使用了某些拓展插件还需要额外的JS -->
    <!--轮播图-->
    <script type="text/javascript" src="{{ asset('wechat2/js/swiper.min.js') }}"></script>

    <script src="{{ asset('wechat2/js/main.js') }}"></script>
    <script src="{{ asset('wechat2/js/common.js') }}"></script>
</head>
<body style="overflow-x: hidden">
<!-- body 顶部加上如下代码 -->
<div class="index-wrap">
    @include('wechat2.common.category')

    <div class="content" id="content">
        <div class="weui-pull-to-refresh__layer">
            <div class='weui-pull-to-refresh__arrow'></div>
            <div class='weui-pull-to-refresh__preloader'></div>
            <div class="down">下拉刷新</div>
            <div class="up">释放刷新</div>
            <div class="refresh">正在刷新</div>
        </div>
        <div class="recommend">
            <div class="lunbo">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <!-- <div class="swiper-slide">
                             <a href="">
                                 <img class="banner-img" src="../image/other/lunbo1.gif" alt="">
                             </a>
                         </div>
                         <div class="swiper-slide">
                             <a href="">
                                 <img class="banner-img" src="../image/other/lunbo2.jpg" alt="">
                             </a>
                         </div>
                         <div class="swiper-slide">
                             <a href="">
                                 <img class="banner-img" src="../image/other/lunbo3.jpg" alt="">
                             </a>
                         </div>
                         <div class="swiper-slide">
                             <a href="">
                                 <img class="banner-img" src="../image/other/lunbo4.jpg" alt="">
                             </a>
                         </div>
                         <div class="swiper-slide">
                             <a href="">
                                 <img class="banner-img" src="../image/other/lunbo5.jpg" alt="">
                             </a>
                         </div>-->
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>

            <div class="top-cont">
                <div class="top-title">
                    <table>
                        <tr>
                            <td><i class="icon-big-home-label"></i></td>
                            <td><span class="dot"></span></td>
                            <td>可编程机器人</td>
                            <td><span class="dot"></span></td>
                            <td>品牌正品</td>
                            <td><span class="dot"></span></td>
                            <td>灵活租用</td>
                            <td><span class="dot"></span></td>
                            <td>医疗消毒</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="new-arrivals">
                <div class="top-left-title">
                    <i class="lip"></i>
                    <span class="dot1"></span>
                    <span class="title">新品推荐</span>
                    <span class="dot2"></span>
                    <i class="lip"></i>
                </div>
                <div class="recommend-cont">
                    <div class="scroll">
                        <ul class="clear">
                            <!-- <li class="fl">
                                 <span class="no-good-state">暂无库存</span>
                                 <div>
                                     <a href=""><img src="../image/other/lunbo5.jpg" alt=""></a>
                                 </div>
                                 <a href=""><h3>WewWee Miposaur恐龙机器osaur恐龙机器osaur恐龙机器osaur恐龙机器osaur恐龙机器人</h3></a>
                                 <p>市场参考价¥2500.00</p>
                                 <h4>适合年龄1-12岁</h4>
                                 <div class="rent"><span class="text">¥</span><span class="money">2.6/天 | 抢先体验</span><i class="icon icon_arrowRight_bold"></i></div>
                             </li>-->
                        </ul>
                    </div>
                </div>
            </div>
            <div class="join-member clear">
                <a href="">
                    <img src="" alt="">
                    <!-- <div class="fl">
                         <i class="icon icon_diamond"></i>
                     </div>
                     <div class="fl">
                         <h3>立即成为会员</h3>
                         <p>陪让孩子一起畅玩全世界最好玩的智能玩具</p>
                     </div>
                     <div class="fr">
                         <i class="icon icon_circle-right"></i>
                     </div>-->
                </a>
            </div>
            <div class="hot">
                <div class="top-left-title">
                    <i class="lip"></i>
                    <span class="dot1"></span>
                    <span class="title">热门推荐</span>
                    <span class="dot2"></span>
                    <i class="lip"></i>
                </div>
                <div class="hot-list clear">
                    <ul>
                        <!--  <li class="fl">
                              <a href="">
                                  <img src="../image/other/3.png">
                                  <span>暂无库存</span>
                              </a>
                              <h3>
                                  WewWee Miposaur恐龙机器机器机器机器机器人
                              </h3>
                              <p>市场参考价¥2500.00</p>
                              <h4>适用年龄1-12岁</h4>
                              <div class="rent"><span class="text">¥</span><span class="money">2.6/天 | 抢先体验</span><i class="icon icon_arrowRight_bold"></i></div>
                          </li>
                       -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @include('wechat2.common.footer')
</div>
<div class="index-wrap-cover">
    <div class="index-main-cover">
        <ul class="clear swiper-container1">
            <li class="fl swiper-slide">
                <a href="children_interesting_compilation.html">
                    <img src="{{ asset('wechat2/image/common/img_dialog_4.png') }}">
                </a>
            </li>
            <li class="fl swiper-slide">
                <a href="children_interesting_compilation.html">
                    <img src="{{ asset('wechat2/image/common/img_dialog_1.png') }}">
                </a>
            </li>
            <li class="fl swiper-slide">
                <a href="children_interesting_compilation.html">
                    <img src="{{ asset('wechat2/image/common/img_dialog_2.png') }}">
                </a>
            </li>
            <li class="fl swiper-slide">
                <a href="children_interesting_compilation.html">
                    <img src="{{ asset('wechat2/image/common/img_dialog_3.png') }}">
                </a>
            </li>
            <li class="fl swiper-slide">
                <a href="children_interesting_compilation.html">
                    <img src="{{ asset('wechat2/image/common/img_dialog_4.png') }}">
                </a>
            </li>
            <li class="fl swiper-slide">
                <a href="children_interesting_compilation.html">
                    <img src="{{ asset('wechat2/image/common/img_dialog_1.png') }}">
                </a>
            </li>
        </ul>
        <img class="close" src="{{ asset('wechat2/image/common/icon_dialog_close_bottom.png') }}">
    </div>

</div>
{{--<div class="index-wrap-cover1">
    <div class="index-main-cover1">
        <div class="close-btn"></div>
        <div class="pic">
            <img src="{{ asset('wechat2/image/common/index_cover_1.png') }}">
        </div>
    </div>
</div>--}}
<div class="index-wrap-cover2">
    <div class="index-main-cover2">
        <div class="close-btn" onclick="index_obj.alertCover2Hide()"></div>
        <div class="pic">
            <img src="http://ougu95ew5.bkt.clouddn.com/index_cover_main.png">
            <button onclick="index_obj.alertCover2Hide()"></button>
        </div>

    </div>
</div>

<!--懒加载-->
<script src="{{ asset('wechat2/js/jquery.lazyload.js') }}"></script>

<script>
    var index_obj = {
        data:{
            lunboData:[],     //首页轮播数据
            vipData:{},       //首页成为会员数据
            first_open:'{{$is_first}}'  //是否首次打开
        },
        //首页 - 是否首次打开
        isfirst:function () {
            if(index_obj.data.first_open == '1'){
                setTimeout(function () {
                    $(".index-wrap-cover2").fadeIn(500);
                },2000);

                //$(".index-wrap-cover").fadeIn(500);
                //弹框轮播
                //index_obj.cover_banner();
            }
        },
        //首页-轮播数据获取
        lunbo_init:function () {
            common.httpRequest("{{url('api/index/banners')}}",'post',null,function (res) {
                var lunbo_content="";
                if(res.info.banners.length>0){
                    index_obj.data.lunboData = res.info.banners;

                    if(index_obj.data.lunboData.length>1){
                        for(var i=0;i<index_obj.data.lunboData.length;i++){
                            lunbo_content +='<div class="swiper-slide"><a href="'+index_obj.data.lunboData[i].url +'">' +
                                '<img class="banner-img" src="'+ index_obj.data.lunboData[i].picture+'"></a></div>';
                        }
                        $(".lunbo .swiper-wrapper").html(lunbo_content);
                        index_obj.banner();
                    }else{
                        $(".lunbo").html('<a href="'+index_obj.data.lunboData[0].url +'"><img class="banner-img" src="'+ index_obj.data.lunboData[0].picture+'"></a>');
                    }

                    /*for(var i=0;i<res.info.banners.length;i++){
                        lunbo_content +='<div class="swiper-slide"><a href="'+index_obj.data.lunboData[i].url +'"><img class="banner-img" src="'+ index_obj.data.lunboData[i].picture+'"></a></div>';
                    }
                    $(".lunbo .swiper-wrapper").html(lunbo_content);*/
                }
                index_obj.hot_new();    //首页 - 新品推荐初始化
            })
        },
        //首页-新品 热门数据
        hot_new:function () {
            common.httpRequest("{{ url('api/index2') }}",'get',null,function (res) {
                var newData="";
                var hotData="";
                if(res.info.new_goods.length>0){
                    //新品
                    //判断是否有库存
                    for(var i=0;i<res.info.new_goods.length;i++){
                        var href = "{{url('wechat2/index/good')}}"+'/'+res.info.new_goods[i].id;

                        if(res.info.new_goods[i].store <= 0){
                            newData+='<li class="fl"><span class="no-good-state">暂无库存</span><div>' +
                                '<a href="'+href+'"><img src="'+res.info.new_goods[i].new_picture+'"></a></div>' +
                                '<a href="'+href+'"><h3>'+res.info.new_goods[i].title+'</h3></a>' +
                                '<div class="rent"><span class="money">'+res.info.new_goods[i].day_price+'元</span><span class="text">/天</span></div>' +
                                '<div class="flag"><div class="item">新品尝鲜</div><div class="item">限时优惠</div></div></li>';
                        }else{
                            newData+='<li class="fl"><div>' +
                                '<a href="'+href+'"><img src="'+res.info.new_goods[i].new_picture+'"></a></div>' +
                                '<a href="'+href+'"><h3>'+res.info.new_goods[i].title+'</h3></a>' +
                                '<div class="rent"><span class="money">'+res.info.new_goods[i].day_price+'元</span><span class="text">/天</span></div>' +
                                '<div class="flag"><div class="item">新品尝鲜</div><div class="item">限时优惠</div></div></li>';
                        }
                    }
                    $(".recommend-cont ul").html(newData).css('width', ($(".recommend-cont ul li").width()+16)*res.info.new_goods.length);
                    $(".recommend-cont")[0].addEventListener('touchmove',function (ev){
                        ev.stopPropagation();
                    });

                    for(var i=0;i<res.info.goods.length;i++){
                        //热门
                        //判断是否有库存
                        var href = "{{url('wechat2/index/good')}}"+'/'+res.info.goods[i].id

                        if(res.info.goods[i].store <= 0){
                            hotData +='<li class="fl"><a href="'+href+'"><img class="lazy" src="{{ asset('wechat2/image/common/default_pic.png') }}" data-original="'+res.info.goods[i].picture+'"><span class="active">'+
                                '暂无库存</span><h3>'+res.info.goods[i].title+'</h3><p>市场价¥'+Math.round(res.info.goods[i].price)+'</p><h4>适龄'+res.info.goods[i].old+
                                '</h4><div class="rent"><span class="money">'+res.info.goods[i].day_price+'元</span><span class="unit">/元</span></div></li>';
                        }else{
                            hotData +='<li class="fl"><a href="'+href+'"><img class="lazy" src="{{ asset('wechat2/image/common/default_pic.png') }}" data-original="'+res.info.goods[i].picture+'">'+'<h3>'
                                +res.info.goods[i].title+'</h3><p>市场价¥'+Math.round(res.info.goods[i].price)+'</p><h4>适龄'+res.info.goods[i].old+
                                '</h4><div class="rent"><span class="money">'+res.info.goods[i].day_price+'元</span><span class="unit">/天</span></div></li>';
                        }
                    }
                    $(".hot-list ul").html(hotData);
                    $(".hot-list .fl img").height($(".hot-list .fl img").width());

                    index_obj.record_position();
                    //懒加载
                    $("img.lazy").lazyload({
                        effect : "fadeIn", //渐现，show(直接显示),fadeIn(淡入),slideDown(下拉)
                        threshold : 20, //预加载，在图片距离屏幕180px时提前载入
                        event: 'scroll', // 事件触发时才加载，click(点击),mouseover(鼠标划过),sporty(运动的),默认为scroll（滑动）
                        container: '#content', // 指定对某容器中的图片实现效果
                        failure_limit:2 //加载2张可见区域外的图片,lazyload默认在找到第一张不在可见区域里的图片时则不再继续加载,但当HTML容器混乱的时候可能出现可见区域内图片并没加载出来的情况
                    });
                    /*  $("img.lazy").lazyload({
                          threshold :20
                      });*/
                }
            })
        },
        //首页 - 成为会员
        vip_create:function () {
            common.httpRequest("{{url('api/index/activities')}}",'post',null,function (res) {
                index_obj.data.vipData = res;

                if(res.info.list.length > 0)
                {
                    index_obj.data.vipData = res.info.list[0];

                    $(".join-member a img").attr("src",index_obj.data.vipData.picture);
                    $(".join-member a").attr("href",index_obj.data.vipData.url);
                }
            });
        },
        cont_width:$(".content").width(),
        //轮播图设置
        banner:function () {
            if($(".lunbo .swiper-wrapper .swiper-slide").length>1){
                var swiper = new Swiper('.swiper-container', {
                    pagination: '.swiper-pagination',
                    paginationClickable: true,
                    loop:true,
                    speed:800,
                    autoplay:5000
                });
            }
        },
        //弹框轮播
        cover_banner:function(){
            var cont=1;
            var $swiperCont =  $(".index-wrap-cover .swiper-container1");
            //滑动
            function slide(direction){
                if(!direction){
                    if(cont==5){
                        cont=1;
                        $swiperCont.css('marginLeft','-100%');
                    }
                    cont++;
                    $swiperCont.animate({'margin-left':-cont*index_obj.cont_width*0.9+'px'},500)
                }else{
                    if(cont==1){
                        cont=5;
                        $swiperCont.css('marginLeft','-500%');
                    }
                    cont--;
                    $swiperCont.animate({'margin-left':-cont*index_obj.cont_width*0.9+'px'},500)
                }
            }
            //向左右滑动
            var x,x1;
            $swiperCont[0].addEventListener('touchstart',function (e) {
                x = e.touches[0].pageX;
            });
            $swiperCont[0].addEventListener('touchend',function (e) {
                e.preventDefault();
                x1 = e.changedTouches[0].pageX;
                if(x-x1>100){
                    slide();
                }
                if(x1-x>100){
                    slide('right');
                }
            });

            //关闭
            $(".index-wrap-cover .close").click(function (e) {
                e.preventDefault();
                $(".index-wrap-cover").fadeOut(500);
                setTimeout(function () {
                    $(".index-wrap-cover1").fadeIn(500);
                },3000)
            });

            //最后一张图跳转
            $(".index-wrap-cover1 .pic").click(function () {
                $(".index-wrap-cover1").fadeOut(500);
            });
            // 最后一张图关闭
            $(".index-wrap-cover1 .index-main-cover1 .close-btn").click(function () {
                $(".index-wrap-cover1").fadeOut(500);
            })
        },

        //点击记录浏览的当前位置
        record_position:function () {
            if(sessionStorage.getItem('index_scrollTop')){
                $("#content").scrollTop(sessionStorage.getItem('index_scrollTop'));
                sessionStorage.setItem("index_scrollTop",0);      //回到一次位置后清楚位置记录
            }
            $(".hot-list ul").click(function () {
                sessionStorage.setItem("index_scrollTop",$("#content").scrollTop());
            })
        },

        alertCover2Hide:function () {
            $(".index-wrap-cover2").fadeOut(500);
        }
    };

    $(function () {
        var user_id='{{ $user_id }}';  //假数据
        var get_url = "{{url('api/user/get_cart_order_num')}}";

        common.getCarAndOrder(get_url,user_id); //获取订单数量和购物车数量
        //导航切换
        index_obj.lunbo_init();  //首页 - 轮播数据初始化
        index_obj.isfirst();         //首页 --是否首次打开
        index_obj.vip_create();    //首页 - 成为会员_

        //下拉刷新
        $(".content").css({height:$(window).outerHeight()+'px'});
        $(".content").pullToRefresh();
        $(".content").on("pull-to-refresh", function() {
            var refreshClose = $(this);
            /*-------下拉刷新的内容-------------------*/
            index_obj.hot_new();    //首页 - 新品推荐初始化
            /*-------下拉刷新的内容结束-------------------*/
            setTimeout(function () {
                refreshClose.pullToRefreshDone();
            },500);
        });
        $(".content").pullToRefreshDone();


    })
</script>
</body>
</html>