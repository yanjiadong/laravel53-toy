<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>会员押金</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">
    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
</head>
<body>
<div class="deposit1-wrap">
    <div class="deposit1-main">
        <div class="top bg-white">
            <span style="margin-right: 5px">*</span>押金可随时提现，该卡在申请押金提现后会被注销，无法继续使用
        </div>
        <div class="cont">
            <div class="list ">
                <!-- <div class="item out-time bg-white clear">
                     <div class="fl">
                         <h3>月卡</h3>
                         <p>90天后到期</p>
                     </div>
                     <div class="fr">
                         <h4>押金</h4>
                         <h2>¥600</h2>
                         <button class="active">申请提现</button>
                     </div>
                 </div>-->
            </div>
        </div>
        <div class="look">
            <a href="{{url('wechat/user/deposit_list')}}">查看押金明细>></a>
        </div>
    </div>

    <div class="no-good">
        <div class="tips">
            <i class="icon-no-goods3"></i>
            <h4>您还没有购买过会员卡</h4>
        </div>
    </div>

</div>


<script>
    var deposit1={
        data:{
            list:[]
        },
        init:function () {
            common.httpRequest('{{url('api/user/cash_list')}}','post',{user_id:'{{$user_id}}'},function (res) {
                /*res ={
                    code:200,
                    info:{
                        list:[
                            {name:"月卡",time:90,money:600,state:"申请提现",id:0},
                            {name:"月卡",time:0,money:600,state:"申请提现",id:1},
                            {name:"月卡",time:0,money:600,state:"已申请提现",id:2},
                            {name:"月卡",time:0,money:600,state:"已提现成功",id:3},
                            {name:"半年卡",time:0,money:0.00,state:"申请提现",id:4}
                        ]
                    }
                };*/
                console.log(res);
                if(res.code==200){
                    deposit1.data.list = res.info.list;
                    if(deposit1.data.list.length>0){
                        var cont='';
                        for(var i=0;i<deposit1.data.list.length;i++){
                            //deposit1.data.list[i].money = (deposit1.data.list[i].money).toFixed(2);
                            switch (deposit1.data.list[i].status){
                                case 1:
                                    cont +='<div class="item bg-white clear"><div class="fl"><h3>'+deposit1.data.list[i].vip_card.title+'</h3>' +
                                        '<p>剩余'+deposit1.data.list[i].days+'天可用</p></div><div class="fr"><h4>押金</h4><h2>¥' +
                                        deposit1.data.list[i].money +'</h2><button class="active"  onclick="deposit1.getCash('+deposit1.data.list[i].id+','+deposit1.data.list[i].money+')">申请提现</button></div></div>';
                                    break;
                                case -1:
                                    cont +='<div class="item bg-white clear"><div class="fl"><h3>'+deposit1.data.list[i].vip_card.title+'</h3>' +
                                        '<p>已到期</p></div><div class="fr"><h4>押金</h4><h2>¥' +
                                        deposit1.data.list[i].money +'</h2><button class="active"  onclick="deposit1.getCash('+deposit1.data.list[i].id+','+deposit1.data.list[i].money+')">申请提现</button></div></div>'
                                    break;
                                case -2:
                                    cont +='<div class="item bg-white clear"><div class="fl"><h3>'+deposit1.data.list[i].vip_card.title+'</h3>' +
                                        '<p>已到期</p></div><div class="fr"><h4>押金</h4><h2>¥' +
                                        deposit1.data.list[i].money +'</h2><button>已申请提现</button></div></div>';
                                    break;
                                case -3:
                                    cont +='<div class="item out-time bg-white clear"><div class="fl"><h3>'+deposit1.data.list[i].vip_card.title+'</h3>' +
                                        '<p>已到期</p></div><div class="fr"><h4>押金</h4><h2>¥' +
                                        deposit1.data.list[i].money +'</h2><button>已提现成功</button></div></div>';
                                    break;

                            }
                        }
                        $(".deposit1-wrap .deposit1-main  .cont .list").html(cont);
                    }
                    else
                    {
                        $(".deposit1-main").hide();
                        $(".deposit1-wrap .no-good").height($(window).height()).show();
                    }
                }else{
                    common.alert_tip(res.msg)
                }
            })
        },
        //提现
        getCash:function (id,money) {
            console.log(id);
            console.log(money);
            //判断是否能提现
            common.httpRequest('{{url('api/user/is_can_cash')}}','post',{user_id:'{{$user_id}}','vip_card_pay_id':id},function (res) {
                if(res.code==200)
                {
                    common.confirm_tip("确认提现","确认申请后，这张会员卡会被自动注销，将无法继续使用，是否确认申请？",null,function () {
                        common.httpRequest('{{url('api/user/cash')}}','post',{user_id:'{{$user_id}}','vip_card_pay_id':id},function (res) {
                            if(res.code==200)
                            {
                                common.success_tip(res.msg);
                                location.href = '{{url('wechat/user/deposit_success')}}'+'/'+id;
                                //location.reload();
                            }
                            else
                            {
                                $(".confirm-alert-wrap").remove();
                                common.alert_tip(res.msg);
                            }
                        });
                    },'确认申请');
                }
                else
                {
                    common.alert_tip(res.msg);
                    return;
                }
            });



            //location.href='cash.html?money='+money+'&id='+id;

        }
    };
    $(function () {
        deposit1.init();
    })
</script>
<script>
    $(function () {
        $(".toys-car").height($(window).height());
        pushHistory();
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            location.href='{{url('wechat/user/center')}}';  //在这里指定其返回的地址
        }, false);
    })
    function pushHistory() {
        var state = {
            title: "title",
            url: "{{url('wechat/user/deposit')}}"
        };
        window.history.pushState(state, state.title, state.url);
    }
</script>
</body>
</html>