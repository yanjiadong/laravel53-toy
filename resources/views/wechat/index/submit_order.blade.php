<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>提交订单</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">

    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <!--地址选择-->
    <script src="/wechat/js/picker.min.js"></script>
    <!--地址选择-->
    <script src="/wechat/js/main.js"></script>
    <script src="/wechat/js/common.js"></script>

    <!--引入js-sdk-->
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
</head>
<body>
<div class="order-wrap">
    <div class="address">
        <div class="title">
            <div class="border">
                <i class="icon icon_position"></i>
                <h5>收货地址</h5>
            </div>
        </div>
        <div class="add" onclick="order_obj.addAddress()">
            <i class="icon icon_add"></i>
            添加收货地址
        </div>
        <div class="address_detail clear  hide" onclick="order_obj.addAddress()">
            <div class="fl">
                <h4><b class="name"></b><span class="phone"></span></h4>
                <p><span></span><span></span><span></span></p>
                <h6></h6>
            </div>
            <div class="fr">
                <i class="icon icon_arrowRight_bold"></i>
            </div>
        </div>
        <div class="separate"></div>
    </div>
    <div class="order-detail">
        <div class="title">
            <div class="border">
                <i class="icon icon_orderDetail"></i>
                <h5>订单详情</h5>
            </div>
        </div>
        <div class="no-order">
            玩具箱居然是空的！
        </div>
        <div class="detail-list">
            <ul>
                <li>
                    <div class="good_show clear">
                        <div class="fl">
                            <a href="">
                                <img src="/wechat/image/other/3.png">
                            </a>
                        </div>
                        <div class="fr">
                            <h3>
                                <a href="">
                                </a>
                            </h3>
                            <h4></h4>
                            <p></p>
                        </div>
                    </div>
                    <div class="money-detail">
                        <ul>
                            <!-- <li class="clear">
                                 <div class="fl">
                                     <i class="icon icon_order2"></i>
                                     <span>押金</span>
                                 </div>
                                 <div class="fr">
                                 </div>
                             </li>
                             <li  class="clear">
                                 <div class="fl">
                                     <i class="icon icon_proDetail_label1"></i>
                                     <span></span>
                                 </div>
                                 <div class="fr">
                                 </div>
                             </li>
                             <li class="clear">
                                 <div class="fl">
                                     <i class="icon icon_proDetail_label1"></i>
                                     <div>
                                         <h3>邮费</h3>
                                         <p>每个自然月内提供2次往返免邮服务</p>
                                     </div>
                                 </div>
                                 <div class="fr">
                                     +¥100.00
                                 </div>
                             </li>-->
                        </ul>
                    </div>
                </li>
            </ul>
            <div class="total">
                共 <span class="num"></span>件商品，合计： <span class="money"></span>
            </div>
        </div>
    </div>
    <div class="footer">
        <button class="disable" onclick="order_obj.submitOrder(this)">提交订单</button>
        <input type="hidden" id="address_id" value="">
        <input type="hidden" id="receiver" value="">
        <input type="hidden" id="receiver_telephone" value="">
        <input type="hidden" id="receiver_address" value="">
        <input type="hidden" id="receiver_province" value="">
        <input type="hidden" id="receiver_city" value="">
        <input type="hidden" id="receiver_area" value="">
        <input type="hidden" id="express_price" value="">
        <input type="hidden" id="clean_price" value="">
        <input type="hidden" id="price" value="">
        <input type="hidden" id="money" value="">
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
                        <span class="province"></span>
                        <span class="city"></span>
                        <span class="area"></span>
                    </div>
                    <div class="fr">
                        <i class="icon icon_arrowRight_bold"></i>
                    </div>
                </li>
                <li class="clear">
                    <div class="fl">详细地址</div>
                    <div class="fl"><input type="text" class="address" placeholder="如街道、楼层、门牌号"></div>
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


<script>
    var order_obj = {
        data: {
            address:[],            //地址数据
            orderDataList:[],           //订单数据
            addressIndex:0,          //记录编辑的第几个
            submitOrderData:[],       //提交订单数据
            vip_state:'{{$bind_telephone}}'
        },
        init:function () {
            order_obj.address();
            order_obj.orderList();
        },
        address:function () {
            var user_id = '{{$user_id}}';
            common.httpRequest('{{url('api/address/index')}}','post',{user_id:user_id},function (res) {
                //res=[];
                order_obj.data.address = res.info.address;
                //假数据
                /*  order_obj.data.address =[
                 {a:"张三丰",b:"1804544654",c:"江苏省",d:"苏州市",e:"工业园区",f:'启月街1号工寓'},
                 {a:"张三丰1",b:"1804544653",c:"江苏省1",d:"苏州市1",e:"工业园区1",f:'启月街1号工寓1'}
                 ];*/
                order_obj.address_rander();
            })
        },
        address_rander:function (index) {
            if(order_obj.data.address.length){
                common.httpRequest('/wechat/js/test.json','get',null,function (res) {
                    $(".address .add").hide();
                    $(".address .separate").fadeIn(500);
                    if(index){
                        $(".address_detail .name").text(order_obj.data.address[index].a);
                        $(".address_detail .phone").text(order_obj.data.address[index].b);
                        $(".address_detail .fl p span:eq(0)").text(order_obj.data.address[index].c);
                        $(".address_detail .fl  p span:eq(1)").text(order_obj.data.address[index].d);
                        $(".address_detail .fl  p span:eq(2)").text(order_obj.data.address[index].e);
                        $(".address_detail h6").text(order_obj.data.address[index].f);
                    }else{

                        $(".address_detail .name").text(order_obj.data.address[0].a);
                        $(".address_detail .phone").text(order_obj.data.address[0].b);
                        $(".address_detail .fl p span:eq(0)").text(order_obj.data.address[0].c);
                        $(".address_detail .fl  p span:eq(1)").text(order_obj.data.address[0].d);
                        $(".address_detail .fl  p span:eq(2)").text(order_obj.data.address[0].e);
                        $(".address_detail h6").text(order_obj.data.address[0].f);

                        console.log(order_obj.data.address[0]);
                        $("#address_id").val(order_obj.data.address[0].g);
                        $("#receiver").val(order_obj.data.address[0].a);
                        $("#receiver_telephone").val(order_obj.data.address[0].b);
                        $("#receiver_address").val(order_obj.data.address[0].f);
                        $("#receiver_province").val(order_obj.data.address[0].c);
                        $("#receiver_city").val(order_obj.data.address[0].d);
                        $("#receiver_area").val(order_obj.data.address[0].e);

                    }
                    $(".address .address_detail").fadeIn(500);
                    $(".footer button").removeClass("disable");
                });
            }else{
                $(".address .add").fadeIn(500);
                $(".address .separate").hide();
                $(".address .address_detail").hide();
                $(".footer button").addClass("disable");

            }
        },
        orderList:function () {
            var good_id = '{{$good_id}}';
            var user_id = '{{$user_id}}';
            common.httpRequest("{{url('api/order/add_order')}}",'post',{user_id:user_id,good_id:good_id},function (res) {
                console.log(res);
                if(true){
                    //order_obj.data.orderDataList = res;
                    //假数据
                    order_obj.data.orderDataList = [
                        {a:res.info.good.good_picture,b:res.info.good.good_title,c:res.info.good.good_brand,d:res.info.good.good_price,e:0.00,f:res.info.clean_price,g:res.info.express_price
                            ,h:'#'},
                    ];

                    $("#clean_price").val(res.info.clean_price);
                    $("#express_price").val(res.info.express_price);
                    $("#price").val(res.info.price);
                    $("#money").val(res.info.money);

                    var orderDataList ="";
                    var total =0;
                    for(var i=0;i<order_obj.data.orderDataList.length;i++){
                        if(order_obj.data.orderDataList[i].g ==0){  //免邮费
                            orderDataList+='<li><div class="good_show clear"><div class="fl"><a href="'+order_obj.data.orderDataList[i].h +'"><img src="'+
                                order_obj.data.orderDataList[i].a+'"></a></div><div class="fr"><h3><a href="'+order_obj.data.orderDataList[i].h+'">'+
                                order_obj.data.orderDataList[i].b  +'</a></h3><h4>适用年龄'+order_obj.data.orderDataList[i].c+'</h4><p>市场参考价¥'+
                                order_obj.data.orderDataList[i].d+'</p></div></div><div class="money-detail"><ul><li class="clear"><div class="fl">' +
                                '<i class="icon_order2""></i><span>押金</span></div><div class="fr">+¥' +order_obj.data.orderDataList[i].e+
                                '</div></li><li  class="clear"><div class="fl"><i class="icon_order3"></i><span>包装清理费</span></div>' +
                                ' <div class="fr">+¥'+order_obj.data.orderDataList[0].f+'</div></li><li  class="clear"><div class="fl"><i class="icon_order1"></i>' +
                                '<div><h3>邮费</h3><p>每个自然月内提供2次往返免邮服务</p></div></div><div class="fr big"><span>快递</span><span>免邮费</span></div></li></ul></div></li>';
                        }else{
                            orderDataList+='<li><div class="good_show clear"><div class="fl"><a href="'+order_obj.data.orderDataList[i].h +'"><img src="'+
                                order_obj.data.orderDataList[i].a+'"></a></div><div class="fr"><h3><a href="'+order_obj.data.orderDataList[i].h+'">'+
                                order_obj.data.orderDataList[i].b  +'</a></h3><h4>适用年龄'+order_obj.data.orderDataList[i].c+'</h4><p>市场参考价¥'+
                                order_obj.data.orderDataList[i].d+'</p></div></div><div class="money-detail"><ul><li class="clear"><div class="fl">' +
                                '<i class="icon_order2""></i><span>押金</span></div><div class="fr">+¥' +order_obj.data.orderDataList[i].e+
                                '</div></li><li  class="clear"><div class="fl"><i class="icon_order3"></i><span>包装清理费</span></div>' +
                                ' <div class="fr">+¥'+order_obj.data.orderDataList[0].f+'</div></li><li  class="clear"><div class="fl"><i class="icon_order1"></i>' +
                                '<div><h3>邮费</h3><p>每个自然月内提供2次往返免邮服务</p></div></div><div class="fr">+¥'+order_obj.data.orderDataList[i].g+'</div></li></ul></div></li>';
                        }
                        total += res.info.price;


                    }
                    $(".order-detail .no-order").hide();
                    $(".order-detail .detail-list ul").html(orderDataList);
                    $(".order-detail .total .num").text(order_obj.data.orderDataList.length);
                    $(".order-detail .total .money").text('+¥'+total);

                    $(".order-detail .detail-list").fadeIn(500);

                }else{
                    $(".order-detail .no-order").fadeIn(500);
                    $(".order-detail .detail-list").hide();
                }
            })
        },
        addAddress:function () {
            $(".order-cover-wrap").fadeIn(500);
            $(".order-cover-main").fadeIn(500);
            if(order_obj.data.address.length>0){
                var cont ="";
                for(var i=0;i<order_obj.data.address.length;i++){
                    cont +='<li class="clear"><div class="fl"><h4><b class="name">'+
                        order_obj.data.address[i].a+'</b><span class="phone">'+order_obj.data.address[i].b+
                        '</span></h4><p><span>'+order_obj.data.address[i].c +'</span><span>'+
                        order_obj.data.address[i].d+'</span><span>'+order_obj.data.address[i].e+'</span></p>' +
                        '<h6>'+order_obj.data.address[i].f+'</h6></div><div class="fr"><i class="icon icon_edit"></i></div></li>'
                }
                $(".order-cover-main .address-list ul").html(cont).fadeIn(500);
                order_obj.editAddress();
                order_obj.checkAddress();
            }else{
                $(".order-cover-main .address-list ul").hide();
            }

        },
        closeAddress:function () {
            $(".order-cover-wrap").hide();
            $(".order-cover-main").hide();
        },
        newAddress:function () {
            order_obj.resetAddress();
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
                //  c: $(".order-edit-address-main .province").attr("data_id"),
                // d:$(".order-edit-address-main .city").attr("data_id"),
                // e: $(".order-edit-address-main .area").attr("data_id"),
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
            common.httpRequest('{{url('api/address/edit')}}','post',data,function (res) {
             if(res.state){
             common.alert_tip("编辑成功!","#333");
             }
             })
            order_obj.data.address[order_obj.data.addressIndex] = data;
            $(".order-cover-wrap .order-edit-address-main").hide();
            order_obj.address_rander();
            order_obj.addAddress();
            order_obj.resetAddress();
        },
        delEditAddress:function () {
            var address_id = $(".edit_address_id").val();
            //删除地址
            common.httpRequest('{{url('api/address/delete')}}','post',{address_id:address_id},function (res) {
             if(res.state){
                common.alert_tip("删除成功!","#333");
             }
             })
            order_obj.data.address.splice(order_obj.data.addressIndex,1);
            order_obj.address_rander();
            order_obj.addAddress();
            $(".order-cover-wrap .order-edit-address-main").hide();
        },
        selectAddress:function () {
            var nameEl = document.getElementById('sel_city');
            //获得省
            common.httpRequest('{{url('api/index/get_area')}}','get',null,function (res) {
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
                });
            });
        },
        checkAddress:function () {
            $(".order-cover-main .address-list ul li").click(function () {
                var index = $(this).index(".order-cover-main .address-list ul li") ;
                order_obj.data.addressIndex = index;
                order_obj.address_rander(index);
                $(".order-cover-wrap").hide();

                console.log(order_obj.data.address[index]);
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
            $(".order-edit-address-main .province").text("");
            $(".order-edit-address-main .city").text("");
            $(".order-edit-address-main .area").text("");
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

            common.httpRequest('{{url('api/address/add')}}','post',data,function (res) {
                 if(res.code==200){
                    alert("保存成功")
                 }
             })
            //order_obj.data.address.push(data);
            order_obj.address();
            order_obj.address_rander();
            order_obj.addAddress();
            $(".order-cover-wrap .order-edit-address-main").hide();
        },
        hideNewAddress:function () {
            $(".order-cover-wrap .order-edit-address-main").hide();
        },
        submitOrder:function (goal) {
            if(!$(goal).hasClass("disable")){
                if(order_obj.data.vip_state=='1'){
                    order_obj.submitConfirm();
                }else{
                    $(".cover-phone-bind").fadeIn(500);
                    if(order_obj.data.vip_state.times>3){
                        $(".phone-bind-main .tip").html('<div class="tip3 clear"><div class="fl"><i class="icon-attion">!</i></div>' +
                            '<div class="fl">今日获取验证码次数已达上限，请明天再尝试</div></div>')
                    }else{
                        $(".phone-bind-main .tip").html('<div class="tip1">为了更好的为您服务，请绑定手机号码</div>')
                    }
                }
            }
        },
        submitConfirm:function () {
            if(parseFloat($(".detail-list .total .money").text().substr(2))>0){

                //微信支付流程
                $(".cover-phone-bind").hide();
                /* wx.chooseWXPay({
                 timestamp: 0, // 支付签名时间戳，注意微信jssdk中的所有使用timestamp字段均为小写。但最新版的支付后台生成签名使用的timeStamp字段名需大写其中的S字符
                 nonceStr: '', // 支付签名随机串，不长于 32 位
                 package: '', // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=***）
                 signType: '', // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
                 paySign: '', // 支付签名
                 success: function (res) {
                 // 支付成功后的回调函数
                 }
                 });*/
                location.href = "/view/pay_success.html";
            }else{
                common.confirm_tip('提交订单','提交后订单信息将无法更改，确定提交吗？',null,function () {
                    order_obj.data.submitOrderData = order_obj.data.address[order_obj.data.addressIndex];
                    order_obj.data.submitOrderData.orderList = order_obj.data.orderDataList;

                    var user_id = '{{$user_id}}';
                    var good_id = '{{$good_id}}';
                    var clean_price = $("#clean_price").val();
                    var express_price = $("#express_price").val();
                    var price = $("#price").val();
                    var money = $("#money").val();
                    var address_id = $("#address_id").val();
                    var receiver = $("#receiver").val();
                    var receiver_telephone = $("#receiver_telephone").val();
                    var receiver_address = $("#receiver_address").val();
                    var receiver_province = $("#receiver_province").val();
                    var receiver_city = $("#receiver_city").val();
                    var receiver_area = $("#receiver_area").val();

                    var submit_data = {
                        user_id:user_id,
                        good_id:good_id,
                        clean_price:clean_price,
                        express_price:express_price,
                        price:price,
                        money:money,
                        address_id:address_id,
                        receiver:receiver,
                        receiver_telephone:receiver_telephone,
                        receiver_address:receiver_address,
                        receiver_province:receiver_province,
                        receiver_city:receiver_city,
                        receiver_area:receiver_area
                    };
                    common.httpRequest('{{url('api/order/submit_order')}}','post',submit_data,function (res) {
                         if(res.code==200){
                             common.alert_tip('提交成功');
                             $(".confirm-alert-wrap").remove();
                             location.href = "{{url('wechat/index/order_success')}}"+'/'+res.info.order_code;
                         }
                         else
                         {
                             common.alert_tip(res.msg);
                             return false;
                         }
                     });
                })
            }
        },
        //发送验证码
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
                common.httpRequest('{{url('api/index/get_telephone_code')}}','post',{telephone:phone},function (res) {
                    if(res.code == 400)
                    {
                        $(".phone-bind-main .tip").html('<div class="tip3 clear"><div class="fl"><i class="icon-attion">!</i></div>' +
                            '<div class="fl">今日获取验证码次数已达上限，请明天再尝试</div></div>');
                        return;
                    }
                    $(".form-code button").text("30秒后可获取");
                    var time=30;
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
            common.httpRequest('{{url('api/index/bind_telephone')}}','post',bind_vip,function (res) {
                if(res.code != 200)
                {
                    common.alert_tip(res.msg);
                    return false;
                }
                order_obj.submitConfirm();
            })
        },

        //是否为会员
        isVip:function () {
            common.httpRequest('../js/test.json','get',order_obj.data.submitOrderData,function (res) {
                //假数据  false 非会员  true 会员
                order_obj.data.vip_state = {state:false,times:0};
            })
        }
    };

    $(function () {
        order_obj.init();
        order_obj.selectAddress();
        order_obj.isVip();

        /* wx.config({
         debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
         appId: '', // 必填，公众号的唯一标识
         timestamp: , // 必填，生成签名的时间戳
         nonceStr: '', // 必填，生成签名的随机串
         signature: '',// 必填，签名，见附录1
         jsApiList: [] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
         });*/
    })
</script>
</body>
</html>