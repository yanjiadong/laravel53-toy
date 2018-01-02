<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>押金明细</title>
    <link href="{{ asset('wechat2/style/reset.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/common.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/style.css') }}" rel="stylesheet" type="text/css">

    {{--<link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>--}}
</head>
<body>
<div class="deposit-list-wrap bg-white">
    <ul>

    </ul>
</div>

<script src="{{ asset('wechat2/js/jquery-1.11.1.min.js') }}"></script>
<script src="{{ asset('wechat2/js/main.js') }}"></script>
<script src="{{ asset('wechat2/js/common.js') }}"></script>
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
                                '<span>+￥'+deposit_list.data.list[i].price+'</span></div></li>';
                        }
                        else if(deposit_list.data.list[i].pay_type==2 && deposit_list.data.list[i].price>0)
                        {
                            //提现
                            cont +=' <li class="clear"> <div class="fl"> <h3 class="item-name">'+deposit_list.data.list[i].pay_type_status+'</h3>'
                                +'<div class="means">微信|'+deposit_list.data.list[i].created_at+'</div></div><div class="fr">'+
                                '<span class="active">-￥'+deposit_list.data.list[i].price+'</span></div></li>';
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
<script>
    $(function () {
        /*----------避免下一页返回这一页调用这个函数-------------*/
        var bool=false;
        setTimeout(function(){
            pushHistory();
            bool=true;
        },500);
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            if(bool) {
                location.href=document.referrer;  //在这里指定其返回的地址
            }
        }, false);
    });
    function pushHistory() {
        var state = {
            title: "title",
            url: ""
        };
        window.history.pushState(state, state.title, state.url);
    }
</script>
</body>
</html>