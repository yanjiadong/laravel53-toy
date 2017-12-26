<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>我的押金</title>
    <link href="{{ asset('wechat2/style/reset.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/common.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/style.css') }}" rel="stylesheet" type="text/css">

    <script src="{{ asset('wechat2/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('wechat2/js/common.js') }}"></script>
</head>
<body>
<div class="my-deposit-wrap">
    <div class="top-pic">
        <img src="" alt="">
    </div>
    <div class="look-record clear" onclick="myDeposit.lookList()">
        <div class="fl">
            <i class="my-deposit"></i><span>订单押金</span>
        </div>
        <div class="fr">
            <span>押金提现记录</span>
            <i class="icon icon_arrowRight_bold"></i>
        </div>
    </div>
    <div class="list">
        <ul>
            <li>
                <!-- <div class="time clear">
                     <div class="fl">
                         <span>租期13天（2013.2.3-2017.5.2）</span>
                     </div>
                     <div class="fr">
                         <span>押金¥1800</span> &lt;!&ndash;class="active"&ndash;&gt;
                     </div>
                 </div>
                 <div class="good clear">
                     <div class="fl">
                         <img src="../image/other/3.png" alt="">
                     </div>
                     <div class="fr">
                         <h3></h3>
                         <div class="num">x1</div>
                     </div>
                 </div>
                 <div class="operate">
                     <div class="tips">已逾期5天，将从押金中扣除35.2元</div>&lt;!&ndash;订单已按期归还/ 预计0-5个工作日退还到原支付账户 当前订单未结束，还不能进行押金提现&ndash;&gt;
                    &lt;!&ndash; <button class="apply">申请押金提现</button>&ndash;&gt;
                    &lt;!&ndash; <button class="applied">已申请押金提现</button>&ndash;&gt;
                     <button class="success"><i></i>押金已提现成功</button>
                 </div>-->
            </li>
        </ul>
    </div>
</div>
<div class="my-deposit-wrap-no-good">
    <div class="tips">
        <img src="/wechat2/image/common/no-good2.png">
        <h3>您还未缴纳过押金</h3>
        <h4>听说认证芝麻信用分可以减免押金哦</h4>
    </div>
</div>
<script>
    var myDeposit = {
        data:{
            infoData:{}
        },
        init:function () {
            common.httpRequest("{{ url('api/order/get_money_list') }}", 'post', {user_id:'{{ $user_id }}'}, function (res) {
                //假数据
                console.log(res);
                myDeposit.data.infoData = {
                    pic:res.info.image?res.info.image:"/wechat2/image/other/lunbo3.jpg",   //顶部大图
                    list:res.info.list
                   /* list:[{
                        isToCash:true,           //是否提现押金
                        isSuccess:false,          //是否提现成功
                        status:1,           //1为待发货  2为已发货 3为租用中   4为已归还  5 为待平台确认  6为归还成功
                        out_time:0,     //归还是否逾期
                        title:'钢铁侠米老鼠钢铁侠米老鼠钢铁侠米老米老鼠钢铁侠米后即可后开会',
                        img:'../image/other/3.png',
                        money:0,        //已归还逾期的罚金
                        num:1,
                        start_time:"2017.12.18",
                        end_time:"2017.12.20",
                        yajin:1800
                    }]*/
                };

                //赋值
                $(".my-deposit-wrap .top-pic img").attr('src',myDeposit.data.infoData.pic);
                var listCont='';
                if(myDeposit.data.infoData.list.length > 0)
                {
                    for(var i=0;i<myDeposit.data.infoData.list.length;i++){
                        //var day = myDeposit.timeGap(myDeposit.data.infoData.list[i].start_time,myDeposit.data.infoData.list[i].end_time);
                        var day = myDeposit.data.infoData.list[i].days;

                        if(myDeposit.data.infoData.list[i].can_apply_money == 0)
                        {
                            //待发货  已发货 租金具体时间不显示
                            if(myDeposit.data.infoData.list[i].status=='待发货'||myDeposit.data.infoData.list[i].status=='已发货'){
                                listCont +='<li><div class="time clear"><div class="fl"><span>租期'+day+'天</span>'+
                                    '</div><div class="fr"><span class="active">押金¥'+myDeposit.data.infoData.list[i].money+'</span></div></div><div class="good clear"><div class="fl">'+
                                    '<img src="'+myDeposit.data.infoData.list[i].good_picture+'"></div><div class="fr"><h3>'+myDeposit.data.infoData.list[i].good_title+'</h3><div class="num">x'+myDeposit.data.infoData.list[i].num+'</div></div>'+
                                    '</div><div class="operate"><div class="tips">当前订单未结束，还不能进行押金提现</div></div></li>';
                            }else if(myDeposit.data.infoData.list[i].status=='租用中'||myDeposit.data.infoData.list[i].status=='已归还'){
                                listCont +='<li><div class="time clear"><div class="fl"><span>租期'+day+'天（'+myDeposit.data.infoData.list[i].start_time_new+'-'+myDeposit.data.infoData.list[i].end_time_new+'）</span>'+
                                    '</div><div class="fr"><span class="active">押金¥'+myDeposit.data.infoData.list[i].money+'</span></div></div><div class="good clear"><div class="fl">'+
                                    '<img src="'+myDeposit.data.infoData.list[i].good_picture+'"></div><div class="fr"><h3>'+myDeposit.data.infoData.list[i].good_title+'</h3><div class="num">x'+myDeposit.data.infoData.list[i].num+'</div></div>'+
                                    '</div><div class="operate"><div class="tips">当前订单未结束，还不能进行押金提现</div></div></li>';
                            }
                        }
                        else if(myDeposit.data.infoData.list[i].can_apply_money == 1)
                        {
                            //归还成功 押金未提
                            var tips_cont =myDeposit.data.infoData.list[i].over_days==0? "订单已按期归还":"已逾期"+myDeposit.data.infoData.list[i].over_days+"天，将从押金中扣除"+myDeposit.data.infoData.list[i].over_money+"元";
                            listCont +='<li><div class="time clear"><div class="fl"><span>租期'+day+'天（'+myDeposit.data.infoData.list[i].start_time_new+'-'+myDeposit.data.infoData.list[i].end_time_new+'）</span>'+
                                '</div><div class="fr"><span class="active">押金¥'+myDeposit.data.infoData.list[i].money+'</span></div></div><div class="good clear"><div class="fl">'+
                                '<img src="'+myDeposit.data.infoData.list[i].good_picture+'"></div><div class="fr"><h3>'+myDeposit.data.infoData.list[i].good_title+'</h3><div class="num">x'+myDeposit.data.infoData.list[i].num+'</div></div>'+
                                '</div><div class="operate"><div class="tips">'+tips_cont+'</div><button class="apply" onclick="myDeposit.applyCash(\''+myDeposit.data.infoData.list[i].code+'\')">申请押金提现</button>'
                                +'</div></li>';
                        }
                        else if(myDeposit.data.infoData.list[i].can_apply_money == 3)
                        {
                            //已申请提现且提现成功
                            listCont +='<li><div class="time clear"><div class="fl"><span>租期'+day+'天（'+myDeposit.data.infoData.list[i].start_time_new+'-'+myDeposit.data.infoData.list[i].end_time_new+'）</span>'+
                                '</div><div class="fr"><span>押金¥'+myDeposit.data.infoData.list[i].money+'</span></div></div><div class="good clear"><div class="fl">'+
                                '<img src="'+myDeposit.data.infoData.list[i].good_picture+'"></div><div class="fr"><h3>'+myDeposit.data.infoData.list[i].good_title+'</h3><div class="num">x'+myDeposit.data.infoData.list[i].num+'</div></div>'+
                                '</div><div class="operate"><i class="icon-success"></i><button class="success"><i></i>押金已提现成功</button>'
                                +'</div></li>';
                        }
                        else if(myDeposit.data.infoData.list[i].can_apply_money == 2)
                        {
                            //已申请提现但后台还没有审核
                            listCont +='<li><div class="time clear"><div class="fl"><span>租期'+day+'天（'+myDeposit.data.infoData.list[i].start_time_new+'-'+myDeposit.data.infoData.list[i].end_time_new+'）</span>'+
                                '</div><div class="fr"><span>押金¥'+myDeposit.data.infoData.list[i].money+'</span></div></div><div class="good clear"><div class="fl">'+
                                '<img src="'+myDeposit.data.infoData.list[i].good_picture+'"></div><div class="fr"><h3>'+myDeposit.data.infoData.list[i].good_title+'</h3><div class="num">x'+myDeposit.data.infoData.list[i].num+'</div></div>'+
                                '</div><div class="operate"><div class="tips">预计0-5个工作日退还到原支付账户</div><button class="applied">已申请押金提现</button>'
                                +'</div></li>';
                        }
                    }
                    $(".my-deposit-wrap .list ul").html(listCont);
                }
                else
                {
                    $(".my-deposit-wrap").hide();
                    $(".my-deposit-wrap-no-good").height($(window).height()).show();
                }
            })
        },
        //计算租期时间差
        timeGap:function (start,end) {
            var s_time = new Date(start.split('.').join('/'));
            var e_time = new Date(end.split('.').join('/'));
            var day = (e_time.getTime() - s_time.getTime())/1000/(60*60*24)
            return day;
        },
        //查看归还明细
        lookList:function () {
            location.href = "{{ route('wechat2.user.deposit_list') }}";
        },
        //押金申请提现
        applyCash:function (code) {
            common.confirm_tip("确认提现","确认申请押金的提现吗？",null,function () {
                common.httpRequest("{{ url('api/order/apply_money') }}",'post',{user_id:'{{ $user_id }}',code:code},function (res) {
                    //res={success:true,error:'操作超时，请稍后重试！'};
                    if(res.code == 200){
                        location.href = "{{ url('wechat2/user/cash_success') }}"+'/'+code;
                    }else{
                        common.alert_tip(res.msg);
                    }
                })
            });
        }
    };
    $(function () {
        myDeposit.init();
    })
</script>
</body>
</html>