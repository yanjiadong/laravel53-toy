<!DOCTYPE html >
<html lang="en" style=" background-color: #fbd350;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>我的邀请</title>
    <link href="{{ asset('wechat2/style/reset.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/common.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/style2.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
<div class="my-invite-wrap">
    <div class="my-invite-main">
        <div class="white-back">
            <div class="photo"><img src="" ></div>
            <div class="total-list">
                <ul class="clear">
                    <li class="fl">
                        <p>金币数量</p>
                        <h6></h6>
                    </li>
                    <li class="fl">
                        <p>邀请好友数量</p>
                        <h6></h6>
                    </li>
                    <li class="fl">
                        <p>好友下单人数</p>
                        <h6></h6>
                    </li>
                </ul>
            </div>
            <div class="tips">
                金币用于兑换租金减免券，通过您分享链接邀请的用户首次下单成功后，您都会获得1个金币。
            </div>
            <div class="invite-btn">
                <button onclick="invite_obj.share_friend()">邀请好友赚金币</button>
            </div>
            <div class="rent-voucher">
                <div class="title">
                    兑换租金减免券
                </div>
                <ul>
                    <!--   <li class="clear">
                           <div class="fl">
                               <h3>¥60</h3>
                               <p>任意租金可用，兑换后有效期30天</p>
                           </div>
                           <div class="fr">
                               <button>1金币兑换</button>
                           </div>
                       </li>-->
                </ul>
            </div>
        </div>
        <div class="invite-list">
            <div class="invite-title">
                <i class="lip"></i>
                <span class="title">我的邀请</span>
                <i class="lip"></i>
            </div>
            <div class="cont">
                <ul>
                    <li class="clear">
                        <div class="fl">
                            <img src="/wechat2/image/other/01.png">
                            <span>小马子</span>
                            <button>未下单</button>
                        </div>
                        <div class="fr">
                            2018.1.12
                        </div>
                    </li>
                    <li class="clear">
                        <div class="fl">
                            <img src="/wechat2/image/other/01.png">
                            <span>小马子</span>
                            <button class="active">已下单</button>
                        </div>
                        <div class="fr">
                            2018.1.12
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="share-wrap-cover-wrap">
    <i class="icon-big icon-big-share"></i>
    <div class="share-wrap-cover-main">
        <p class="tips">
            请点击右上角，选择“发送给朋友”或“分享到朋友圈”
        </p>
        <div class="share-img">
            <i class="icon-big icon-big-share-friend"></i>
            <i class="icon-big icon-big-share-moment"></i>
        </div>
    </div>
</div>
<div class="exchange-success-wrap">
    <div class="exchange-success-main">
        <div class="pic">
            <img src="/wechat2/image/common/exchange_success.png">
            <button onclick="invite_obj.alertCover2Hide()"></button>
        </div>

    </div>
</div>
<script src="{{ asset('wechat2/js/jquery-1.11.1.min.js') }}"></script>
<script src="{{ asset('wechat2/js/common.js') }}"></script>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>
    var invite_obj ={
        data:{
            invite_list:[]
        },
        init:function () {
            common.httpRequest("{{ url('api/user/my_recommend') }}",'post',{user_id:"{{ $user_id }}"},function (res) {
                //假数据
                invite_obj.data.invite_list = {
                    photo:res.info.info.wechat_avatar,
                    amount:{gold:res.info.info.award_num,invite:res.info.user_recommends_count,invite_ordered:res.info.user_recommends_order_count},        //金币数量 邀请好友数量 好友下单人数
                    voucher_list:res.info.coupons,                        //兑换租金减免券
                    my_invited_list:res.info.recommends
                };

                //头像赋值
                $(".white-back>.photo img").attr('src',invite_obj.data.invite_list.photo);
                //金币 赋值
                $(".white-back .total-list li:eq(0) h6").text(invite_obj.data.invite_list.amount.gold);
                $(".white-back .total-list li:eq(1) h6").text(invite_obj.data.invite_list.amount.invite);
                $(".white-back .total-list li:eq(2) h6").text(invite_obj.data.invite_list.amount.invite_ordered);

                //兑换租金减免券

                var voucher_list_cont = "";
                for(var i=0;i<invite_obj.data.invite_list.voucher_list.length;i++){
                    console.log(invite_obj.data.invite_list.voucher_list[i]);
                    voucher_list_cont+=' <li class="clear"><div class="fl"><h3>'+invite_obj.data.invite_list.voucher_list[i].price+'元租金减免券</h3>' +
                        '<p>任意租金可用，兑换后有效期'+invite_obj.data.invite_list.voucher_list[i].days+'天</p>' +
                        '</div><div class="fr"><button onclick="invite_obj.invite_friend('+invite_obj.data.invite_list.voucher_list[i].id+','+invite_obj.data.invite_list.voucher_list[i].need_award_num+','+invite_obj.data.invite_list.voucher_list[i].price+')">'+invite_obj.data.invite_list.voucher_list[i].need_award_num+'金币兑换</button></div></li>'
                }
                $(".my-invite-wrap .my-invite-main .white-back .rent-voucher ul").html(voucher_list_cont);

                //我的邀请
                var invited_list_cont = "";
                if(invite_obj.data.invite_list.my_invited_list.length>0){
                    $('.invite-list').show();
                    for(var i=0;i<invite_obj.data.invite_list.my_invited_list.length;i++){
                        var button_cont;
                        if(!invite_obj.data.invite_list.my_invited_list[i].is_order){
                            button_cont ='<button>未下单</button>';
                        }else{
                            button_cont ='<button class="active">已下单</button>';
                        }
                        invited_list_cont+='<li class="clear"><div class="fl"><img src="'+invite_obj.data.invite_list.my_invited_list[i].user.wechat_avatar+'"' +
                            '><span>'+invite_obj.data.invite_list.my_invited_list[i].user.name+'</span>'+button_cont+'</div> ' +
                            '<div class="fr">'+invite_obj.data.invite_list.my_invited_list[i].created_time+'</div></li>'
                    }
                    $(".my-invite-wrap .my-invite-main .invite-list  ul").html(invited_list_cont);
                }
            })
        },
        share_friend:function (obj) {
            var $cove_wrap = $(".share-wrap-cover-wrap");
            $cove_wrap.fadeIn(500);
            $cove_wrap.click(function (event) {
                if(event.target.className.toLowerCase() =="share-wrap-cover-wrap"){
                    $cove_wrap.hide();
                }
            })
        },
        invite_friend:function (id,money,price){
            if(invite_obj.data.invite_list.amount.gold < money){
                common.alert_tip1('金币数量不足');
                return false;
            }
            common.confirm_tip('确认兑换','确认消耗'+money+'金币兑换一张'+price+'元租金减免券？',null,function () {
                common.httpRequest("{{ url('api/user/user_coupon_exchange') }}",'post',{user_id:'{{ $user_id }}',coupon_id:id},function (res) {
                    $(".confirm-alert-wrap").remove();
                    $(".exchange-success-wrap").fadeIn(500);

                    invite_obj.init();
                })
            },'确认兑换')
        },
        alertCover2Hide:function () {
            $(".exchange-success-wrap").fadeOut(500);
        }


    };
    $(function () {
        invite_obj.init();

        //通过config接口注入权限验证配置
        wx.config({
            debug: false,
            appId: '{{$signPackage["appId"]}}',
            timestamp: '{{$signPackage["timestamp"]}}',
            nonceStr: '{{$signPackage["nonceStr"]}}',
            signature: '{{$signPackage["signature"]}}',
            jsApiList: [
                'onMenuShareAppMessage',
                'onMenuShareTimeline',
                'scanQRCode'
            ]
        });

        wx.ready(function(){
            wx.onMenuShareTimeline({
                title: '小Q编程', // 分享标题
                link:"{{ route('wechat2.user.share_open',['user_id'=>$user_id]) }}",
                //link: '{{url('wechat2/user/share_open')}}'+'/'+'{{$user_id}}', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: 'http://toy.yanjiadong.net/wechat2/image/common/order-list-logo.png', // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });

            wx.onMenuShareAppMessage({
                title: '小Q编程', // 分享标题
                desc: '机器人教育一站式服务平台，培养未来的创造者！', // 分享描述
                link:"{{ route('wechat2.user.share_open',['user_id'=>$user_id]) }}",
                //link: '{{url('wechat2/user/share_open')}}'+'/'+'{{$user_id}}', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: 'http://toy.yanjiadong.net/wechat2/image/common/order-list-logo.png', // 分享图标
                type: 'link', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    // 用户确认分享后执行的回调函数
                },

                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
        });
    })
</script>
</body>
</html>