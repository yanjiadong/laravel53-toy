<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>玩具箱</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
</head>
<body>
<div class="toys-car">
    <div class="no-goods">
        <div class="tips">
            <i class="icon-big icon-big-blankPage"></i>
            <h4>没有归还的玩具</h4>
        </div>
    </div>
    <div class="top-tips"><!--<i class="icon-attion">!</i>--><!--同一时间内只能持有一件玩具，待归还后才能再次租用--></div>
    <div class="list">
        <ul>
            <!-- <li class="clear">
                 <div class="fl">
                     <input type="radio" name="toys">
                 </div>
                 <div class="fl">
                     <a href="">
                         <img src="../image/other/3.png">
                     </a>
                     <span>暂无库存</span>
                 </div>
                 <div class="fl">
                     <h3>
                         <a href="">WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人
                         </a>
                     </h3>
                     <h4>市场参考价¥2500.00</h4>
                     <p>适用年龄1-12岁</p>
                 </div>
                 <div class="fr">
                     <i class="icon icon_del"></i>
                 </div>
             </li>-->
        </ul>
    </div>
    <div class="btn">
        <button onclick="toys_car.goSubmitOrder()"> <!--class="active"-->寄这个玩具给我</button>
    </div>

    @include('wechat.common.footer')
</div>

<script>
    var toys_car ={
        data:{
            info:{}
        },
        get_data:function () {
            common.httpRequest('/wechat/js/test.json','get',null,function (res) {
                if(res){
                    //  toys_car.data.info = res
                    //假数据  state   1 为非会员 2为会员   a为库存 a=0没库存  >0有库存
                    toys_car.data.info = {
                        state:2,
                        list:[
                            {a:1,b:1,c:'/wechat/image/other/3.png',d:' WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人',
                                e:'#',f:'1-12岁',h:2500.00,g:131452365895,i:1,j:300.00,id:0},
                            {a:0,b:2,c:'/wechat/image/other/3.png',d:' WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人',
                                e:'#',f:'1-12岁',h:2500.00,g:131452365895,i:1,j:300.00,id:1},
                            {a:1,b:3,c:'/wechat/image/other/3.png',d:' WewWee Miposaur恐龙机器机龙机器机龙机器机龙机器机龙机器机器机器机器机器机器机器机器人',
                                e:'#',f:'1-12岁',h:2500.00,g:131452365895,i:1,j:300.00,id:2}
                        ]
                    };
                    //列表渲染
                    if(toys_car.data.info.list.length>0){
                        var list ='';
                        for(var i = 0;i<toys_car.data.info.list.length;i++){
                            $(".no-goods").hide();
                            if(toys_car.data.info.list[i].a <=0){
                                list +='<li class="clear"><div class="fl"><input type="radio" name="toys" onclick="toys_car.choose('+i+')"></div><div class="fl">' +
                                    '<a href="'+toys_car.data.info.list[i].e+'"><img src="'+toys_car.data.info.list[i].c+'"></a><span>暂无库存</span></div>'+'<div class="fl"><h3><a href="' +toys_car.data.info.list[i].e+
                                    '">'+toys_car.data.info.list[i].d+'</a></h3> <h4>市场参考价¥'+toys_car.data.info.list[i].h+'/h4><p>适用年龄'+toys_car.data.info.list[i].f+'岁</p>' +
                                    '</div><div class="fr"><i class="icon icon_del" onclick="toys_car.delGood('+i+')"></i></div></li>';
                            }else{
                                list +='<li class="clear"><div class="fl"><input type="radio" name="toys" onclick="toys_car.choose('+i+')"></div><div class="fl">' +
                                    '<a href="'+toys_car.data.info.list[i].e+'"><img src="'+toys_car.data.info.list[i].c+'"></a></div>'+'<div class="fl"><h3><a href="' +toys_car.data.info.list[i].e+
                                    '">'+toys_car.data.info.list[i].d+'</a></h3> <h4>市场参考价¥'+toys_car.data.info.list[i].h+'/h4><p>适用年龄'+toys_car.data.info.list[i].f+'岁</p>' +
                                    '</div><div class="fr"><i class="icon icon_del" onclick="toys_car.delGood('+i+')"></i></div></li>';
                            }
                        }
                        $(".toys-car ul").html(list);
                    }else{
                        $(".no-goods").show();
                        $(".top-tips").hide();
                        $(".btn").hide();
                    }
                }
                switch(toys_car.data.info.state){
                    case 1:   //为非会员 提示
                        $(".top-tips").addClass('red');
                        $(".top-tips").html('<i class="icon-attion">!</i>成功办理任意一种会员后，才可下单，享受免费租、随意更换服务');
                        break;
                    case 2: //会员 提示
                        $(".top-tips").removeClass('red');
                        $(".top-tips").html("同一时间内只能持有一件玩具，待归还后才能再次租用");
                }
            })
        },
        choose:function (index) {
            if(toys_car.data.info.state==1){
                $(".top-tips").addClass('red');
                $(".toys-car .btn button").removeClass('active');
                $(".top-tips").html('<i class="icon-attion">!</i>成功办理任意一种会员后，才可下单，享受免费租、随意更换服务');
            }else{
                if(toys_car.data.info.list[index].a<=0){
                    $(".top-tips").addClass('red');
                    $(".toys-car .btn button").removeClass('active');
                    $(".top-tips").html('<i class="icon-attion">!</i>当前账户已有正在租用的物品，归还后才能再下单');
                }else{
                    $(".top-tips").removeClass('red');
                    $(".toys-car .btn button").addClass('active');
                    $(".top-tips").html("同一时间内只能持有一件玩具，待归还后才能再次租用");
                }
            }
        },
        delGood:function (index) {
            console.log($(".toys-car ul li:eq("+index+") input")[0]);
            /* if($(".toys-car ul li:eq(index) input")){

             }*/
            if($(".toys-car ul li:eq("+index+") input").prop("checked")){
                common.confirm_tip("亲爱的用户","确定将选中的商品从玩具箱删除吗？",null,function () {
                    //删除商品
                    data = {id:toys_car.data.info.list[index].id};
                    common.httpRequest('../js/test.json','get',data,function (res) {
                        $(".confirm-alert-wrap").remove();
                        toys_car.get_data();
                    })
                });
            }else{
                common.alert_tip("请选择您要删除的商品？");
                return false;
            }
        },
        goSubmitOrder:function () {
            if($(".toys-car .btn button").hasClass('active')){
                location.href="/view/submit_order.html";
            }
        }
    };
    $(function () {
        $(".toys-car").height($(window).height());
        toys_car.get_data();
    })
</script>
</body>
</html>