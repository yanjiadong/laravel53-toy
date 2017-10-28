<!DOCTYPE html>
<html style="overflow: hidden">
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>玩具小叮当</title>
    <!--下拉刷新-->
    <link rel="stylesheet" href="/wechat/style/weui.min.css">
    <link rel="stylesheet" href="/wechat/style/jquery-weui.min.css">

    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <!--轮播样式-->
    <link rel="stylesheet" href="/wechat/style/swiper.min.css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <!-- 下拉刷新 -->
    <script src="/wechat/js/jquery-weui.min.js"></script>

    <!-- 如果使用了某些拓展插件还需要额外的JS -->
    <!--轮播图-->
    <script type="text/javascript" src="/wechat/js/swiper.min.js"></script>

    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
</head>
<body style="overflow-x: hidden">
<!-- body 顶部加上如下代码 -->
<div class="index-wrap">
    @include('wechat.common.category')

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

                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>

            <div class="top-cont">
                <div class="top-title">
                    <table>
                        <tr>
                            <td><i class="icon-big icon-big-home-label"></i></td>
                            <td><span class="dot"></span></td>
                            <td>可编程机器人</td>
                            <td><span class="dot"></span></td>
                            <td>无限次更换</td>
                            <td><span class="dot"></span></td>
                            <td>医疗消毒</td>
                            <td><span class="dot"></span></td>
                            <td>往返包邮</td>
                        </tr>
                    </table>
                </div>
            </div>


            <div class="new-arrivals">
                <div class="top-left-title">
                    <i class="icon icon-blue-rect"></i>
                    新品抢先
                </div>
                <div class="recommend-cont clear">

                </div>
            </div>
            <div class="join-member clear">
                <a href="">
                    <div class="fl">
                        <i class="icon icon_diamond"></i>
                    </div>
                    <div class="fl">
                        <h3>立即成为会员</h3>
                        <p>陪让孩子一起畅玩全世界最好玩的智能玩具</p>
                    </div>
                    <div class="fr">
                        <i class="icon icon_circle-right"></i>
                    </div>
                </a>
            </div>
            <div class="hot">
                <div class="top-left-title">
                    <span class="icon icon-blue-rect"></span>
                    热门推荐
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
                          </li>
                       -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @include('wechat.common.footer')
</div>
<div class="index-wrap-cover">
    <div class="index-main-cover">
        <ul class="clear swiper-container1">
            <li class="fl swiper-slide">
                <a href="children_interesting_compilation.html">
                    <img src="/wechat/image/common/img_dialog_4.png">
                </a>
            </li>
            <li class="fl swiper-slide">
                <a href="children_interesting_compilation.html">
                    <img src="/wechat/image/common/img_dialog_1.png">
                </a>
            </li>
            <li class="fl swiper-slide">
                <a href="children_interesting_compilation.html">
                    <img src="/wechat/image/common/img_dialog_2.png">
                </a>
            </li>
            <li class="fl swiper-slide">
                <a href="children_interesting_compilation.html">
                    <img src="/wechat/image/common/img_dialog_3.png">
                </a>
            </li>
            <li class="fl swiper-slide">
                <a href="children_interesting_compilation.html">
                    <img src="/wechat/image/common/img_dialog_4.png">
                </a>
            </li>
            <li class="fl swiper-slide">
                <a href="children_interesting_compilation.html">
                    <img src="../image/common/img_dialog_1.png">
                </a>
            </li>
        </ul>
        <img class="close" src="../image/common/icon_dialog_close_bottom.png">
    </div>

</div>

<script>
    var index_obj = {
        data:{
            lunboData:[],     //首页轮播数据
            vipData:{},       //首页成为会员数据
            grown_up_top:{},   //成长陪伴示意图数据
            grown_up_list:{},   //成长陪伴商品列表
            first_open:'{{$is_first}}'  //是否首次打开
        },
        //首页 - 是否首次打开
        isfirst:function () {
            common.httpRequest('/wechat/js/test.json','get',null,function (res) {
                //假数据
                //index_obj.data.first_open = false;
                if(index_obj.data.first_open == '1'){
                    $(".index-wrap-cover").fadeIn(500);
                    //弹框轮播
                    index_obj.cover_banner();
                }
            })
        },
        //首页-轮播数据获取
        lunbo_init:function () {
            common.httpRequest('{{url('api/index')}}','get',null,function (res) {
                var lunbo_content="";
                if(res.info.banners.length>0){
                    index_obj.data.lunboData = res.info.banners;
                    for(var i=0;i<res.info.banners.length;i++){
                        lunbo_content +='<div class="swiper-slide"><a href="'+index_obj.data.lunboData[i].url +'"><img class="banner-img" src="'+ index_obj.data.lunboData[i].picture+'"></a></div>';
                    }
                    $(".lunbo .swiper-wrapper").html(lunbo_content);

                    //轮播图
                    index_obj.banner();
                }
            })
        },
        //首页-新品 热门数据
        hot_new:function () {
            common.httpRequest('{{url('api/index')}}','get',null,function (res) {
                var newData="";
                var hotData="";
                if(res.info.new_goods)
                {
                    //新品
                    var href = "{{url('wechat/index/good')}}"+'/'+res.info.new_goods.id;

                    if(res.info.new_goods.store <=0 ){
                        newData ='<div class="fl"><a href="'+href+'"><img src="'+res.info.new_goods.picture+'"><span class="active">'+
                            '暂无库存</span></a></div><div class="fr"><a href="'+href+'"><h3>'+
                            res.info.new_goods.title+'</h3><p>市场参考价¥'+res.info.new_goods.price+'</p><h4>适用年龄'+res.info.new_goods.old+'</h4></a></div>';
                        $(".recommend-cont").html(newData);
                    }else{
                        newData ='<div class="fl"><a href="'+href+'"><img src="'+res.info.new_goods.picture+'"></a></div><div class="fr"><a href="'+href+'"><h3>'+
                            res.info.new_goods.title+'</h3><p>市场参考价¥'+res.info.new_goods.price+'</p><h4>适用年龄'+res.info.new_goods.old+'</h4></a></div>';
                        $(".recommend-cont").html(newData);
                    }

                    $(".recommend-cont").html(newData);
                }

                console.log(res.info.goods);
                if(res.info.goods.length>0){
                    //console.log(res.info.goods);
                    //热门
                    for(var i=0;i<res.info.goods.length;i++){
                        var href = "{{url('wechat/index/good')}}"+'/'+res.info.goods[i].id;
                        //判断是否有库存
                        if(res.info.goods[i].store <= 0){
                            hotData +='<li class="fl"><a href="'+href+'"><img src="'+ res.info.goods[i].picture+'"><span class="active">'+
                                '暂无库存</span><h3>'+res.info.goods[i].title+'</h3><p>市场参考价¥'+res.info.goods[i].price+'</p><h4>适用年龄'+res.info.goods[i].old+
                                '</h4></li>';
                        }else{
                            hotData +='<li class="fl"><a href="'+href+'"><img src="'+ res.info.goods[i].picture+'">'+'<h3>'
                                +res.info.goods[i].title+'</h3><p>市场参考价¥'+res.info.goods[i].price+'</p><h4>适用年龄'+res.info.goods[i].old+
                                '</h4></li>';
                        }
                    }
                    $(".hot-list ul").html(hotData);

                }

            })
        },
        //首页 - 成为会员
        vip_create:function () {
            common.httpRequest('{{url('api/index/activities')}}','post',null,function (res) {
                console.log(res);

                if(res.info.list.length > 0)
                {
                    index_obj.data.vipData = res.info.list[0];
                    $(".join-member").css({"background-image":"url("+index_obj.data.vipData.picture+")","background-size":index_obj.cont_width});
                    //$(".join-member a").attr("href",'choose_vip.html?time='+index_obj.data.vipData.time);
                    $(".join-member a").attr("href",index_obj.data.vipData.url);
                }
                else
                {
                    index_obj.data.vipData ={url:"/wechat/image/other/vip-bg.jpg",time:5};   //假数据
                    $(".join-member").css({"background-image":index_obj.data.vipData.url,"background-size":index_obj.cont_width});
                    //$(".join-member a").attr("href",'choose_vip.html?time='+index_obj.data.vipData.time);
                    $(".join-member a").attr("href",'{{url('wechat/index/choose_vip')}}');
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
                    autoplay:3000
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
                    $swiperCont.animate({'margin-left':-cont*index_obj.cont_width*0.9+'px'},500);
                }else{
                    if(cont==1){
                        cont=5;
                        $swiperCont.css('marginLeft','-500%');
                    }
                    cont--;
                    $swiperCont.animate({'margin-left':-cont*index_obj.cont_width*0.9+'px'},500);
                }
            }
            //var h = setInterval(slide,3000);
            //向左右滑动
            var x,x1;
            $swiperCont[0].addEventListener('touchstart',function (e) {
                x = e.touches[0].pageX;
                clearInterval(h);
            });
            $swiperCont[0].addEventListener('touchend',function (e) {
                x1 = e.changedTouches[0].pageX;
                if(x-x1>50){
                    slide();
                }
                if(x1-x>50){
                    slide('right');
                }
                //h = setInterval(slide,3000);
            });

            //关闭
            $(".index-wrap-cover .close").click(function () {
                $(".index-wrap-cover").fadeOut(500);
            })
        },
    };

    $(function () {
        //导航切换
        index_obj.isfirst();         //首页 --是否首次打开
        index_obj.lunbo_init();  //首页 - 轮播数据初始化
        index_obj.hot_new();    //首页 - 新品推荐初始化
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

        //顶部导航选择
        $(".index-nav .nav").scrollLeft(localStorage.index_nav_left?localStorage.index_nav_left:0);
        $(".index-nav .nav li").click(function () {
            var moveX = $(this).position().left+$(this).closest('.index-nav .nav').scrollLeft();
            var pageX = document.documentElement.clientWidth;
            var blockWidth = $(this).width();
            var left = moveX-(pageX/2)+(blockWidth/2);
            localStorage.index_nav_left = left;
            $(".index-nav .nav").scrollLeft(left);
            $(".index-nav .nav li").removeClass('active');
            $(this).addClass('active');
        });
    })
</script>
</body>
</html>