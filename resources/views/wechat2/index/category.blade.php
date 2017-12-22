<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>玩玩具趣编程</title>
    <!--下拉刷新-->
    <link rel="stylesheet" href="{{ asset('wechat2/style/weui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('wechat2/style/jquery-weui.min.css') }}">

    <link href="{{ asset('wechat2/style/reset.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/common.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/style.css') }}" rel="stylesheet" type="text/css">

    <script src="{{ asset('wechat2/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('wechat2/js/common.js') }}"></script>
</head>
<body>
<div class="sort-detail">
    @include('wechat2.common.category')

    <div class="content" id="content">
        <div class="grow-up">
            <div class="top">
                <div class="top-img">
                    <img src=""><!--示意图-->
                </div>
                <div class="describe">
                    <!--示意图描述-->
                </div>
            </div>
            <div class="all">
                <!-- <div class="top-title">
                     <span>—</span>全部商品<span>—</span>
                 </div>-->
                <div class="year-select">
                    <div class="scroll">
                        <!-- <button class="active">全部商品</button>
                         <button>商品1</button>
                         <button>商品2</button>
                         <button>商品3</button>
                         <button>商品4</button>
                         <button>商品5</button>
                         <button>商品6</button>-->
                    </div>
                </div>
            </div>
            <div class="list">
                <ul>
                    <!--      商品列表-->
                    <!-- <li class="clear">
                         <a href="">
                             <div class="fl">
                                 <img src="../image/other/3.png">
                                 <span>暂无库存</span>
                             </div>
                             <div class="fr">
                                 <h3>
                                     WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人

                                 </h3>
                                 <h4>适用年龄1-12岁</h4>
                                 <p>市场参考价¥2500.00</p>
                             </div>
                         </a>
                     </li>-->
                </ul>
            </div>
        </div>
    </div>

    @include('wechat2.common.footer')
</div>

<!-- 下拉刷新 -->
<script src="{{ asset('wechat2/js/jquery-weui.min.js') }}"></script>

<!--懒加载-->
<script src="{{ asset('wechat2/js/jquery.lazyload.js') }}"></script>
<script>
    var url = "{{url('api/category')}}"+"/{{$category_id}}/"+"{{$brand_id}}";

    var sort_detail = {
        data:{
            grown_up_top:{},   //成长陪伴示意图数据
            grown_up_list:{},   //成长陪伴商品列表
            sort_list:[]     //分类的筛选列表 ---商品品种
        },
        init:function () {
            sort_detail.sortTab();
            sort_detail.grown_up();
            sort_detail.getShopList(0);
        },
        //分类顶部大图和描述
        grown_up:function (small,big,selectCont) {
            common.httpRequest(url,'get',null,function (res) {
                sort_detail.data.grown_up_top = res;
                sort_detail.data.grown_up_top = {url:res.info.category.picture,title:res.info.category.title,desc:res.info.category.desc};   //假数据
                $(".grow-up .top .top-img img").attr("src",sort_detail.data.grown_up_top.url);
                $(".grow-up .top .describe").text('「'+sort_detail.data.grown_up_top.desc+'」');

                var img_width =parseInt($(".grow-up .top .top-img img").width()*4/13);
                // $(".grow-up .top .top-img img").css("height",img_width+"px");
                //setTimeout(sort_detail.slide_up,2000);
            });
        },
        //分类选项-商品品种
        sortTab:function () {
            common.httpRequest(url,'get',null,function (res) {
                //假数据
                sort_detail.data.sort_list = res.info.brands;

                var cont='<button class="active" onclick="sort_detail.getShopList(0)">全部品牌</button>';
                for(var i=0;i<sort_detail.data.sort_list.length;i++){
                    cont += '<button onclick="sort_detail.getShopList('+sort_detail.data.sort_list[i].id+')">'+
                        sort_detail.data.sort_list[i].title+'</button>';
                }
                $(".year-select .scroll").html(cont);
                //计算列表宽度
                $(".year-select").width($(window).width()-24);
                sort_detail.choose_sort();   //分类选择
            })
        },
        //分类详情-商品列表
        getShopList:function(id){
            if(id!=0)
            {
                var url = "{{url('api/category')}}"+"/{{$category_id}}/"+id;
            }
            else
            {
                var url = "{{url('api/category')}}"+"/{{$category_id}}/"+"{{$brand_id}}";
            }

            common.httpRequest(url,'get',null,function (res) {
                sort_detail.data.grown_up_list = {
                    list: res.info.goods
                };   //假数据
                console.log(res);
                //商品列表
                var shopList = "";
                for(var i=0;i<sort_detail.data.grown_up_list.list.length;i++){
                    var href = "{{url('wechat2/index/good')}}"+'/'+sort_detail.data.grown_up_list.list[i].id;
                    //判断是否有库存
                    if(sort_detail.data.grown_up_list.list[i].store <= 0){
                        shopList +='<li class="clear"><a href="'+href +'"><div class="fl">' +
                            '<img class="lazy" src="/wechat2/image/common/default_pic.png" data-original="'+ sort_detail.data.grown_up_list.list[i].picture+
                            '"><span class="active">暂无库存</span></div> <div class="fr"><h3>'
                            +sort_detail.data.grown_up_list.list[i].title+'</h3><p>市场价¥'+
                            sort_detail.data.grown_up_list.list[i].price+'</p><h4>适龄'+
                            sort_detail.data.grown_up_list.list[i].old+'</h4><div class="rent">¥<span class="money">'+sort_detail.data.grown_up_list.list[i].day_price+'/</span><span class="unit">元</span></div></div></a></li>';
                    }else{
                        shopList +='<li class="clear"><a href="'+href +'"><div class="fl">' +
                            '<img class="lazy" src="/wechat2/image/common/default_pic.png" data-original="'+ sort_detail.data.grown_up_list.list[i].picture+
                            '"></div> <div class="fr"><h3>'
                            +sort_detail.data.grown_up_list.list[i].title+'</h3><p>市场价¥'+
                            sort_detail.data.grown_up_list.list[i].price+'</p><h4>适龄'+
                            sort_detail.data.grown_up_list.list[i].old+'</h4><div class="rent">¥<span class="money">'+sort_detail.data.grown_up_list.list[i].day_price+'/</span><span class="unit">元</span></div></div></a></li>';
                    }
                }
                $(".grow-up .list ul").html(shopList);
                $(".grow-up .list ul li .fl img").css("height", $(".grow-up .list ul li .fl img").width()+"px");
                sort_detail.record_position();
                //懒加载
                $("img.lazy").lazyload({
                    threshold :0,
                    effect : "fadeIn"
                });
            })
        },
        //分类详情 - 选择品牌
        choose_sort:function () {
            $(".year-select .scroll button").click(function () {
                var moveX = $(this).position().left+$(this).closest('.year-select .scroll').scrollLeft();
                var pageX = document.documentElement.clientWidth;
                var blockWidth = $(this).width();
                var left = moveX-(pageX/2)+(blockWidth/2);
                $(".year-select .scroll").scrollLeft(left);
                $(".year-select .scroll button").removeClass('active');
                $(this).addClass('active');
            })
        },
        //点击记录浏览的当前位置
        record_position:function () {
            if(eval(sessionStorage.getItem('sort_scrollTop'))){
                $("body").scrollTop(sessionStorage.getItem('sort_scrollTop'));
                var sort_index =sessionStorage.getItem('sort_index');
                $(".year-select .scroll button").removeClass("active");
                $(".year-select .scroll button").eq(sort_index).addClass("active");
                sessionStorage.setItem("sort_scrollTop",null);      //回到一次位置后清楚位置记录
                if(sort_index==0){
                    sort_detail.getShopList(0);
                }else{
                    sort_detail.getShopList(sort_detail.data.sort_list[sort_index-1].id);
                }

            }
            $("#content .list ul").click(function () {
                sessionStorage.setItem("sort_scrollTop",$("body").scrollTop());
                var sort_index = $(".year-select .scroll button.active").index();
                sessionStorage.setItem("sort_index",sort_index);      //记录选择的种类
            })
        }
        //分类详情-上滑效果
        /*  slide_up:function () {
              var outheight = $(".grow-up .top").outerHeight();
              $(".grow-up .top").animate({"margin-top":-1*outheight+"px"},2000);
              setTimeout(function () {
                  $(".grow-up .top").remove();
              },2000);
          }*/
    };

    $(function () {
        varuser_id="16";
        // common.getCarAndOrder(user_id); //获取订单数量和购物车数量
        //  $(".sort-detail .content").css('maxHeight',$(window).height()-94);
        sort_detail.init();        //初始化
    })
</script>
</body>
</html>