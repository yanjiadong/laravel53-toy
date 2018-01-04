<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>提交订单</title>
    <link href="{{ asset('wechat2/style/reset.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/common.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('wechat2/style/style.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('wechat2/js/jquery-1.11.1.min.js') }}"></script>
    <!--地址选择-->
    <script src="{{ asset('wechat2/js/picker.min.js') }}"></script>
    <!--地址选择-->
    <script src="{{ asset('wechat2/js/main.js') }}"></script>
    <script src="{{ asset('wechat2/js/common.js') }}"></script>

</head>
<body>
<div class="submit-order-wrap">
    <div class="address">
        <div class="add" onclick="order_obj.addAddress()">
            <i class="icon icon_add"></i>
            添加收货地址
        </div>
        <div class="address_detail clear hide" onclick="order_obj.addAddress()">
            <div class="name-phone">
                <table>
                    <tr>
                        <td></td>
                        <td class="name"></td>
                        <td class="phone"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><i class="icon-order-detail local"></i></td>
                        <td colspan="2" class="address-detail"><span></span><span></span><span></span><span></span>
                        </td>
                        <td class="icon-right"><i class="icon icon_arrowRight_bold"></i></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="separate"></div>
    </div>
    <div class="order-detail">
        <div class="detail-list">
            <div class="good_show">
                <!-- <table>
                     <tr>
                         <td rowspan="3">
                             <a href=""><img src="../image/other/3.png"></a>
                         </td>
                         <td class="title">
                             <a href="">
                                <h3>钢铁侠米老鼠钢铁侠米老鼠钢铁侠米老2米老鼠钢铁侠米深的深度收到收到收到</h3>
                             </a>
                         </td>
                     </tr>
                     <tr>
                         <td class="price"> <h4>市场价 ¥2500.00</h4></td>
                     </tr>
                     <tr>
                         <td class="year"> <p>适龄 5-12岁</p></td>
                     </tr>
                 </table>
                 <div class="num">x1</div>-->
            </div>
            <div class="rent-time">
                <div class="title">租期 <span>（租期从您收到器具后的第二天开始计算）</span></div>
                <div class="rent-time-item clear">
                    <div class="fl">
                        <div class="cont">
                            <div class="time"><span class="time-text">1周</span><span class="discount-flag">惠</span></div>
                            <div class="money">¥/天</div>
                            <span class="checked"><i class="icon-right"></i></span> <!--icon-pencil-->
                        </div>
                    </div>
                    <div class="fl">
                        <div class="cont">
                            <div class="time"><span class="time-text">2周</span><span class="discount-flag">惠</span></div>
                            <div class="money">¥/天</div>
                            <span class="checked"><i class="icon-right"></i></span>
                        </div>
                    </div>
                    <div class="fl">
                        <div class="cont">
                            <div class="time"><span class="time-text">3周</span><span class="discount-flag">惠</span></div>
                            <div class="money">¥/天</div>
                            <span class="checked"><i class="icon-right"></i></span>
                        </div>
                    </div>
                    <div class="fl active">
                        <div class="cont">
                            <div class="time"><span class="time-text">1个月</span><span class="discount-flag">惠</span></div>
                            <div class="money">¥/天</div>
                            <span class="checked"><i class="icon-right"></i></span>
                        </div>
                    </div>
                    <div class="fl">
                        <div class="cont">
                            <div class="time"><span class="time-text">2个月</span><span class="discount-flag">惠</span></div>
                            <div class="money">¥/天</div>
                            <span class="checked"><i class="icon-right"></i></span>
                        </div>
                    </div>
                    <div class="fl" onclick="order_obj.chooseRentTimeShow()">
                        <div class="cont">
                            <div class="set-time"></div>
                            <div class="setting">
                                自定义天数
                            </div>
                            <span class="checked"><i class="icon-pencil"></i></span> <!---->
                        </div>
                    </div>
                </div>
            </div>
            <div class="distribution">
                <!--  <table>
                      <tr>
                          <td class="name">配送</td>
                          <td>顺丰速递</td>
                      </tr>
                      <tr>
                          <td></td>
                          <td>预计12月9日[周一]发货</td>
                      </tr>
                  </table>-->
            </div>
        </div>
    </div>
    <div class="rent-item-list">
        <ul>
            <li class="clear">
                <div class="fl">
                    <i class="icon-order-detail i-rent"></i><span>租金</span>
                </div>
                <div class="fr">
                    <span>¥</span>
                </div>
            </li>
            <li class="clear">
                <div class="fl">
                    <i class="icon-order-detail i-logistics"></i><span>邮费</span><span class="tips">（含往返，租金满3元可免除）</span>
                </div>
                <div class="fr">
                    <span>¥</span>
                </div>
            </li>
            <li class="clear"  onclick="order_obj.goVipVoucher()">
                <div class="fl">
                    <i class="icon-order-detail i-discount"></i><span>优惠券</span>
                </div>
                <div class="fr">
                    <div class="discount-fee">
                        <span>-¥</span>
                    </div>
                    <i class="icon icon_arrowRight_bold"></i>
                </div>
            </li>
        </ul>
    </div>
    <div class="yajin-item-list">
        <ul>
            <li class="clear">
                <div class="fl">
                    <i class="icon-order-detail i-yajin"></i><span>押金</span><span class="tips active" onclick="order_obj.goAutorization()">授权芝麻信用分，减免押金 ></span><!--<span class="tips">您已有订单正在享受免押，本次无法减免</span>-->
                </div>
                <div class="fr">
                    <div class="part1"><span>¥300</span></div>
                    <div class="part2">
                        <div class="i-return-show red">
                            <div class="cont">已享信用减免押金</div>
                        </div>
                        <div class="right">
                            <div class="origin">
                                <s>¥900</s>
                            </div>
                            <div class="actual">
                                <span>¥100</span>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="leave-msg clear">
        <div class="fl">
            <span>租客留言：</span>
        </div>
        <div class="fr">
            <textarea id="remark" maxlength="40" onfocus="order_obj.delBtnShow()"  placeholder="如对发货或收货日期有特殊需求，在此留言"></textarea>
            <div class="leave-msg-del">×</div>
        </div>
    </div>
    <div class="submit-order-footer clear bg-white">
        <div class="fl">
            <span>总计：</span>
            <span>¥1330</span>
            <p>其中押金¥900可退还</p>
        </div>
        <div class="fr">
            <button onclick="order_obj.submitOrder(this)">微信支付</button>

            <input type="hidden" id="jsApiParameters" value="">
            <input type="hidden" id="address_id" value="">
            <input type="hidden" id="receiver" value="">
            <input type="hidden" id="receiver_telephone" value="">
            <input type="hidden" id="receiver_address" value="">
            <input type="hidden" id="receiver_province" value="">
            <input type="hidden" id="receiver_city" value="">
            <input type="hidden" id="receiver_area" value="">
            <input type="hidden" id="days" value="">
            <input type="hidden" id="is_use_zhima" value="">
            <input type="hidden" id="coupon_id" value="">
        </div>
    </div>
</div>
<div class="order-cover-wrap">
    <div class="order-cover-main">
        <div class="title clear">
            选择地址
            <i class="icon icon_close fr" onclick="order_obj.closeAddress()"></i>
        </div>
        <div class="address-list">
            <ul>
                <!-- <li class="clear">
                     <div class="fl">
                         <h4><b class="name">张三丰</b><span class="phone">1804544654</span></h4>
                         <p><span>江苏省</span><span>苏州师</span><span>工业园区</span></p>
                         <h6>启月街1号工寓</h6>
                     </div>
                     <div class="fr">
                         <i class="icon icon_edit"></i>
                     </div>
                 </li>
                -->
            </ul>
        </div>
        <div class="add" onclick="order_obj.newAddress()">
            <div class="fl">
                <i class="icon icon_add"></i>添加地址
            </div>
            <div class="fr">
                <i class="icon icon_arrowRight_bold"></i>
            </div>
        </div>
    </div>
    <div class="order-edit-address-main">
        <div class="title clear">
            编辑地址
            <i class="icon icon_close fr" onclick="order_obj.hideNewAddress()"></i>
        </div>
        <div class="edit-cont">
            <ul>
                <li class="clear" id="sel_city">
                    <div class="fl">选择地址</div>
                    <div class="fl">
                        <span class="province">省</span>
                        <span class="city">市</span>
                        <span class="area">县/区</span>
                    </div>
                    <div class="fr">
                        <i class="icon icon_arrowRight_bold"></i>
                    </div>
                </li>
                <li class="clear">
                    <div class="fl">详细地址</div>
                    <div class="fl">
                        <textarea class="address" placeholder="如街道、楼层、门牌号"></textarea>
                    </div>
                </li>
                <li class="clear">
                    <div class="fl">名字</div>
                    <div class="fl"><input type="text" class="name" placeholder="收货人姓名"></div>
                </li>
                <li class="clear">
                    <div class="fl">手机号</div>
                    <div class="fl"><input type="text" class="phone" placeholder="收货人手机号"></div>
                </li>
            </ul>
            <input type="hidden" class="edit_address_id" value="">
            <input type="hidden" class="edit_province_id" value="">
            <input type="hidden" class="edit_city_id" value="">
            <input type="hidden" class="edit_area_id" value="">
        </div>
        <div class="btn">
            <button class="add" onclick="order_obj.saveAddress()">添加地址</button>
            <button class="save" onclick="order_obj.saveEditAddress()">保存</button>
            <button class="del" onclick="order_obj.delEditAddress()">删除地址</button>
        </div>
    </div>
</div>
<div class="cover-phone-bind">
    <div class="phone-bind-main">
        <div class="title">
            <h3>绑定手机号</h3>
            <div class="close-btn" onclick="order_obj.closeBind()">×</div>
            <div class="tip">
                <!--<div class="tip1">为了更好的为您服务，请绑定手机号码</div>-->
                <!--<div class="tip2 clear">
                    <div class="fl"><i class="icon-attion">!</i></div>
                    <div class="fl">输入的手机号有误</div>
                </div>-->
                <!--  <div class="tip3 clear">
                      <div class="fl"><i class="icon-attion">!</i></div>
                      <div class="fl">今日获取验证码次数已达上限，请明天再尝试</div>
                  </div>-->
            </div>
        </div>
        <div class="input">
            <div class="form-phone">
                <input type="text" placeholder="请输入手机号">
            </div>
            <div class="form-code">
                <input type="text" placeholder="请输入验证码">
                <button onclick="order_obj.sendCode()">发送验证码</button>
            </div>
        </div>
        <div class="btn">
            <button onclick="order_obj.bindVip()">绑定</button>
        </div>
    </div>
</div>
<div class="cover-rent-time-choose">
    <div class="rent-time-choose-main">
        <div class="title">
            <div class="top">
                <span class="cancel">取消</span>
                <h1 class="picker-title">自定义天数</h1>
                <span class="confirm">确定</span>
            </div>
        </div>
        <div class="choose-box">
            <div class="list">
                <div class="choose-cont"></div>
                <ul class="choose-ul">
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="submit-voucher-wrap bg-white">
    <!-- <div class="input">
         <input type="text" placeholder="请输入兑换码">
     </div>
     <div class="btn">
         <button onclick="vip_voucher.exchange()">兑换</button>
     </div>-->
    <div class="list">
        <ul>
            <!-- <li class="clear active">
                 <div class="fl">
                     <i class="icon-wave-left "></i>
                     <span>¥100</span>
                 </div>
                 <div class="fr">
                     <i class="icon-wave-right"></i>
                     <h3>新手专享优惠卷</h3>
                     <p>有效期：<span>2017.2.3-2017.3.3</span></p>
                     <h5>任意金额可用</h5>
                 </div>
             </li>
             <li class="clear">
                 <div class="fl">
                     <i class="icon-wave-left "></i>
                     <span>¥100</span>
                 </div>
                 <div class="fr">
                     <i class="icon-wave-right"></i>
                     <h3>新手专享优惠卷</h3>
                     <p>有效期：<span>2017.2.3-2017.3.3</span></p>
                     <h5>任意金额可用</h5>
                 </div>
             </li>-->
        </ul>
    </div>
    <div class="footer bg-white">
        <button onclick="vip_voucher.noUser()">不使用优惠劵</button>
    </div>
    <div class="no-good">
        <div class="tips">
            <img src="/wechat2/image/common/no-good3.png">
            <h4>您还没有可用的优惠券</h4>
        </div>
    </div>
</div>

<!--微信js-sdk-->
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>
    var order_obj = {
        data: {
            address:[],            //地址数据/*{a:"张三丰",b:"1804544654",c:"江苏省",d:"苏州市",e:"工业园区",f:'启月街1号工寓'}*/
            orderGoodData:{},           //订单数据
            addressIndex:0,          //记录编辑的第几个
            submitOrderData:[],       //提交订单数据
            vip_state:'{{ $bind_telephone }}',
            rent_time_list:[],   //租期列表
            rent_data:{},      //租期租金存放数据
            actural_data:{discount:sessionStorage.getItem('discount_money')?sessionStorage.getItem('discount_money'):0,coupon_id:sessionStorage.getItem('discount_car_id')?sessionStorage.getItem('discount_car_id'):0 }, //存放实际付费数据 ，用于计算总计
            vip_state:"{{ $bind_telephone }}",
            order_code:''
        },
        init:function () {
            order_obj.address();
            order_obj.orderList();
        },
        //留言
        delBtnShow:function () {
            $(".leave-msg-del").show();
            $(".leave-msg-del").click(function () {
                $("#remark").val("");
            });
            $(document).click(function (e) {
                if(e.target!=$("#remark")[0]&&e.target!=$(".leave-msg-del")[0]){
                    $(".leave-msg-del").hide();
                }
            })
        },
        //用户地址
        address:function () {
            common.httpRequest("{{url('api/address/index')}}",'post',{user_id:'{{ $user_id }}'},function (res) {
                order_obj.data.address = res.info.address;
                order_obj.address_rander();
            })
        },
        //商品初始化数据
        orderList:function () {
            var good_id = '{{$good_id}}';
            var user_id = '{{$user_id}}';
            common.httpRequest("{{url('api/order/add_order_new')}}",'post',{user_id:user_id,good_id:good_id},function (res) {
                //console.log(res);
                if(true){
                    //order_obj.data.orderDataList = res;
                    //假数据
                    order_obj.data.orderDataList ={
                        good: {
                            a:res.info.good.good_picture,     //商品封面图片
                            b:res.info.good.good_title, //商品名称
                            c:res.info.good.good_old,  //适龄
                            d:res.info.good.good_price,   //市场价
                            e:'#',       //点击商品跳转的链接
                            num:1,       //租用的商品数量
                        },
                        logistics:{
                            company:res.info.good.good_express,   //物流公司
                            money:res.info.good.good_express_price,             //邮费
                            post_time:res.info.good.good_days,          //发货时间
                            can_free:res.info.good.good_free_price          //满多少可以免邮费
                        },
                        yajin:{
                            money:res.info.good.good_money,
                            discount:res.info.good.good_money_discount,
                            authorization:res.info.good.can_use_zhima,  //是否授权认证
                            actual_money:res.info.money
                        }
                    };

                    $("#is_use_zhima").val(res.info.good.can_use_zhima);
                    $("#coupon_id").val(order_obj.data.actural_data.coupon_id);
                    $("#days").val(30);

                    //商品赋值
                    var orderGoodData =' <table><tr><td rowspan="3"><a href="'+order_obj.data.orderDataList.good.e+'"><img src="'+order_obj.data.orderDataList.good.a+'"></a>' +
                        '</td><td class="title"><a href="'+order_obj.data.orderDataList.good.e+'"><h3>'+order_obj.data.orderDataList.good.b+'</h3>' +
                        '</a></td></tr><tr><td class="price"> <h4>市场价 ¥'+Math.round(order_obj.data.orderDataList.good.d)+'</h4></td></tr><tr><td class="year"> <p>适龄'+order_obj.data.orderDataList.good.c+'</p></td>' +
                        '</tr></table><div class="num">x'+order_obj.data.orderDataList.good.num+'</div>';
                    $(".order-detail .detail-list .good_show").html(orderGoodData);

                    //配送赋值
                    var now_date = new Date();
                    var now_day = new Date().getDate()+order_obj.data.orderDataList.logistics.post_time;
                    var now_month = new Date().getMonth();
                    var now_year = new Date().getFullYear();
                    var send_date = new Date(now_year,now_month,now_day);
                    var send_week="";
                    switch (send_date.getDay()){
                        case 0:
                            send_week="周日";
                            break;
                        case 1:
                            send_week="周一";
                            break;
                        case 2:
                            send_week="周二";
                            break;
                        case 3:
                            send_week="周三";
                            break;
                        case 4:
                            send_week="周四";
                            break;
                        case 5:
                            send_week="周五";
                            break;
                        case 6:
                            send_week="周六";
                            break;
                    }
                    var send_info =' <table><tr><td class="name">配送</td><td>'+order_obj.data.orderDataList.logistics.company+'</td></tr><tr><td></td>' +
                        '<td>预计'+res.info.send_time.send_date+'[周'+res.info.send_time.send_week+']发货</td></tr></table>';
                    $(".submit-order-wrap .detail-list .distribution").html(send_info);


                    //押金赋值
                    console.log(order_obj.data.orderDataList.yajin);
                    if(order_obj.data.orderDataList.yajin.discount>0){
                        //order_obj.data.actural_data.yajin = order_obj.data.orderDataList.yajin.money-order_obj.data.orderDataList.yajin.discount;
                        order_obj.data.actural_data.yajin = order_obj.data.orderDataList.yajin.actual_money;

                        $(".submit-order-wrap .yajin-item-list ul li .fr .part1").hide();
                        $(".submit-order-wrap .yajin-item-list ul li .fr .part2").show();
                        $(".submit-order-wrap .yajin-item-list ul li .fr .part2 .origin s").text('¥'+Math.round(order_obj.data.orderDataList.yajin.money));
                        //$(".submit-order-wrap .yajin-item-list ul li .fr .part2 .actual").text('¥'+Math.round(order_obj.data.orderDataList.yajin.money-order_obj.data.orderDataList.yajin.discount));
                        $(".submit-order-wrap .yajin-item-list ul li .fr .part2 .actual").text('¥'+Math.round(order_obj.data.actural_data.yajin));
                        $(".submit-order-wrap .yajin-item-list ul li .fl span.tips").hide();


                    }else{
                        if(order_obj.data.orderDataList.yajin.authorization){
                            $(".submit-order-wrap .yajin-item-list ul li .fr .part1").show();
                            $(".submit-order-wrap .yajin-item-list ul li .fr .part1 span").text('¥'+Math.round(order_obj.data.orderDataList.yajin.money));
                            $(".submit-order-wrap .yajin-item-list ul li .fr .part2").hide();
                            $(".submit-order-wrap .yajin-item-list ul li .fl span.tips").text('您已有订单正在享受免押，本次无法减免').removeClass('active');
                            order_obj.data.actural_data.yajin = order_obj.data.orderDataList.yajin.money;
                        }else{
                            $(".submit-order-wrap .yajin-item-list ul li .fr .part1").show();
                            $(".submit-order-wrap .yajin-item-list ul li .fr .part1 span").text('¥'+Math.round(order_obj.data.orderDataList.yajin.money));
                            $(".submit-order-wrap .yajin-item-list ul li .fr .part2").hide();

                            $(".submit-order-wrap .yajin-item-list ul li .fl span.tips").text('授权芝麻信用分，减免押金 >').addClass('active');
                            order_obj.data.actural_data.yajin = order_obj.data.orderDataList.yajin.money;
                        }
                    }

                    //获取租期每天的租金
                    //common.httpRequest('../js/test.json','get',null,function (res) {
                        /*res={
                            data:[
                                {name:'1周',money:12.5,isDiscount:false},  //isDiscount是不是优惠的价格
                                {name:'2周',money:11.5,isDiscount:true},
                                {name:'3周',money:10.5,isDiscount:true},
                                {name:'1个月',money:9.2,isDiscount:true},
                                {name:'2个月',money:4.8,isDiscount:false}
                            ]
                        };*/

                        //给租期赋值
                        order_obj.data.rent_time_list = res.info.price_info;
                        for(var i=0;i<order_obj.data.rent_time_list.length;i++){
                            if(order_obj.data.rent_time_list[i].isDiscount){   //有优惠后
                                switch (order_obj.data.rent_time_list[i].name){
                                    case '1周':
                                        $(".rent-time .rent-time-item .fl:eq(0) .money").text('¥'+order_obj.data.rent_time_list[i].money+'/天');
                                        $(".rent-time .rent-time-item .fl:eq(0) .discount-flag").css({'display':'inline-block'});
                                        break;
                                    case '2周':
                                        $(".rent-time .rent-time-item .fl:eq(1) .money").text('¥'+order_obj.data.rent_time_list[i].money+'/天');
                                        $(".rent-time .rent-time-item .fl:eq(1) .discount-flag").css({'display':'inline-block'});
                                        break;
                                    case '3周':
                                        $(".rent-time .rent-time-item .fl:eq(2) .money").text('¥'+order_obj.data.rent_time_list[i].money+'/天');
                                        $(".rent-time .rent-time-item .fl:eq(2) .discount-flag").css({'display':'inline-block'});
                                        //order_obj.data.actural_data.rent = Math.round(21*order_obj.data.rent_time_list[i].money*10)/10;
                                        break;
                                    case '1个月':
                                        $(".rent-time .rent-time-item .fl:eq(3) .money").text('¥'+order_obj.data.rent_time_list[i].money+'/天');
                                        $(".rent-time .rent-time-item .fl:eq(3) .discount-flag").css({'display':'inline-block'});
                                        order_obj.data.actural_data.rent = Math.round(30*order_obj.data.rent_time_list[i].money*10)/10;
                                        break;
                                    case '2个月':
                                        $(".rent-time .rent-time-item .fl:eq(4) .money").text('¥'+order_obj.data.rent_time_list[i].money+'/天');
                                        $(".rent-time .rent-time-item .fl:eq(4) .discount-flag").css({'display':'inline-block'});
                                        break;
                                }
                            }else{
                                switch (order_obj.data.rent_time_list[i].name){
                                    case '1周':
                                        $(".rent-time .rent-time-item .fl:eq(0) .money").text('¥'+order_obj.data.rent_time_list[i].money+'/天');
                                        $(".rent-time .rent-time-item .fl:eq(0) .discount-flag").hide();
                                        break;
                                    case '2周':
                                        $(".rent-time .rent-time-item .fl:eq(1) .money").text('¥'+order_obj.data.rent_time_list[i].money+'/天');
                                        $(".rent-time .rent-time-item .fl:eq(1) .discount-flag").hide();
                                        break;
                                    case '3周':
                                        $(".rent-time .rent-time-item .fl:eq(2) .money").text('¥'+order_obj.data.rent_time_list[i].money+'/天');
                                        $(".rent-time .rent-time-item .fl:eq(2) .discount-flag").hide();
                                        //  order_obj.data.rent_data ={time:'21',per_money:order_obj.data.rent_time_list[i].money,rent_money:Math.round(21*order_obj.data.rent_time_list[i].money*10)/10}; //初始默认三周为选中
                                        //order_obj.data.actural_data.rent = Math.round(21*order_obj.data.rent_time_list[i].money*10)/10;
                                        break;
                                    case '1个月':
                                        $(".rent-time .rent-time-item .fl:eq(3) .money").text('¥'+order_obj.data.rent_time_list[i].money+'/天');
                                        $(".rent-time .rent-time-item .fl:eq(3) .discount-flag").hide();
                                        order_obj.data.actural_data.rent = Math.round(30*order_obj.data.rent_time_list[i].money*10)/10;
                                        break;
                                    case '2个月':
                                        $(".rent-time .rent-time-item .fl:eq(4) .money").text('¥'+order_obj.data.rent_time_list[i].money+'/天');
                                        $(".rent-time .rent-time-item .fl:eq(4) .discount-flag").hide();
                                        break;
                                }
                            }
                        }

                        //租金赋值
                        $(".rent-item-list ul li:eq(0) .fr span").text('¥'+ order_obj.data.actural_data.rent);
                        //邮费赋值
                        console.log('商品邮费'+order_obj.data.orderDataList.logistics.money);
                        $(".rent-item-list ul li:eq(1) .fl span.tips").text('（含往返，租金满'+Math.round(order_obj.data.orderDataList.logistics.can_free)+'元可免除）');
                        if(order_obj.data.actural_data.rent>=order_obj.data.orderDataList.logistics.can_free){
                            $(".rent-item-list ul li:eq(1) .fr span").text('¥0');
                            order_obj.data.actural_data.post = 0;
                        }else{
                            $(".rent-item-list ul li:eq(1) .fr span").text('¥'+Math.round(order_obj.data.orderDataList.logistics.money));
                            order_obj.data.actural_data.post = order_obj.data.orderDataList.logistics.money;
                        }
                        //优惠券赋值
                        if( order_obj.data.actural_data.discount!=0){
                            $(".rent-item-list ul li:eq(2) .fr .discount-fee").html('<span class="red">-¥'+order_obj.data.actural_data.discount+'</span>');
                        }else{
                            order_obj.discountCarShow();
                        }
                        //总计
                        console.log('租金:'+order_obj.data.actural_data.rent);
                        console.log('邮费:'+order_obj.data.actural_data.post);
                        console.log('优惠券减免金额:'+order_obj.data.actural_data.discount);
                        console.log('押金:'+order_obj.data.actural_data.yajin);

                        $(".submit-order-wrap .submit-order-footer .fl span:nth-child(2)").text('¥'+Math.round((order_obj.data.actural_data.rent*1+order_obj.data.actural_data.post*1-order_obj.data.actural_data.discount*1+order_obj.data.actural_data.yajin*1)*10)/10);

                        //押金说明
                        if(order_obj.data.actural_data.yajin>0){
                            $(".submit-order-wrap .submit-order-footer .fl p").text('其中押金¥'+Math.round(order_obj.data.actural_data.yajin)+'可退还');
                        }else{
                            $(".submit-order-wrap .submit-order-footer .fl p").text('押金已全免');
                        }
                    //});


                }else{
                    $(".order-detail .no-order").fadeIn(500);
                    $(".order-detail .detail-list").hide();
                }
            })
        },
        //优惠券显示
        discountCarShow :function(){
            $("#coupon_id").val(0);
            order_obj.data.actural_data.discount = 0;
            common.httpRequest("{{ url('api/user/user_coupon_list') }}",'post',{user_id:'{{ $user_id }}'},function (res) {
                //res=[{can_use_money:100},{can_use_money:200},{can_use_money:300},{can_use_money:500}];
                order_obj.data.actural_data.discount =0;
                var car_list =[];
                if(res.info.coupons.length>0){
                    for(var i=0;i<res.info.coupons.length;i++){
                        if(order_obj.data.actural_data.rent>=res.info.coupons[i].condition){
                            car_list.push(res[i]);
                        }
                    }
                    if(car_list.length>0){
                        $(".rent-item-list ul li:eq(2) .fr .discount-fee").html('<span>'+car_list.length+'张可用</span>');
                    }else{
                        $(".rent-item-list ul li:eq(2) .fr .discount-fee").html('<span>无可用优惠券</span>');
                    }

                }else{
                    $(".rent-item-list ul li:eq(2) .fr .discount-fee").html('<span>无可用优惠券</span>');
                }
            });
            console.log('优惠券金额'+order_obj.data.actural_data.discount);
        },
        //用户地址赋值
        address_rander:function (index) {
            if(order_obj.data.address.length){
                console.log(index);
                common.httpRequest('/wechat2/js/test.json','get',null,function (res) {
                    $(".address .add").hide();
                    $(".address .separate").fadeIn(500);
                    if(index){
                        $(".name-phone table tr td.name").text(order_obj.data.address[index].a);
                        $(".name-phone table tr td.phone").text(order_obj.data.address[index].b);
                        $(".name-phone table tr td.address-detail span:eq(0)").text(order_obj.data.address[index].c);
                        $(".name-phone table tr td.address-detail span:eq(1)").text(order_obj.data.address[index].d);
                        $(".name-phone table tr td.address-detail span:eq(2)").text(order_obj.data.address[index].e);
                        $(".name-phone table tr td.address-detail span:eq(3)").text(order_obj.data.address[index].f);
                        console.log(order_obj.data.address[index]);
                        order_obj.data.orderDataList.logistics.money = order_obj.data.address[index].express_price;
                        //邮费赋值
                        if(order_obj.data.actural_data.rent >= order_obj.data.orderDataList.logistics.can_free){
                            $(".rent-item-list ul li:eq(1) .fr span").text('¥0');
                            order_obj.data.actural_data.post =0
                        }else{
                            $(".rent-item-list ul li:eq(1) .fr span").text('¥'+Math.round(order_obj.data.orderDataList.logistics.money));
                            order_obj.data.actural_data.post = order_obj.data.orderDataList.logistics.money;
                        }
                        //总计
                        $(".submit-order-wrap .submit-order-footer .fl span:nth-child(2)").text('¥'+Math.round((order_obj.data.actural_data.rent*1+order_obj.data.actural_data.post*1-order_obj.data.actural_data.discount*1+order_obj.data.actural_data.yajin*1)*10)/10);
                    }else{
                        $(".name-phone table tr td.name").text(order_obj.data.address[0].a);
                        $(".name-phone table tr td.phone").text(order_obj.data.address[0].b);
                        $(".name-phone table tr td.address-detail span:eq(0)").text(order_obj.data.address[0].c);
                        $(".name-phone table tr td.address-detail span:eq(1)").text(order_obj.data.address[0].d);
                        $(".name-phone table tr td.address-detail span:eq(2)").text(order_obj.data.address[0].e);
                        $(".name-phone table tr td.address-detail span:eq(3)").text(order_obj.data.address[0].f);

                        console.log(order_obj.data.address[0]);
                        $("#address_id").val(order_obj.data.address[0].g);
                        $("#receiver").val(order_obj.data.address[0].a);
                        $("#receiver_telephone").val(order_obj.data.address[0].b);
                        $("#receiver_address").val(order_obj.data.address[0].f);
                        $("#receiver_province").val(order_obj.data.address[0].c);
                        $("#receiver_city").val(order_obj.data.address[0].d);
                        $("#receiver_area").val(order_obj.data.address[0].e);

                        if(index == 0)
                        {
                            order_obj.data.orderDataList.logistics.money = order_obj.data.address[0].express_price;
                            //邮费赋值
                            if(order_obj.data.actural_data.rent >= order_obj.data.orderDataList.logistics.can_free){
                                $(".rent-item-list ul li:eq(1) .fr span").text('¥0');
                                order_obj.data.actural_data.post =0
                            }else{
                                $(".rent-item-list ul li:eq(1) .fr span").text('¥'+Math.round(order_obj.data.orderDataList.logistics.money));
                                order_obj.data.actural_data.post = order_obj.data.orderDataList.logistics.money;
                            }
                            //总计
                            $(".submit-order-wrap .submit-order-footer .fl span:nth-child(2)").text('¥'+Math.round((order_obj.data.actural_data.rent*1+order_obj.data.actural_data.post*1-order_obj.data.actural_data.discount*1+order_obj.data.actural_data.yajin*1)*10)/10);
                        }
                    }
                    $(".address .address_detail").fadeIn(500);
                    $(".footer button").removeClass("disable");
                });
            }else{
                $(".address .add").fadeIn(500);
                $(".address .address_detail").hide();
                $(".footer button").addClass("disable");
            }
        },
        addAddress:function () {
            $(".submit-order-wrap").css({'height':$(window).height(),'overflow':'hidden'});
            $(".order-cover-wrap").fadeIn(500);
            var cont ="";
            for(var i=0;i<order_obj.data.address.length;i++){
                cont +='<li class="clear"><div class="fl"><h4><b class="name">'+
                    order_obj.data.address[i].a+'</b><span class="phone">'+order_obj.data.address[i].b+
                    '</span></h4><p><span>'+order_obj.data.address[i].c +'</span><span>'+
                    order_obj.data.address[i].d+'</span><span>'+order_obj.data.address[i].e+'</span></p>' +
                    '<h6>'+order_obj.data.address[i].f+'</h6></div><div class="fr"><i class="icon icon_edit"></i></div></li>'
            }
            $(".order-cover-main .address-list ul").html(cont).show();
            $(".order-cover-main").fadeIn(500);
            order_obj.editAddress();
            order_obj.checkAddress();

        },
        closeAddress:function () {
            $(".submit-order-wrap").css({'height':'auto','overflow':'visible'});
            $(".order-cover-wrap").hide();
            $(".order-cover-main").hide();
        },
        newAddress:function () {
            order_obj.resetAddress();
            $(".submit-order-wrap").css({'height':$(window).height(),'overflow':'hidden'});
            $(".order-cover-wrap").fadeIn(500);
            $(".order-cover-wrap .order-edit-address-main").fadeIn(500);
            $(".order-cover-wrap .btn .del").hide();
            $(".order-cover-wrap .btn .add").fadeIn(500);
            $(".order-cover-wrap .btn .save").hide();
        },
        editAddress:function () {
            $(".order-cover-main .address-list ul li .icon_edit").click(function (event) {
                event.stopPropagation();
                var index = $(this).index(".order-cover-main .address-list ul li .icon_edit") ;
                order_obj.data.addressIndex =index;
                $(".order-cover-wrap .order-edit-address-main .edit-cont .name").val(order_obj.data.address[index].a);
                $(".order-cover-wrap .order-edit-address-main .edit-cont .phone").val(order_obj.data.address[index].b);
                $(".order-cover-wrap .order-edit-address-main .edit-cont .province").text(order_obj.data.address[index].c);
                $(".order-cover-wrap .order-edit-address-main .edit-cont  .city").text(order_obj.data.address[index].d);
                $(".order-cover-wrap .order-edit-address-main  .edit-cont .area").text(order_obj.data.address[index].e);
                $(".order-cover-wrap .order-edit-address-main .edit-cont .address").val(order_obj.data.address[index].f);
                $(".submit-order-wrap").css({'height':$(window).height(),'overflow':'hidden'});
                $(".order-cover-wrap").fadeIn(500);
                $(".order-cover-wrap .order-edit-address-main").fadeIn(500);
                $(".order-cover-wrap .btn .del").fadeIn(500);
                $(".order-cover-wrap .btn .save").fadeIn(500);
                $(".order-cover-wrap .btn .add").hide();

                $(".edit_address_id").val(order_obj.data.address[index].g);
                $(".edit_province_id").val(order_obj.data.address[index].province_id);
                $(".edit_city_id").val(order_obj.data.address[index].city_id);
                $(".edit_area_id").val(order_obj.data.address[index].area_id);
            });
        },
        saveEditAddress:function () {
            var  data = {
                c: $(".order-edit-address-main .province").text(),
                d:$(".order-edit-address-main .city").text(),
                e: $(".order-edit-address-main .area").text(),
                f:$(".order-edit-address-main .address").val(),
                a:$(".order-edit-address-main .name").val(),
                b:$(".order-edit-address-main .phone").val(),
                g:$(".edit_address_id").val(),
                user_id:'{{$user_id}}',
                province_id:$(".edit_province_id").val(),
                city_id:$(".edit_city_id").val(),
                area_id:$(".edit_area_id").val()
            };
            if($(".order-edit-address-main .province").text() =="省"){
                common.alert_tip("请选择地址！");
                return false;
            }
            if(!data.f){
                common.alert_tip("详细地址不能为空！");
                return false;
            }
            if(!data.a){
                common.alert_tip("收货人姓名不能为空！");
                return false;
            }
            if(!data.b){
                common.alert_tip("手机号不能为空！");
                return false;
            }
            var phonePattern = /^0?(13|14|15|17|18)[0-9]{9}$/g;

            if(!phonePattern.test(data.b)){
                common.alert_tip("请输入正确的手机号码！");
                return false;
            }
            //编辑提交
            common.httpRequest("{{url('api/address/edit')}}",'post',data,function (res) {
                //res.state=true;
                if(res.code == 200){
                    common.alert_tip("编辑成功!","#333");
                    order_obj.data.address[order_obj.data.addressIndex] = data;
                    $(".order-cover-wrap .order-edit-address-main").hide();
                    order_obj.address_rander();
                    order_obj.addAddress();
                    order_obj.resetAddress();
                }
            })

        },
        delEditAddress:function () {
            common.confirm_tip('提示','是否删除地址？',null,function () {
                var address_id = $(".edit_address_id").val();
                //删除地址
                common.httpRequest('{{url('api/address/delete')}}','post',{address_id:address_id},function (res) {

                });
                //删除地址
                /*common.httpRequest('../js/test.json','post',data,function (res) {
                 if(res.state){
                 common.success("删除成功!");
                 }
                 })*/
                order_obj.data.address.splice(order_obj.data.addressIndex,1);
                order_obj.addAddress();
                $(".order-cover-wrap .order-edit-address-main").hide();
                $(".confirm-alert-wrap").remove();
            })

        },
        selectAddress:function () {
            var nameEl = document.getElementById('sel_city');
            //获得省
            common.httpRequest("{{url('api/index/get_area')}}",'get',null,function (res) {
                //var first = [{text:'江苏',value:'0'},{text:'浙江',value:'1'},{text:'广州',value:'2'}]; /* 省，直辖市 */
                var first = res.info; /* 省，直辖市 */
                var second = [{text: '', value: 0}]; /* 市 */
                var third = [{text: '', value: 0}]; /* 镇 */
                var selectedIndex = [0, 0, 0]; /* 默认选中的地区 */
                var checked = [0, 0, 0]; /* 已选选项 */
                /*  function creatList(obj, list){
                      obj.forEach(function(item, index, arr){
                          var temp = new Object();
                          temp.text = item.name;
                          temp.value = index;
                          list.push(temp);
                      })
                  }
                  creatList(city, first);
                  if (city[selectedIndex[0]].hasOwnProperty('sub')) {
                      creatList(city[selectedIndex[0]].sub, second);
                  } else {
                      second = [{text: '', value: 0}];
                  }

                  if (city[selectedIndex[0]].sub[selectedIndex[1]].hasOwnProperty('sub')) {
                      creatList(city[selectedIndex[0]].sub[selectedIndex[1]].sub, third);
                  } else {
                      third = [{text: '', value: 0}];
                  }
                  console.log(first,second,third);*/
                var picker = new Picker({
                    data: [first, second, third],
                    selectedIndex: selectedIndex,
                    title: '地址选择'
                });

                picker.on('picker.select', function (selectedVal, selectedIndex) {
                    var text1 = first[selectedIndex[0]].text;
                    var text2 = second[selectedIndex[1]].text;
                    var text3 = third[selectedIndex[2]] ? third[selectedIndex[2]].text : '';
                    if(text1=="请选择"||!text1||text2=="请选择"||!text2||text3=="请选择"||!text3){
                        common.alert_tip("请将地址选择完整!");
                        return false;
                    }
                    $(".order-edit-address-main .province").text(text1);
                    $(".order-edit-address-main .city").text(text2);
                    $(".order-edit-address-main .area").text(text3);
                });

                picker.on('picker.change', function (index, selectedIndex) {
                    if (index === 0){
                        firstChange();
                    } else if (index === 1) {
                        secondChange();
                    }
                    //获得市   注：selectIndex 为选择省的value值
                    function firstChange() {
                        var firstCity = first[selectedIndex];   //选中省的对象
                        checked[0] = selectedIndex;
                        common.httpRequest('{{url('api/index/get_area')}}'+'/'+firstCity.value,'get',null,function (res) {
                            var res ={
                                //list:[{text:'苏州',value:'0'},{text:'南京',value:'1'}]
                                list:res.info
                            };
                            if(res.list.length>0){
                                second =  res.list
                            }else{
                                second  = [{text:'',value:'0'}];
                            }
                            third = [{text:'',value:'0'}];
                            picker.refillColumn(1, second);
                            picker.refillColumn(2, third);
                            picker.scrollColumn(1, 0);
                            picker.scrollColumn(2, 0)
                        });
                    }
                    //获得区
                    function secondChange() {
                        third = [];
                        checked[1] = selectedIndex;
                        var secondCity = second[selectedIndex];   //选中市的对象
                        common.httpRequest('{{url('api/index/get_area')}}'+'/'+secondCity.value,'get',null,function (res) {
                            var res ={
                                //list:[{text:'工业园区',value:'0'},{text:'吴中',value:'1'}]
                                list:res.info
                            };
                            if(res.list.length>0){
                                third =  res.list;
                            }else{
                                checked[2] = 0;
                                third  = [{text:'',value:'0'}];
                            }
                            picker.refillColumn(2, third);
                            picker.scrollColumn(2, 0)
                        });
                        /*   third = [];
                           checked[1] = selectedIndex;
                           var first_index = checked[0];
                           if (city[first_index].sub[selectedIndex].hasOwnProperty('sub')) {
                               var secondCity = city[first_index].sub[selectedIndex];
                               creatList(secondCity.sub, third);
                               picker.refillColumn(2, third);
                               picker.scrollColumn(2, 0)
                           } else {
                               third = [{text: '', value: 0}];
                               checked[2] = 0;
                               picker.refillColumn(2, third);
                               picker.scrollColumn(2, 0)
                           }*/
                    }

                });

                picker.on('picker.valuechange', function (selectedVal, selectedIndex) {
                    $(".order-edit-address-main .province").attr("data_id",selectedVal[0]);
                    $(".order-edit-address-main .city").attr("data_id",selectedVal[1]);
                    $(".order-edit-address-main .area").attr("data_id",selectedVal[2]);
                });

                nameEl.addEventListener('click', function () {
                    picker.show();
                    $(".picker").click(function (ev) {
                        picker.hide();
                    })
                });
            });
        },
        checkAddress:function () {
            $(".order-cover-main .address-list ul li").click(function () {
                var index = $(this).index(".order-cover-main .address-list ul li") ;
                order_obj.data.addressIndex =index;
                order_obj.address_rander(index);
                $(".submit-order-wrap").css({'height':'auto','overflow':'visible'});
                $(".order-cover-wrap").hide();

                //console.log(order_obj.data.address[index]);
                $("#address_id").val(order_obj.data.address[index].g);
                $("#receiver").val(order_obj.data.address[index].a);
                $("#receiver_telephone").val(order_obj.data.address[index].b);
                $("#receiver_address").val(order_obj.data.address[index].f);
                $("#receiver_province").val(order_obj.data.address[index].c);
                $("#receiver_city").val(order_obj.data.address[index].d);
                $("#receiver_area").val(order_obj.data.address[index].e);
            })
        },
        resetAddress:function () {
            $(".order-edit-address-main .province").text("省");
            $(".order-edit-address-main .city").text("市");
            $(".order-edit-address-main .area").text("县/区");
            $(".order-edit-address-main .address").val("");
            $(".order-edit-address-main .name").val("");
            $(".order-edit-address-main .phone").val("");
        },
        saveAddress:function () {
            var  data = {
                //  c: $(".order-edit-address-main .province").attr("data_id"),
                // d:$(".order-edit-address-main .city").attr("data_id"),
                // e: $(".order-edit-address-main .area").attr("data_id"),
                c: $(".order-edit-address-main .province").text(),
                d:$(".order-edit-address-main .city").text(),
                e: $(".order-edit-address-main .area").text(),
                f:$(".order-edit-address-main .address").val(),
                a:$(".order-edit-address-main .name").val(),
                b:$(".order-edit-address-main .phone").val(),
                user_id:'{{$user_id}}'
            };
            if($(".order-edit-address-main .province").text() =="省"){
                common.alert_tip("请选择地址！");
                return false;
            }
            if(!data.f){
                common.alert_tip("详细地址不能为空！");
                return false;
            }
            if(!data.a){
                common.alert_tip("收货人姓名不能为空！");
                return false;
            }
            if(!data.b){
                common.alert_tip("手机号不能为空！");
                return false;
            }
            var phonePattern = /^0?(13|14|15|17|18)[0-9]{9}$/g;
            if(!phonePattern.test(data.b)){
                common.alert_tip("请输入正确的手机号码！");
                return false;
            }
            var state = order_obj.data.address.length;
            common.httpRequest("{{url('api/address/add')}}",'post',data,function (res) {
                if(res.code == 200)
                {
                    common.success_tip("收货地址添加成功！");
                    common.httpRequest("{{url('api/address/index')}}",'post',{user_id:'{{ $user_id }}'},function (res) {
                        //res=[];
                        order_obj.data.address = res.info.address;
                        //假数据
                        /*order_obj.data.address =[
                            {a:"张三丰",b:"1804544654",c:"江苏省",d:"苏州市",e:"工业园区",f:'启月街1号工寓启月街1号工寓启月街1号工寓启月街1号工寓启月街1号工寓启月街1号工寓'}
                        ];*/
                        order_obj.address_rander();
                        order_obj.addAddress();
                        if(state==0){
                            $(".submit-order-wrap").css({'height':'auto','overflow':'visible'});
                            $(".order-cover-wrap").hide();
                        }
                        $(".order-cover-wrap .order-edit-address-main").hide();
                    })
                }

            });
            //order_obj.data.address.push(data);

        },
        hideNewAddress:function () {
            $(".order-cover-wrap .order-edit-address-main").hide();
        },

        submitOrder:function (goal) {
            console.log(order_obj.data.vip_state);
            if(!$(".address_detail .name-phone table tr td.address-detail span:last-child").text()){
                common.alert_tip1("请添加收货地址！");
                return false;
            }
            if(!$(goal).hasClass("disable")){
                if(order_obj.data.vip_state == '0'){
                    order_obj.submitConfirm();
                }else{
                    $(".submit-order-wrap").css({'height':$(window).height(),'overflow':"hidden"});
                    $(".cover-phone-bind").fadeIn(500);
                    $(".phone-bind-main .tip").html('<div class="tip1">为了更好的为您服务，请绑定手机号码</div>')

                    /*if(order_obj.data.vip_state.times>3){
                        $(".phone-bind-main .tip").html('<div class="tip3 clear"><div class="fl"><i class="icon-attion">!</i></div>' +
                            '<div class="fl">今日获取验证码次数已达上限，请明天再尝试</div></div>')
                    }else{
                        $(".phone-bind-main .tip").html('<div class="tip1">为了更好的为您服务，请绑定手机号码</div>')
                    }*/
                }
            }
        },
        submitConfirm:function () {
            //微信支付流程
            $(".submit-order-wrap").css({'height':'auto','overflow':"visible"});
            $(".cover-phone-bind").hide();

            var user_id = '{{$user_id}}';
            var good_id = '{{$good_id}}';
            var address_id = $("#address_id").val();
            var receiver = $("#receiver").val();
            var receiver_telephone = $("#receiver_telephone").val();
            var receiver_address = $("#receiver_address").val();
            var receiver_province = $("#receiver_province").val();
            var receiver_city = $("#receiver_city").val();
            var receiver_area = $("#receiver_area").val();
            var days = $("#days").val();
            var is_use_zhima = $("#is_use_zhima").val();
            var coupon_id = $("#coupon_id").val();
            var user_remark = $("#remark").val();

            var submit_data = {
                user_id:user_id,
                good_id:good_id,
                address_id:address_id,
                receiver:receiver,
                receiver_telephone:receiver_telephone,
                receiver_address:receiver_address,
                receiver_province:receiver_province,
                receiver_city:receiver_city,
                receiver_area:receiver_area,
                days:days,
                is_use_zhima:is_use_zhima,
                coupon_id:coupon_id,
                user_remark:user_remark
            };

            console.log(submit_data);
            common.httpRequest('{{url('api/order/submit_order_new')}}','post',submit_data,function (res) {
                if(res.code==200)
                {
                    order_obj.data.order_code = res.info.order_code;
                    console.log(order_obj.data);

                    $("#jsApiParameters").val(res.info.jsApiParameters);
                    callpay();
                }
                else
                {
                    common.success_tip(res.msg);
                    return false;
                }
            });
        },
        //发送手机验证码
        sendCode:function () {
            var phone = $(".form-phone input").val();
            if(!phone){
                common.alert_tip('手机号不能为空！');
                return false;
            }else if(!checkInput.phone(phone)){
                common.alert_tip('请输入正确的手机号！');
                return false;
            }else{
                //发送短信
                common.httpRequest("{{url('api/index/get_telephone_code')}}",'post',{telephone:phone},function (res) {
                    if(res.code == 400)
                    {
                        $(".phone-bind-main .tip").html('<div class="tip3 clear"><div class="fl"><i class="icon-attion">!</i></div>' +
                            '<div class="fl">今日获取验证码次数已达上限，请明天再尝试</div></div>');
                        return;
                    }
                    if(res.code == 300)
                    {
                        common.success_tip(res.msg);
                        return false;
                    }
                    $(".form-code button").text("60秒后可获取");
                    var time=60;
                    var h =  setInterval(function () {
                        if(time>0){
                            time--;
                            $(".form-code button").text(time+"秒后可获取");
                        }else{
                            clearInterval(h);
                            $(".form-code button").text("发送验证码");
                        }
                    },1000);
                })
            }
        },
        closeBind:function () {
            $(".submit-order-wrap").css({'height':'auto','overflow':"visible"});
            $(".cover-phone-bind").fadeOut(500);
        },
        //绑定会员
        bindVip:function () {
            var bind_vip ={
                telephone:$(".form-phone input").val(),
                code:$(".form-code input").val(),
                wechat_openid:'{{$openid}}'
            };
            if(!bind_vip.telephone){
                common.alert_tip('手机号不能为空！');
                return false;
            }else if(!checkInput.phone(bind_vip.telephone)){
                common.alert_tip('请输入正确的手机号！');
                return false;
            }else if(!bind_vip.code){
                common.alert_tip('验证码不能为空！');
                return false;
            }
            common.httpRequest("{{url('api/index/bind_telephone')}}",'post',bind_vip,function (res) {
                /*res ={
                    code:200,
                    msg:'手机号绑定成功！'
                };*/
                if(res.code!=200){
                    common.success_tip(res.msg);
                    return false;
                }
                order_obj.data.vip_state = '0';
                $(".submit-order-wrap").css({'height':'auto','overflow':"visible"});
                $(".cover-phone-bind").hide();
                common.success_tip('手机号绑定成功！');
            })
        },

        //显示选择自定义天数弹框
        chooseRentTimeShow:function () {
            $(".cover-rent-time-choose").show();
            $(" .rent-time-choose-main").animate({'bottom':0},500);
        },
        //选择自定义天数
        chooseRentTimeOperate:function () {
            //赋值
            var li_cont='';
            for(var i=8;i<=60;i++){
                li_cont +='<li class="active">'+i+'</li>';
            }
            $(".choose-box .choose-ul").html(li_cont);

            var start,end,num=0,ul_t;
            //触发
            var $chooseUl =  $(".choose-box")[0];
            $chooseUl.addEventListener('touchstart',function(event){
                event.preventDefault();
                start = event.changedTouches[0].pageY;
                ul_t = parseFloat($(".choose-box .list .choose-ul").css('top'));
            },true);
            //移动
            $chooseUl.addEventListener('touchmove',function(event){
                //当屏幕有多个touch或者页面被缩放过，就不执行move操作
                event.preventDefault();
                end = event.changedTouches[0].pageY;
                var ul_h = $(".choose-box .list .choose-ul").height();
                $(".choose-box .list .choose-ul").css('top',ul_t-(start-end)+'px');
            });
            //移出
            $chooseUl.addEventListener('touchend',function(event){
                //当屏幕有多个touch或者页面被缩放过，就不执行move操作
                event.preventDefault();
                end = event.changedTouches[0].pageY;
                var  ul_t_e = parseFloat($(".choose-box .list .choose-ul").css('top'));
                var ul_h = parseInt($(".choose-box .list .choose-ul").height());
                var last = ul_t-(start-end);
                if(ul_t_e>=40){
                    $(".choose-box .list .choose-ul").css('top','40px');
                    $(".choose-box .list .choose-ul li").removeClass('active');
                    $(".choose-box .list .choose-ul li:eq(0)").addClass('active');
                }else if(ul_t_e<=(-ul_h+80)){
                    $(".choose-box .list .choose-ul").css('top',(-ul_h+80)+'px');
                    $(".choose-box .list .choose-ul li").removeClass('active');
                    $(".choose-box .list .choose-ul li:last").addClass('active');
                }else{
                    var num = Math.floor(Math.abs(start-end)/40);
                    if(start-end>0){
                        if((start-end)%40>20){
                            num++;
                        }
                        $(".choose-box .list .choose-ul").css('top',ul_t-(num*40)+'px');
                        $(".choose-box .list .choose-ul li").removeClass('active');
                        $(".choose-box .list .choose-ul li:eq("+(Math.abs((ul_t-(num*40))/40)+1)+")").addClass('active');

                    }else{
                        if((start-end)%40>20){
                            num--;
                        }
                        $(".choose-box .list .choose-ul").css('top',ul_t+(num*40)+'px');
                        $(".choose-box .list .choose-ul li").removeClass('active');
                        $(".choose-box .list .choose-ul li:eq("+(Math.abs((ul_t+num*40)/40)+1)+")").addClass('active');
                    }
                }
            });

            //取消
            $(".rent-time-choose-main .cancel").click(function () {
                $(".cover-rent-time-choose").hide();
                $(" .rent-time-choose-main").css({'bottom':'-270px'});
            });

            //选中日期
            $(".rent-time-choose-main .confirm").click(function () {
                var days =   $(".choose-box .list .choose-ul li.active").text();
                $("#days").val(days);
                common.httpRequest("{{ url('api/good/get_day_price') }}",'post',{good_id:'{{$good_id}}',days:days},function (res) {
                    res = {
                        data:{
                            //money:4.8
                            money:res.info.price
                        }
                    };

                    order_obj.data.actural_data.rent =Math.round(days*res.data.money*10)/10;
                    $(".rent-time .cont .set-time").text(days+'天').show();
                    $(".rent-time .cont .setting").text('¥'+res.data.money+'/天').css({'color':'#f00'});
                    //$(".rent-time .cont .setting").text('¥'+res.data.money+'/天').css({'line-height':'26px','color':'#f00'});
                    $(".rent-time .rent-time-item .fl").removeClass('active');
                    $(".rent-time .rent-time-item .fl:last").addClass('active');
                    //租金赋值
                    $(".rent-item-list ul li:eq(0) .fr span").text('¥'+ order_obj.data.actural_data.rent);
                    //邮费赋值
                    if(order_obj.data.actural_data.rent >= order_obj.data.orderDataList.logistics.can_free){
                        $(".rent-item-list ul li:eq(1) .fr span").text('¥0');
                        order_obj.data.actural_data.post =0
                    }else{
                        $(".rent-item-list ul li:eq(1) .fr span").text('¥'+Math.round(order_obj.data.orderDataList.logistics.money));
                        order_obj.data.actural_data.post = order_obj.data.orderDataList.logistics.money;
                    }

                    //优惠券赋值
                    order_obj.discountCarShow();

                    //总计
                    $(".submit-order-wrap .submit-order-footer .fl span:nth-child(2)").text('¥'+Math.round((order_obj.data.actural_data.rent*1+order_obj.data.actural_data.post*1-order_obj.data.actural_data.discount*1+order_obj.data.actural_data.yajin*1)*10)/10);

                    $(".cover-rent-time-choose").hide();
                    $(" .rent-time-choose-main").css({'bottom':'-270px'});

                });
            });
        },
        //选择租期项
        chooseRentTimeItem:function () {
            $(".rent-time .rent-time-item .fl").click(function () {
                $(".rent-time .rent-time-item .fl:last .set-time").hide();
                $(".rent-time .rent-time-item .fl:last .setting").text("自定义天数").css({'margin-top':'9px','color':'#797979'});
                if($(this).find(".setting").length==0){
                    $(".rent-time .rent-time-item .fl").removeClass('active');
                    $(this).addClass('active');
                    var _day =  $(this).find(".time-text").text();
                    switch (_day){
                        case '1周':
                            _day = 7;
                            break;
                        case '2周':
                            _day = 14;
                            break;
                        case '3周':
                            _day = 21;
                            break;
                        case '1个月':
                            _day = 30;
                            break;
                        case '2个月':
                            _day = 60;
                            break;
                    }
                    $("#days").val(_day);
                    order_obj.data.actural_data.rent =Math.round(_day*parseFloat($(this).find(".money").text().slice(1,$(this).find(".money").text().length-2))*10)/10;
                    //租金赋值
                    $(".rent-item-list ul li:eq(0) .fr span").text('¥'+ order_obj.data.actural_data.rent);
                    //邮费赋值
                    if(order_obj.data.actural_data.rent >= order_obj.data.orderDataList.logistics.can_free){
                        $(".rent-item-list ul li:eq(1) .fr span").text('¥0');
                        order_obj.data.actural_data.post =0
                    }else{
                        $(".rent-item-list ul li:eq(1) .fr span").text('¥'+Math.round(order_obj.data.orderDataList.logistics.money));
                        order_obj.data.actural_data.post = order_obj.data.orderDataList.logistics.money;
                    }

                    //优惠券赋值
                    order_obj.discountCarShow();

                    //总计
                    $(".submit-order-wrap .submit-order-footer .fl span:nth-child(2)").text('¥'+Math.round((order_obj.data.actural_data.rent*1+order_obj.data.actural_data.post*1-order_obj.data.actural_data.discount*1+order_obj.data.actural_data.yajin*1)*10)/10);
                }
            })
        },
        //跳转到优惠券页面
        goVipVoucher:function () {
            $(".submit-voucher-wrap").show();
            $(".submit-order-wrap").hide();
            $("title").text("优惠券");
            //优惠券列表
            vip_voucher.init();
        },
        //跳转认证页面
        goAutorization:function () {
            if($(".submit-order-wrap .yajin-item-list ul li .fl span.tips").hasClass("active")){
                location.href="{{ url('wechat2/index/zmxy/index') }}";
            }
        }
    };

    var vip_voucher ={
        data:{
            list:[],
            state:false,                //是不是从个人中心进入 true是   false为不是
            discount_car_id:"",
            rentMoney:0   //租金
        },
        init:function(){
            vip_voucher.data.discount_car_id =sessionStorage.getItem('discount_car_id')?sessionStorage.getItem('discount_car_id'):"";       //优惠券卡id值/**/
            vip_voucher.data.rentMoney =order_obj.data.actural_data.rent;
            common.httpRequest("{{ url('api/user/user_coupon_list') }}",'post',{user_id:'{{ $user_id }}'},function (res) {
                /*vip_voucher.data.list=[
                    {id:0,money:10,cont:'满减优惠券',time:'2017.8.27-2017.12.31',fanwei:'任意金额可用',rent:0},
                    {id:1,money:20,cont:'满减优惠卷',time:'2017.8.27-2017.12.31',fanwei:'满200元可用',rent:200},
                    {id:2,money:30,cont:'满减优惠卷',time:'2017.8.27-2017.12.31',fanwei:'满300元可用',rent:300}
                ];*/
                vip_voucher.data.list = res.info.coupons;
                if(vip_voucher.data.list.length>0){
                    var cont='';
                    var max=0,max_index;
                    for(var i=0;i<vip_voucher.data.list.length;i++){
                        if(vip_voucher.data.list[i].condition == 0)
                        {
                            var fanwei = '任意金额可用';
                        }
                        else
                        {
                            var fanwei = '租金满'+vip_voucher.data.list[i].condition+'元可用';
                        }


                        if(vip_voucher.data.list[i].condition <= vip_voucher.data.rentMoney && vip_voucher.data.list[i].can_use){
                            /*-----之前选中优惠券再进入默认是选中------*/
                            /*if(vip_voucher.data.discount_car_id!=""&&vip_voucher.data.list[i].id==vip_voucher.data.discount_car_id){
                                console.log(vip_voucher.data.discount_car_id);
                                cont+='<li class="clear active"><div class="fl"><i class="icon-wave-left "></i><span>¥'+vip_voucher.data.list[i].coupon_price+'</span>'
                                    +'</div><div class="fr"><i class="icon-wave-right"></i><h3>'+vip_voucher.data.list[i].coupon_title+'</h3>' +
                                    '<p>有效期：<span>'+vip_voucher.data.list[i].time+'</span></p><h5>'+fanwei+'</h5></div></li>';
                            }else{
                                cont+='<li class="clear"><div class="fl"><i class="icon-wave-left "></i><span>¥'+vip_voucher.data.list[i].coupon_price+'</span>'
                                    +'</div><div class="fr"><i class="icon-wave-right"></i><h3>'+vip_voucher.data.list[i].coupon_title+'</h3>' +
                                    '<p>有效期：<span>'+vip_voucher.data.list[i].time+'</span></p><h5>'+fanwei+'</h5></div></li>';
                            }*/
                            cont+='<li class="clear"><div class="fl"><i class="icon-wave-left "></i><span>¥'+vip_voucher.data.list[i].coupon_price+'</span>'
                                +'</div><div class="fr"><i class="icon-wave-right"></i><h3>'+vip_voucher.data.list[i].coupon_title+'</h3>' +
                                '<p>有效期：<span>'+vip_voucher.data.list[i].time+'</span></p><h5>'+fanwei+'</h5></div></li>';
                            //筛选最大金额
                            if(max<vip_voucher.data.list[i].coupon_price){
                                max = vip_voucher.data.list[i].coupon_price;
                                max_index = i;
                            }
                        }else{
                            cont+='<li class="clear disable"><div class="fl"><i class="icon-wave-left "></i><span>¥'+vip_voucher.data.list[i].coupon_price+'</span>'
                                +'</div><div class="fr"><i class="icon-wave-right"></i><h3>'+vip_voucher.data.list[i].coupon_title+'</h3>' +
                                '<p>有效期：<span>'+vip_voucher.data.list[i].time+'</span></p><h5>'+fanwei+'</h5></div></li>';
                        }
                    }
                    $(".submit-voucher-wrap  .list ul").html(cont);
                    vip_voucher.choose();
                }else{
                    $(".submit-voucher-wrap  .no-good").show();
                    $(".submit-voucher-wrap  .list").hide();
                    $(".submit-voucher-wrap  .footer").hide();
                }
            })
        },
        //选择优惠劵
        choose:function () {
            $item = $(".submit-voucher-wrap  .list ul li").not(".disable");
            $item.click(function () {
                $item.removeClass('active');
                $(this).addClass('active');
                var index = $(this).index(".submit-voucher-wrap  .list ul li");
                //提交选择
                order_obj.data.actural_data.discount =vip_voucher.data.list[index].coupon_price;
                $(".rent-item-list ul li:eq(2) .fr .discount-fee").html('<span class="red">-¥'+order_obj.data.actural_data.discount+'</span>');
                //总计
                $(".submit-order-wrap .submit-order-footer .fl span:nth-child(2)").text('¥'+Math.round((order_obj.data.actural_data.rent*1+order_obj.data.actural_data.post*1-order_obj.data.actural_data.discount*1+order_obj.data.actural_data.yajin*1)*10)/10);

                sessionStorage.discount_car_id = vip_voucher.data.list[index].id;
                $("#coupon_id").val(vip_voucher.data.list[index].id);
                $(".submit-voucher-wrap").hide();
                $(".submit-order-wrap").show();
                $("title").text("提交订单");
            })
        },
        //不使用优惠劵
        noUser:function () {
            sessionStorage.discount_money="";
            sessionStorage.discount_car_id = "";

            order_obj.discountCarShow();
            $(".submit-voucher-wrap").hide();
            $(".submit-order-wrap").show();
            $("title").text("提交订单");
            $(".submit-order-wrap .submit-order-footer .fl span:nth-child(2)").text('¥'+Math.round((order_obj.data.actural_data.rent*1+order_obj.data.actural_data.post*1-order_obj.data.actural_data.discount*1+order_obj.data.actural_data.yajin*1)*10)/10);
        }
    };

    $(function () {
        order_obj.init();
        order_obj.selectAddress();
        //order_obj.isVip();
        //自定义天数
        order_obj.chooseRentTimeOperate();
        order_obj.chooseRentTimeItem();
        /*(function () {
            $province = $(".select-address-wrap .province ul:first");
            common.httpRequest('../js/test.json','get',null,function (res){
                var height = $province.height();
                /!*省*!/
                var $first  = $(".select-address-wrap .province ul:eq(0) li");
                $first.removeClass('active').removeClass('show');
                if(height/35>1){
                    $first.first().addClass('active');
                    $first.eq(1).addClass('show');
                }else if(height/35==1){
                    $first.first().addClass('active');
                }
            });
            /!*选择省*!/$province
            var startY;
            $province[0].addEventListener('touchstart',function (event) {
                startY = event.targetTouches[0].clientY;
            });
            $province[0].addEventListener('touchmove',function (event) {
                var gap = event.targetTouches[0].clientY-startY;
               console.log(Math.floor(gap/35));
                $province.css({top:Math.floor(gap/35)*35+35+'px'});
            });
        })()*/
    })
</script>
<script>
    $(function () {
        if(document.referrer.indexOf("index/good")>-1||document.referrer.indexOf("index/cart")>-1){
            sessionStorage.setItem("submit_order_url",document.referrer)
        }

        pushHistory();
        /*----------避免下一页返回这一页调用这个函数-------------*/
        var bool=false;
        setTimeout(function(){
            bool=true;
        },500);
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            if($(".submit-voucher-wrap").css('display')=="block"){
                $(".submit-voucher-wrap").hide();
                $(".submit-order-wrap").show();
                $("title").text("提交订单");
                pushHistory();
            }else{
                if(bool) {
                    location.href=sessionStorage.getItem('submit_order_url')?sessionStorage.getItem('submit_order_url'):document.referrer;  //在这里指定其返回的地址
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

    //调用微信JS api 支付
    function jsApiCall()
    {
        var jsApiParameters = JSON.parse($("#jsApiParameters").val());
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest', jsApiParameters,
            function(res){
                //alert(res.err_msg);
                //WeixinJSBridge.log(res.err_msg);
                //alert(res.err_msg);
                //alert(res.err_code+res.err_desc+res.err_msg);
                if(res.err_msg === "get_brand_wcpay_request:ok") {
                    var get_url = "{{url('api/user/get_cart_order_num')}}";
                    common.getCarAndOrder(get_url,'{{$user_id}}'); //获取订单数量和购物车数量

                    //支付成功
                    setTimeout(function () {
                        //var url = 'http://toy.yanjiadong.net/wechat2/index/pay_success'+'/'+order_obj.data.order_code;
                        var url = '{{url('wechat2/index/pay_success')}}'+'/'+order_obj.data.order_code;
                        location.href=url;
                    },1000)
                }
                else if(res.err_msg === "get_brand_wcpay_request:cancel")
                {
                    //location.href=document.referrer;
                }
                else
                {
                    //window.history.go(-1);
                }
            }
        );
    }

    function callpay()
    {
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        }else{
            jsApiCall();
        }
    }

</script>
</body>
</html>