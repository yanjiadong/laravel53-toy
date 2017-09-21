<!DOCTYPE html>
<html>
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
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/jquery-weui.min.js"></script>
    <script src="/wechat/js/common.js"></script>

</head>
<body>
<div class="sort-detail">
    @include('wechat.common.category')

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
                <div class="top-title">
                    <span>—</span>全部商品<span>—</span>
                </div>
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
                         <div class="fl">
                             <a href="">
                                 <img src="../image/other/3.png">
                             </a>
                             <span>暂无库存</span>
                         </div>
                         <div class="fr">
                             <h3>
                                 <a href="">
                                     WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人
                                 </a>
                             </h3>
                             <h4>适用年龄1-12岁</h4>
                             <p>市场参考价¥2500.00</p>
                         </div>
                     </li>-->
                </ul>
            </div>
        </div>
    </div>

    @include('wechat.common.footer')
</div>

<script>
    var url = "{{url('api/category')}}"+"/{{$category_id}}/"+"{{$brand_id}}";

    var sort_detail = {
        data:{
            grown_up_top:{},   //成长陪伴示意图数据
            grown_up_list:{},   //成长陪伴商品列表
            sort_list:[]     //分类的筛选列表 ---商品品种
        },
        init:function () {
            sort_detail.grown_up();
            sort_detail.sortTab();
            sort_detail.getShopList(0);
        },
        //分类顶部大图和描述
        grown_up:function (small,big,selectCont) {
            common.httpRequest(url,'get',null,function (res) {
                //console.log(res);
                //sort_detail.data.grown_up_top = res;
                sort_detail.data.grown_up_top ={url:res.info.category.picture,title:res.info.category.title};   //假数据
                $(".grow-up .top .top-img img").attr("src",sort_detail.data.grown_up_top.url);
                $(".grow-up .top .describe").text(sort_detail.data.grown_up_top.title);

                var img_width =parseInt($(".grow-up .top .top-img img").width()*9/20);
                $(".grow-up .top .top-img img").css("height",img_width+"px");
                setTimeout(sort_detail.slide_up,2000);
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
                var scroll_wid=0;
                for(var i=0;i< $(".year-select .scroll button").length;i++){
                    scroll_wid+=$($(".year-select .scroll button")[i]).outerWidth()+10;
                }
                $(".year-select .scroll").width(scroll_wid+'px');
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
            //console.log(url);
            common.httpRequest(url,'get',null,function (res) {
                console.log(res);
                sort_detail.data.grown_up_list = {
                    list: res.info.goods
                };   //假数据
                console.log(res.info.goods);
                //商品列表
                var shopList = "";
                for(var i=0;i<sort_detail.data.grown_up_list.list.length;i++){
                    var href = "{{url('wechat/index/good')}}"+'/'+sort_detail.data.grown_up_list.list[i].id;
                    shopList +='<li class="clear"><div class="fl"><a href="'+href +'"><img src="'+ sort_detail.data.grown_up_list.list[i].picture+
                        '"></a> </div> <div class="fr"><h3><a href="'+href +'">'+sort_detail.data.grown_up_list.list[i].title+'</a></h3><h4>'+ sort_detail.data.grown_up_list.list[i].brand.title+'</h4><p>市场参考价¥'+
                        sort_detail.data.grown_up_list.list[i].price+'</p></div></li>';
                }
                $(".grow-up .list ul").html(shopList);
                $(".grow-up .list ul li .fl img").css("height", $(".grow-up .list ul li .fl img").width()+"px");
            })
        },
        //分类详情 - 选择品牌
        choose_sort:function () {
            $(".year-select .scroll button").click(function () {
                $(".year-select .scroll button").removeClass('active');
                $(this).addClass('active');
            })
        },
        //分类详情-上滑效果
        /*slide_up:function () {
            var outheight = $(".grow-up .top").outerHeight();
            $(".grow-up .top").animate({"margin-top":-1*outheight+"px"},2000);
            setTimeout(function () {
                $(".grow-up .top").remove();
            },2000);
        }*/
    };

    $(function () {
        sort_detail.init();        //初始化
    })
</script>
</body>
</html>