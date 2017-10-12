<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>商品详情</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <!--轮播样式-->
    <link rel="stylesheet" href="/wechat/style/swiper.min.css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <!--轮播图-->
    <script type="text/javascript" src="/wechat/js/swiper.min.js"></script>

    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>

</head>
<body>
<div class="good-detail-wrap">
    <div class="good-detail-content">
        <div class="top">
            <div class="lunbo">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <!-- <div class="swiper-slide video">
                             <a href="">
                                 <video width="100%" height="280"></video>
                                 <div class="play-box">1:31</div>
                             </a>
                         </div>
                         <div class="swiper-slide">
                             <a href="">
                                 <img class="banner-img" src="../image/other/lunbo1.gif" alt="">
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
                    <div class="play-box"></div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <h3></h3>
            <p></p>
            <h4></h4>
        </div>
        <div class="good-tips">
            <table>
                <tr>
                    <td>
                        <div class="img"><i class="icon icon_proDetail_label1"></i></div>
                        <div class="font">正品保证</div>
                    </td>
                    <td>
                        <div class="img"><i class="icon icon_proDetail_label2"></i></div>
                        <div class="font">往返包邮</div>
                    </td>
                    <td>
                        <div class="img"><i class="icon icon_proDetail_label3"></i></div>
                        <div class="font">微损免赔</div>
                    </td>
                    <td>
                        <div class="img"><i class="icon icon_proDetail_label4"></i></div>
                        <div class="font">医疗消毒</div>
                    </td>
                    <td>
                        <div></div>
                        <span class="caret"></span>
                    </td>
                </tr>
            </table>
            <ul class="tips-detail">
                <li>
                    <h3>品牌正品</h3>
                    <p>品牌正品保障，让您租的更省心，孩子玩的放心！</p>
                </li>
                <li>
                    <h3>往返包邮</h3>
                    <p>每个自然月内提供2次往返免邮费服务</p>
                </li>
                <li>
                    <h3>微损免赔</h3>
                    <p>正常损耗、小零件丢失，我们不会收取额外费用</p>
                </li>
                <li>
                    <h3>医疗消毒</h3>
                    <p>每件回收到玩具都要经过专业的消毒处理，保障孩子的使用卫生</p>
                </li>
            </ul>
        </div>
        <div class="good-detail-param">
            <h3 class="title">商品参数</h3>
            <table>
                <!-- <tr>
                     <td>玩具品牌</td>
                     <td>火火牌</td>
                 </tr>
                 <tr>
                     <td>玩具品牌</td>
                     <td>火火牌</td>
                 </tr>-->
            </table>
        </div>
        <div class="good-detail-pic">
            <h3 class="title">商品详情</h3>
            <div>
                <!--<li>
                    <img src="../image/other/lunbo1.gif">
                </li>-->
            </div>
        </div>
    </div>
    <div class="footer">
        <ul class="clear">
            <li class="fl">
                <div class="car"><i class="icon-footer-shop-car"></i></div>
                <div class="font" onclick="goodDetail_obj.goToysCar()">玩具箱</div>
            </li>
            <li class="fl">
                <button class="join-car" onclick="goodDetail_obj.join()">加入玩具箱</button>
            </li>
        </ul>
    </div>
</div>

<script>
    var goodDetail_obj = {
        data:{
            detail_data:{},           //商品详情数据
            paly_time:0,
            car_num:'{{$cart_num}}'
        },
        //轮播图设置
        banner:function () {
            var swiper = new Swiper('.swiper-container', {
                pagination: '.swiper-pagination',
                paginationClickable: true,
                loop:true,
                //autoplay:3000
            });
        },
        //商品详情数据
        init:function () {
            var url = "{{url('api/good')}}"+'/'+"{{$good_id}}";
            common.httpRequest(url,'get',null,function (res) {
                console.log(res);
                console.log(res.info.good.pictures[0].picture);
                goodDetail_obj .detail_data = res;
                goodDetail_obj .detail_data ={
                    url:"/wechat/image/other/5.png",
                    lunbo:[{url:res.info.good.video,state:0,poster:res.info.good.pictures[0].picture,time:res.info.good.video_second}],
                    lunbo2:res.info.good.pictures,
                    title:res.info.good.title,
                    money:res.info.good.price,
                    year:res.info.good.old,
                    params:[{name:"品牌及所属",cont:res.info.good.brand_country},{name:"产品类型",cont:res.info.good.weight},{name:"材质",cont:res.info.good.material},{name:"操作方式",cont:res.info.good.effect},{name:"消毒方式",cont:res.info.good.way}],
                    detail:["../image/other/lunbo1.gif","../image/other/lunbo1.gif"],
                    car_num:{num:goodDetail_obj.data.car_num},
                    store:res.info.good.store
                };   //假数据

                //轮播图
                if(goodDetail_obj .detail_data.lunbo.length>0){
                    var lunbo_content="";
                    $(".lunbo .swiper-wrapper").html("");

                    for(var i=0;i<goodDetail_obj .detail_data.lunbo.length;i++){
                        if(goodDetail_obj .detail_data.lunbo[i].state==0){
                            lunbo_content ='<div class="swiper-slide video"><video width="100%" poster="'+goodDetail_obj .detail_data.lunbo[i].poster+'"><source src="'+goodDetail_obj .detail_data.lunbo[i].url+
                                '"></video></div></div>';
                            $(".lunbo .swiper-wrapper").append(lunbo_content);
                            var time = parseInt(goodDetail_obj .detail_data.lunbo[i].time/60)+'\''+(parseInt(goodDetail_obj .detail_data.lunbo[i].time%60)>=10?parseInt(goodDetail_obj .detail_data.lunbo[i].time%60):'0'+parseInt(goodDetail_obj .detail_data.lunbo[i].time%60))+'"'
                            //$('.lunbo .swiper-wrapper .swiper-slide:eq('+i+') .play-box').text(time);
                            $('.lunbo .swiper-container .play-box').show().text(time);
                            $(".swiper-slide video").height($(".swiper-slide video").width());
                            lunbo_content="";
                        }
                    }

                    lunbo_content = '';
                    for(var i=1;i<goodDetail_obj .detail_data.lunbo2.length;i++){
                        lunbo_content +='<div class="swiper-slide"><img class="banner-img" src="'+ goodDetail_obj .detail_data.lunbo2[i].picture+'"></div>';
                        $(".lunbo .swiper-wrapper").append(lunbo_content);
                        lunbo_content="";
                    }

                    //轮播图
                    goodDetail_obj.banner();

                    goodDetail_obj.lunbo_video();
                }

                //标题
                $(".good-detail-content>.top>h3").text(goodDetail_obj .detail_data.title);
                $(".good-detail-content>.top>p").text("市场参考价¥"+goodDetail_obj.detail_data .money);
                $(".good-detail-content>.top>h4").text("适用年龄"+goodDetail_obj.detail_data .year);

                //商品参数
                if(goodDetail_obj .detail_data.params.length>0){
                    var shop_params = "";
                    for(var i=0;i<goodDetail_obj.detail_data.params.length;i++){
                        shop_params +='<tr><td>'+goodDetail_obj .detail_data.params[i].name+'</td><td>'+
                            goodDetail_obj .detail_data.params[i].cont +'</td></tr>';
                    }
                    $(".good-detail-param table").html(shop_params);
                }
                //商品详情
                $(".good-detail-pic>div").html(res.info.good.desc);
                /*if(goodDetail_obj.detail_data.detail.length>0){
                    var details ="";
                    for(var i=0;i<goodDetail_obj.detail_data.detail.length;i++){
                        details += ' <li><img src="'+goodDetail_obj.detail_data.detail[i] +'"></li>'
                    }
                    $(".good-detail-pic ul").html(details);
                }*/

                //购物车
                if(goodDetail_obj.detail_data.car_num.num>0){
                    $(".icon-footer-shop-car").html('<span>'+goodDetail_obj.detail_data.car_num.num+'</span>');
                }else{
                    $(".icon-footer-shop-car").html('');
                }
                //是否有库存
                if(goodDetail_obj.detail_data.store>0){
                    $(".footer ul li:last .join-car").addClass('active');
                    $(".footer ul li:last .join-car span").hide();
                }else{
                    $(".footer ul li:last .join-car").removeClass('active');
                    $(".footer ul li:last .join-car span").show();
                }
            });
        },
        //轮播图视频播放
        lunbo_video:function () {
            var h;
            $('.lunbo .swiper-container .play-box').click(function () {
                var minites =  parseInt($(this).text().slice(0,$(this).text().indexOf('\'')));
                var seconds = parseInt($(this).text().slice($(this).text().indexOf('\'')+1));
                var total = minites*60+seconds;
                if($(this).hasClass("active")){
                    $(this).removeClass("active");
                    $(".swiper-slide video")[0].pause();
                    clearInterval(h);
                }else{
                    $(this).addClass("active");
                    $(".swiper-slide video")[0].play();
                    var cont =0;
                    h = setInterval(function () {
                        if( total  >0){
                            total --;
                            cont++;
                            if(cont ==60){
                                minites= minites-1;
                                cont=0;
                            }else{
                                seconds =seconds-1;
                            }
                        }
                        $(".play-box").text(minites+'\''+seconds+'"');
                    },1000);
                }
            });
        },
        //正品保证 往返包邮   微损免赔  往返包邮
        detail_describe_toggle:function () {
            $(".good-tips table tr").click(function () {
                $(".good-tips .tips-detail").slideToggle();
                $(".good-tips table tr td .caret").toggleClass('active');
            })
        },
        //加入购物车
        join:function () {
            var good_id = '{{$good_id}}';
            var user_id = '{{$user_id}}';
            common.httpRequest('{{url('api/cart/add')}}','post',{good_id:good_id,user_id:user_id},function (res) {
                if(res.code == 300)
                {
                    common.alert_tip(res.msg);
                    return false;
                }
                else
                {

                    //$(".icon-footer-shop-car").append('<span>'+res.info.count+'</span>');
                    goodDetail_obj.data.car_num = res.info.count;
                    common.success_tip("添加成功！");
                    goodDetail_obj.init();
                }
            })
        },
        //进入购物车
        goToysCar:function () {
            location.href="{{url('wechat/index/cart')}}";
        }
    };

    $(function () {
        goodDetail_obj.init();
        goodDetail_obj.detail_describe_toggle();

    })
</script>
</body>
</html>