<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>押金明细</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>
</head>
<body>
<div class="deposit-list-wrap bg-white">
    <ul>

    </ul>
</div>


<script>
    var deposit_list ={
        data:{
            list:[]
        },
        init:function() {
            var user_id = '{{$user_id}}';
            common.httpRequest("{{url('api/user/deposit_list')}}", 'post', {user_id:user_id}, function (res) {

                /*deposit_list.data.list=[
                    {a:'提现',b:'微信',c:'2017-02-12 10:02:02',d:'600.00'},
                    {a:'提现',b:'微信',c:'2017-02-12 10:02:02',d:'600.00'},
                    {a:'提现',b:'微信',c:'2017-02-12 10:02:02',d:'600.00'},
                    {a:'提现',b:'微信',c:'2017-02-12 10:02:02',d:'600.00'},
                    {a:'提现',b:'微信',c:'2017-02-12 10:02:02',d:'600.00'},
                    {a:'提现',b:'微信',c:'2017-02-12 10:02:02',d:'-600.00'}
                ];*/
                deposit_list.data.list=res.info.list;
                console.log(deposit_list.data.list);
                if(deposit_list.data.list.length>0){
                    var cont='';
                    for(var i=0;i<deposit_list.data.list.length;i++){
                        if(deposit_list.data.list[i].pay_type==1)
                        {
                            //充值
                            cont +=' <li class="clear"> <div class="fl"> <h3 class="item-name">'+deposit_list.data.list[i].pay_type_status+'</h3>'
                                +'<div class="means">微信|'+deposit_list.data.list[i].created_at+'</div></div><div class="fr">'+
                                '<span>-￥'+deposit_list.data.list[i].price+'</span></div></li>';
                        }
                        else if(deposit_list.data.list[i].pay_type==2 && deposit_list.data.list[i].price>0)
                        {
                            //提现
                            cont +=' <li class="clear"> <div class="fl"> <h3 class="item-name">'+deposit_list.data.list[i].pay_type_status+'</h3>'
                                +'<div class="means">微信|'+deposit_list.data.list[i].created_at+'</div></div><div class="fr">'+
                                '<span>+￥'+deposit_list.data.list[i].price+'</span></div></li>';
                        }
                    }
                    $(".deposit-list-wrap ul").html(cont);
                }
            })
        }
    };
    $(function () {
        deposit_list.init();
    })
</script>
</body>
</html>