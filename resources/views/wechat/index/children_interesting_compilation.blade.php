<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>儿童趣编程</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">
    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
</head>
<body>
<div class="child-interesting-wrap">
    <div class="child-interesting-main">
        <div class="top bg-white">
            <div class="pic">
                <img src="/wechat/image/common/icon_logo.png">
            </div>
            <h1>玩玩具趣编程</h1>
            <p class="info">
                趣编程是专业的编程教育玩具（机器人）租赁平台，让孩子通过玩乐的方式接触编程，未来用编程与世界沟通
            </p>
        </div>
        <div class="cont bg-white">
            <ul>
                <li class="clear">
                    <div class="fl">
                        <h2>玩具经过严格的筛选</h2>
                        <div class="info">
                            在器具的选择上精选了全球最具代表性的编程类教育机器人，通过科技让孩子在玩的同时更好的学习。
                        </div>
                    </div>
                    <div class="fr">
                        <img src="/wechat/image/common/img_bannerDetail_01.png">
                    </div>
                </li>
                <li class="clear">
                    <div class="fl">
                        <h2>五重卫生保障</h2>
                        <div class="info">
                            蒸汽清洁、高温消毒、酒精消毒、臭氧消毒、紫外线消毒
                        </div>
                    </div>
                    <div class="fr">
                        <img src="/wechat/image/common/img_bannerDetail_02.png">
                    </div>
                </li>
                <li class="clear">
                    <div class="fl">
                        <h2>往返包邮，全程无忧</h2>
                        <div class="info">
                            在会员有效期内享受不限次数的更换和每月2次往返包邮费服务，每次只需上传
                            （填写）寄回的物流单号即可再次下单，无需等待。
                        </div>
                    </div>
                    <div class="fr">
                        <img src="/wechat/image/common/img_bannerDetail_03.png">
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="footer bg-white">
        <button>领取新人包月399优惠特权</button>
    </div>
</div>


<script>
    $(".footer button").click(function () {
        var href = '{{url('wechat/index/choose_vip')}}';
        location.href=href;
    })
</script>
<script>
    $(function () {
        //让会员卡回退到个人中心 或者首页
        if(document.referrer.indexOf("index/index")>-1){
            sessionStorage.setItem("children_interest_back_url",document.referrer)
        }
        pushHistory();
        /*----------避免下一页返回这一页调用这个函数-------------*/
        var bool=false;
        setTimeout(function(){
            bool=true;
        },500);
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            if(bool) {
                if(bool) {
                    location.href=sessionStorage.getItem('children_interest_back_url')?sessionStorage.getItem('children_interest_back_url'):document.referrer;  //在这里指定其返回的地址
                }
            }
        }, false);
    });
    function pushHistory() {
        var state = {
            title: "title",
            url: location.href
        };
        window.history.pushState(state, state.title, state.url);
    }
</script>
</body>
</html>