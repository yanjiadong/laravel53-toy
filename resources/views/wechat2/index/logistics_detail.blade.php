<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>物流状态</title>
    <link href="{{ asset('wechat2/style/reset.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/common.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/style.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('wechat2/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('wechat2/js/main.js') }}"></script>
    <script src="{{ asset('wechat2/js/common.js') }}"></script>

    {{--<link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">
    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>--}}
</head>
<body>
<div class="logistics-detail-wrap">
    <div class="logistics-title bg-white">
        <h3>{{$order->express_title}}</h3>
        <p>运单号：<span>{{$order->express_no}}</span></p>
    </div>
    <div class="logistics-cont bg-white">
        <div class="top">
            <i class="icon icon_state_delivery"></i>
            <span>物流追踪</span>
        </div>
        <div class="list">
            <ul>
                <!--  <li class="active">
                      <div class="line1 clear">
                          <div class="top-line fl"></div>
                          <h3 class="fl">【北京市】北京分拨中心北京分拨中心北京分拨中心北京分拨中心北京分拨中心北京分拨中心 已发出</h3>
                      </div>
                      <div class="line2 clear">
                          <div class="fl">
                              <div class="img"><i class="icon icon_circle_done"></i></div>
                              &lt;!&ndash;<div class="circle-grey"></div>&ndash;&gt;
                          </div>
                         <div class="fl space"></div>
                      </div>
                      <div class="line3 clear">
                          <div class="fl"><div class="bottom-line"></div></div>
                          <p class="fl">2017-4-21 12:21:21</p>
                      </div>
                  </li>
                  <li class="normal">
                      <div class="line1 clear">
                          <div class="fl"><div class="top-line"></div></div>
                          <h3 class="fl">【北京市】北京分拨中心北京分拨中心北京分拨中心北京分拨中心北京分拨中心北京分拨中心 已发出</h3>
                      </div>
                      <div class="line2 clear">
                          <div class="fl">
                              <div class="circle-grey"></div>
                          </div>
                          <div class="fl space"></div>
                      </div>
                      <div class="line3 clear">
                          <div class="fl"><div class="bottom-line"></div></div>
                          <p class="fl">2017-4-21 12:21:21</p>
                      </div>
                  </li>
                  <li class="last">
                      <div class="line1 clear">
                          <div class="fl"><div class="top-line"></div></div>
                          <h3 class="fl">【北京市】北京分拨中心北京分拨中心北京分拨中心北京分拨中心北京分拨中心北京分拨中心 已发出</h3>
                      </div>
                      <div class="line2 clear">
                          <div class="fl">
                              <div class="circle-grey"></div>
                          </div>
                          <div class="fl space"></div>
                      </div>
                      <div class="line3 clear">
                          <div class="fl"></div>
                          <p class="fl">2017-4-21 12:21:21</p>
                      </div>
                  </li>-->
            </ul>
        </div>
    </div>
</div>
<div class="logistics-detail-wrap-tips"><span>物流进度获取中...</span></div>

<script>
    var logistics_detail ={
        data:{
            logisticsList:[]       //物流数据
        },
        init:function () {
            common.httpRequest('{{url('api/order/logistics_detail')}}', 'post', {'nu':'{{$order->express_no}}'}, function (res) {
                //假数据
                /*logistics_detail.data.logisticsList = [
                    {time:1492744860000,cont:'【苏州市】快件已送达 感谢使用顺丰快递包裹，期待再次为您服务'},
                    {time:1492744860000,cont:'【苏州市】斜塘支局派件员：张三丰18852364857正为你派件'},
                    {time:1492744860000,cont:'【苏州市】快件已到达 斜塘支局'},
                    {time:1492744860000,cont:'【苏州市】快件已从苏州中心发出，准备发往苏州'},
                    {time:1492744850000,cont:'【苏州市】快件已到达 苏州中心'},
                    {time:1492744840000,cont:'【苏州市】快件已从顺丰快递公司江苏省常熟市函件分局发出，准备发往苏州'},
                    {time:1492744830000,cont:'【苏州市】邮政快递包裹 顺丰快递公司江苏省常熟市函件分局收件员 已揽件'}
                ];*/
                logistics_detail.data.logisticsList = res.info.logistics;
                console.log(res.info.logistics);

                if(logistics_detail.data.logisticsList.length > 0)
                {
                    $(".logistics-detail-wrap-tips").hide();
                    $(".logistics-detail-wrap .logistics-cont .list").show();
                    //$(".logistics-detail-wrap").show();

                    var cont='';
                    for(var i=0;i<logistics_detail.data.logisticsList.length;i++){
                        if(i==0){
                            cont ='<li class="active"><div class="line1 clear"><div class="top-line fl"></div><h3 class="fl">' +
                                logistics_detail.data.logisticsList[i].context+ ' 已发出</h3></div><div class="line2 clear"><div class="fl">' +
                                '<div class="img"><i class="icon icon_circle_done"></i></div></div><div class="fl space"></div></div>' +
                                '<div class="line3 clear"><div class="fl"><div class="bottom-line"></div></div><p class="fl">'+
                                logistics_detail.data.logisticsList[i].ftime+ '</p></div></li>';
                            $('.logistics-cont .list ul').append(cont);
                            cont='';
                            $('.logistics-cont .list ul li.active .line1 .top-line').height($('.logistics-cont .list ul li:eq('+i+') .line1 h3').height()+'px');
                        }else if(i==(logistics_detail.data.logisticsList.length-1)){
                            cont ='<li class="last"><div class="line1 clear"><div class="fl"><div class="top-line"></div></div><h3 class="fl">'
                                +logistics_detail.data.logisticsList[i].context+ '</h3></div><div class="line2 clear"><div class="fl">' +
                                '<div class="circle-grey"></div></div><div class="fl space"></div></div><div class="line3 clear">' +
                                '<div class="fl"></div><p class="fl">'+logistics_detail.data.logisticsList[i].ftime+'</p></div></li>';
                            $('.logistics-cont .list ul').append(cont);
                            cont='';
                            $('.logistics-cont .list ul li.last .line1 .top-line').height($('.logistics-cont .list ul li.last .line1 h3').height()+'px');
                        }else{
                            cont='<li class="normal"><div class="line1 clear"><div class="fl"><div class="top-line"></div></div>' +
                                '<h3 class="fl">'+logistics_detail.data.logisticsList[i].context+'</h3></div><div class="line2 clear">' +
                                '<div class="fl"><div class="circle-grey"></div></div><div class="fl space"></div></div>' +
                                '<div class="line3 clear"><div class="fl"><div class="bottom-line"></div></div> <p class="fl">' +
                                logistics_detail.data.logisticsList[i].ftime +'</p></div></li>';
                            $('.logistics-cont .list ul').append(cont);
                            cont='';
                            $('.logistics-cont .list ul li.normal:first .line1 .top-line').height($('.logistics-cont .list ul li.normal:first .line1 h3').height()+'px');
                        }
                    }
                }
                /*logistics_detail.data.logisticsList.sort(function (a,b) {
                    return b.time-a.time
                });*/

            })
        }
    };
    $(function () {
        $(".logistics-detail-wrap-tips").height($(window).height()-$(".logistics-title").outerHeight()-$(".logistics-cont").outerHeight()-10);
        logistics_detail.init();
    })
</script>
</body>
</html>