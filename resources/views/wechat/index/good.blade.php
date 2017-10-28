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
    <!--查看图片详情-->
    <link rel="stylesheet prefetch" href="/wechat/style/photoswipe.css">
    <link rel="stylesheet prefetch" href="/wechat/style/default-skin.css">

    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>

    <!--查看图片详情-->
    <script src="/wechat/js/photoswipe.js"></script>
    <script src="/wechat/js/photoswipe-ui-default.min.js"></script>

    <!--轮播图-->
    <script type="text/javascript" src="/wechat/js/swiper.min.js"></script>
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
            <div class="my-gallery" data-pswp-uid="1">
                <!--  <img src="../image/other/lunbo1.gif">-->

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
                <button class="join-car active" onclick="goodDetail_obj.join()">加入购物车 <span>暂无库存</span></button>
            </li>
        </ul>
    </div>
</div>

<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe.
         It's a separate element as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides.
            PhotoSwipe keeps only 3 of them in the DOM to save memory.
            Don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <!-- element will get class pswp__preloader--active when preloader is running -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>


            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>


<script>
    debugger;
    var goodDetail_obj = {
        data:{
            detail_data:{},           //商品详情数据
            paly_time:0,
            car_num:'{{$cart_num}}',
            join_pic:''   //加入购物车的动画图片
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
                //console.log(res.info.good.pictures[0].picture);
                goodDetail_obj .detail_data = res;
                goodDetail_obj .detail_data ={
                    url:"/wechat/image/other/5.png",
                    lunbo:[{url:res.info.good.video,state:0,poster:res.info.good.pictures[0].picture,time:res.info.good.video_second}],
                    lunbo2:res.info.good.pictures,
                    title:res.info.good.title,
                    money:res.info.good.price,
                    year:res.info.good.old,
                    params:[{name:"品牌所属",cont:res.info.good.brand_country},{name:"产品类型",cont:res.info.good.weight},{name:"玩具材质",cont:res.info.good.material},{name:"操作方式",cont:res.info.good.effect},{name:"消毒方式",cont:res.info.good.way}],
                    detail:["../image/other/lunbo1.gif","../image/other/lunbo1.gif"],
                    car_num:{num:goodDetail_obj.data.car_num},
                    store:res.info.good.store
                };   //假数据

                //轮播图
                //console.log(res.info.good.video);
                if(!res.info.good.video)
                {
                    var lunbo_content="";
                    $(".lunbo .swiper-wrapper").html("");

                    for(var i=0;i<goodDetail_obj .detail_data.lunbo.length;i++){
                        if(goodDetail_obj .detail_data.lunbo[i].state==0){
                            lunbo_content ='<div class="swiper-slide video"><div class="video-pic" style="background-image: url('+goodDetail_obj .detail_data.lunbo[i].poster+')">' +
                                '<video width="100%" id="video" height="280" style="display: none" src="'+goodDetail_obj .detail_data.lunbo[i].url+'"></video>' +
                                '</div></div>';
                            $(".lunbo .swiper-wrapper").append(lunbo_content);
                            var time = parseInt(goodDetail_obj .detail_data.lunbo[i].time/60)+'\''+(parseInt(goodDetail_obj .detail_data.lunbo[i].time%60)>=10?parseInt(goodDetail_obj .detail_data.lunbo[i].time%60):'0'+parseInt(goodDetail_obj .detail_data.lunbo[i].time%60))+'"'
                            $('.lunbo .swiper-container .play-box').show().text(time);
                            $(".swiper-slide .video-pic").height($(".swiper-slide video").width());
                            lunbo_content="";
                        }
                    }

                    if(goodDetail_obj .detail_data.lunbo2.length > 0){
                        lunbo_content = '';
                        for(var i=1;i<goodDetail_obj .detail_data.lunbo2.length;i++){
                            if(!goodDetail_obj.join_pic){
                                goodDetail_obj.join_pic = goodDetail_obj.detail_data.lunbo2[i].picture;
                            }

                            lunbo_content +='<div class="swiper-slide"><img class="banner-img" src="'+ goodDetail_obj .detail_data.lunbo2[i].picture+'"></div>';
                            $(".lunbo .swiper-wrapper").append(lunbo_content);
                            lunbo_content="";
                        }

                        //轮播图
                        goodDetail_obj.banner();
                        goodDetail_obj.lunbo_video();
                    }
                }
                else
                {
                    var lunbo_content="";
                    $(".lunbo .swiper-wrapper").html("");

                    if(goodDetail_obj .detail_data.lunbo2.length > 0){
                        lunbo_content = '';
                        for(var i=1;i<goodDetail_obj .detail_data.lunbo2.length;i++){
                            if(!goodDetail_obj.join_pic){
                                goodDetail_obj.join_pic = goodDetail_obj.detail_data.lunbo2[i].picture;
                            }

                            lunbo_content +='<div class="swiper-slide"><img class="banner-img" src="'+ goodDetail_obj .detail_data.lunbo2[i].picture+'"></div>';
                            $(".lunbo .swiper-wrapper").append(lunbo_content);
                            lunbo_content="";
                        }

                        //轮播图
                        goodDetail_obj.banner();
                        goodDetail_obj.lunbo_video();
                    }
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
                $(".good-detail-pic>div").html(res.info.good.desc_new);
                goodDetail_obj.getDetailBigPic();
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
                //var minites =  parseInt($(this).text().slice(0,$(this).text().indexOf('\'')));
                //var seconds = parseInt($(this).text().slice($(this).text().indexOf('\'')+1));
                //var total = minites*60+seconds;
                if($(this).hasClass("active")){
                    $(this).removeClass("active");
                    $(".swiper-slide video")[0].pause();
                    clearInterval(h);
                }else{
                    $(this).addClass("active");
                    $(".swiper-slide video")[0].play();
                    /*var cont =0;
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
                    },1000);*/
                }
            });

            document.getElementById("video").addEventListener("x5videoexitfullscreen", function () {
                document.getElementById("video").style.display = 'none';
                document.getElementById("video").pause();
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


                    var cont ='<div id="picAnimate"><img src="'+goodDetail_obj.join_pic+'"></div>';
                    $(".footer ul li:last.fl").append(cont);
                    setTimeout(function () {
                        $(".footer ul li:last.fl #picAnimate").remove();
                    },1000);

                    //$(".icon-footer-shop-car").html('<span>'+res.info.count+'</span>');
                    //$(".icon-footer-shop-car").append('<span>'+res.info.count+'</span>');
                    goodDetail_obj.data.car_num = res.info.count;
                    //common.success_tip("添加成功！");
                    goodDetail_obj.init();
                }
            })
        },
        //进入购物车
        goToysCar:function () {
            location.href="{{url('wechat/index/cart')}}";
        },
        //商品详情查看
        getDetailBigPic:function() {
            var imgList = $(".my-gallery img");
            for(var i=0;i<imgList.length;i++){
                var realWidth =$(imgList[i]).context.naturalWidth;//真实的宽度
                var realHeight = $(imgList[i]).context.naturalHeight;//真实的高度
                $(imgList[i]).wrap("<figure><a href='"+ $(imgList[i]).prop("src")+"' data-size='"+realWidth+"x"+realHeight+"'></a></figure>");
            }
            var initPhotoSwipeFromDOM = function(gallerySelector) {
                // 解析来自DOM元素幻灯片数据（URL，标题，大小...）// (children of gallerySelector)
                var parseThumbnailElements = function(el) {
                    var thumbElements = el.getElementsByTagName("figure");
                    debugger;
                    var  numNodes = thumbElements.length,
                        items = [],
                        figureEl,
                        linkEl,
                        size,
                        item;
                    for(var i = 0; i < numNodes; i++) {

                        figureEl = thumbElements[i]; // <figure> element

                        // 仅包括元素节点
                        if(figureEl.nodeType !== 1) {
                            continue;
                        }
                        linkEl = figureEl.children[0]; // <a> element

                        size = linkEl.getAttribute('data-size').split('x');

                        // 创建幻灯片对象
                        item = {
                            src: linkEl.getAttribute('href'),
                            w: parseInt(size[0], 10),
                            h: parseInt(size[1], 10)
                        };



                        if(figureEl.children.length > 1) {
                            // <figcaption> content
                            item.title = figureEl.children[1].innerHTML;
                        }

                        if(linkEl.children.length > 0) {
                            // <img> 缩略图节点, 检索缩略图网址
                            item.msrc = linkEl.children[0].getAttribute('src');
                        }

                        item.el = figureEl; // 保存链接元素 for getThumbBoundsFn
                        items.push(item);
                    }
                    return items;
                };

                // 查找最近的父节点
                var closest = function closest(el, fn) {
                    return el && ( fn(el) ? el : closest(el.parentNode, fn) );
                };

                // 当用户点击缩略图触发
                var onThumbnailsClick = function(e) {
                    e = e || window.event;
                    e.preventDefault ? e.preventDefault() : e.returnValue = false;

                    var eTarget = e.target || e.srcElement;

                    // find root element of slide
                    var clickedListItem = closest(eTarget, function(el) {
                        return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
                    });

                    if(!clickedListItem) {
                        return;
                    }

                    // find index of clicked item by looping through all child nodes
                    // alternatively, you may define index via data- attribute
                    var clickedGallery = clickedListItem.parentNode,
                        childNodes = clickedListItem.parentNode.getElementsByTagName("figure"),
                        numChildNodes = childNodes.length,
                        nodeIndex = 0,
                        index;
                    for (var i = 0; i < numChildNodes; i++) {
                        if(childNodes[i].nodeType !== 1) {
                            continue;
                        }

                        if(childNodes[i] === clickedListItem) {
                            index = nodeIndex;
                            break;
                        }
                        nodeIndex++;
                    }



                    if(index >= 0) {
                        // open PhotoSwipe if valid index found
                        openPhotoSwipe( index, clickedGallery );
                    }
                    return false;
                };

                // parse picture index and gallery index from URL (#&pid=1&gid=2)
                var photoswipeParseHash = function() {
                    var hash = window.location.hash.substring(1),
                        params = {};

                    if(hash.length < 5) {
                        return params;
                    }

                    var vars = hash.split('&');
                    for (var i = 0; i < vars.length; i++) {
                        if(!vars[i]) {
                            continue;
                        }
                        var pair = vars[i].split('=');
                        if(pair.length < 2) {
                            continue;
                        }
                        params[pair[0]] = pair[1];
                    }

                    if(params.gid) {
                        params.gid = parseInt(params.gid, 10);
                    }

                    return params;
                };

                var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
                    var pswpElement = document.querySelectorAll('.pswp')[0],
                        gallery,
                        options,
                        items;

                    items = parseThumbnailElements(galleryElement);
                    debugger;

                    // 这里可以定义参数
                    options = {
                        barsSize: {
                            top: 100,
                            bottom: 100
                        },
                        fullscreenEl : false, // 是否支持全屏按钮
                        shareButtons: [
                            {id:'wechat', label:'分享微信', url:'#'},
                            {id:'weibo', label:'新浪微博', url:'#'},
                            {id:'download', label:'保存图片', url:'#', download:true}
                        ], // 分享按钮

                        // define gallery index (for URL)
                        galleryUID: galleryElement.getAttribute('data-pswp-uid'),

                        getThumbBoundsFn: function(index) {
                            // See Options -> getThumbBoundsFn section of documentation for more info
                            var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                                pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                                rect = thumbnail.getBoundingClientRect();

                            return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
                        }

                    };

                    // PhotoSwipe opened from URL
                    if(fromURL) {
                        if(options.galleryPIDs) {
                            // parse real index when custom PIDs are used
                            for(var j = 0; j < items.length; j++) {
                                if(items[j].pid == index) {
                                    options.index = j;
                                    break;
                                }
                            }
                        } else {
                            // in URL indexes start from 1
                            options.index = parseInt(index, 10) - 1;
                        }
                    } else {
                        options.index = parseInt(index, 10);
                    }

                    // exit if index not found
                    if( isNaN(options.index) ) {
                        return;
                    }

                    if(disableAnimation) {
                        options.showAnimationDuration = 0;
                    }

                    // Pass data to PhotoSwipe and initialize it
                    gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
                    gallery.init();
                };

                // loop through all gallery elements and bind events
                var galleryElements = document.querySelectorAll( gallerySelector );

                for(var i = 0, l = galleryElements.length; i < l; i++) {
                    galleryElements[i].setAttribute('data-pswp-uid', i+1);
                    galleryElements[i].onclick = onThumbnailsClick;
                }

                // Parse URL and open gallery if it contains #&pid=3&gid=1
                var hashData = photoswipeParseHash();
                if(hashData.pid && hashData.gid) {
                    openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
                }
            };

            // execute above function
            initPhotoSwipeFromDOM('.my-gallery');
        }
    };

    $(function () {
        goodDetail_obj.init();
        goodDetail_obj.detail_describe_toggle();

    })
</script>
<script>
    $(function () {
        pushHistory();
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            location.href=document.referrer;  //在这里指定其返回的地址
        }, false);
    });
    function pushHistory() {
        var state = {
            title: "title",
            url: "{{url('wechat/index/good')}}"+'/'+'{{$good_id}}'
        };
        window.history.pushState(state, state.title, state.url);
    }
</script>
</body>
</html>