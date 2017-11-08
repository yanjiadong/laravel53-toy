<!DOCTYPE html>
<html lang="en" class="bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>芝麻信用授权</title>
    <link href="/wechat/style/reset.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/common.css" rel="stylesheet" type="text/css">
    <link href="/wechat/style/style.css" rel="stylesheet" type="text/css">
    <script src="/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/wechat/js/common.js"></script>
</head>
<body style="background-color: #f7f7f7">
<div class="authorization-info">
    <div class="top">
        <div class="state1">
            <i class="icon-zmxy2"></i>
            <p>650分以上即可减免押金，最高减免3000元</p>
        </div>
        <div class="state2">
            <h3>芝麻信用评分</h3>
            <h2></h2>
            <p></p>
        </div>
    </div>
    <div class="count">
        您已获得<span></span>元押金减免额度
    </div>
    <div class="detail">
        <div class="part1">
            <h3>什么是芝麻信用分</h3>
            <p>芝麻信用分是由芝麻信用提供，面向社会的信用服务体系，提供方方面面的信用状况，运用大数据及云计算客观呈现个人的信用状况，通过连接各种服务，让每个人都能体验信用带来的价值。</p>
        </div>
        <div class="part2">
            <h3>如何获得芝麻信用免押金额度</h3>
            <table>
                <tr>
                    <td rowspan="11"></td>
                    <td class="dot-box"><div class="dot"></div></td>
                    <td>650≤芝麻信用分≤700</td>
                </tr>
                <tr>
                    <td></td>
                    <td>最高可获得1000元的免押金额度</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="dot-box"><div class="dot"></div></td>
                    <td>700＜芝麻信用分≤750</td>
                </tr>
                <tr>
                    <td></td>
                    <td>最高可获得1500元的免押金额度</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="dot-box"><div class="dot"></div></td>
                    <td>750＜芝麻信用分≤800</td>
                </tr>
                <tr>
                    <td></td>
                    <td>最高可获得2000元的免押金额度</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="dot-box"><div class="dot"></div></td>
                    <td>芝麻信用分800分以上</td>
                </tr>
                <tr>
                    <td></td>
                    <td>最高可获得3000元的免押金额度</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="submit">
        <button onclick="zmxy.apply()">立即授权</button>
    </div>
</div>
<div class="authorization">
    <div class="info">
        <div class="pic">
            <table>
                <tr>
                    <td><i class="icon-logo-big"></i></td>
                    <td><i class="icon-return"></i></td>
                    <td><i class="icon-zmxy"></i></td>
                </tr>
            </table>
        </div>
        <div class="form">
            <div class="name">
                <input type="text" placeholder="输入真实姓名" onblur="zmxy.checkName(this)">
            </div>
            <div class="certificates">
                <input type="number" placeholder="输入身份证号码" onblur="zmxy.checkNum(this)">
            </div>
            <div class="tip">以上信息仅用于完成授权，平台不会用作任何其他用途</div>
        </div>
    </div>
    <div class="submit">
        <button onclick="zmxy.submit()">下一步</button>
    </div>
</div>


<script>
    $(function () {
        //设置内容高度
        $(".authorization").css({'min-height':$(window).height()});
        $(".authorization-info").css({'min-height':$(window).height()});
        zmxy.init();
    });
    var name,num,flag1=false,flag2=false;  //填写姓名 证件号  姓名验证标记   证件号验证标记
    var zmxy ={
        data:{
            state:1,   //1为可以申请授权  2为授权成功     3为可以重新授权
            creditData:{}
        },
        init:function () {
            //获取授权状态
            common.httpRequest('{{url('api/user/zhima')}}','post',{user_id:'{{$user_id}}'},function (res) {
                /*res = {
                    state:1,
                    data:{
                        count:750,
                        name:"信用极好"
                    }
                };*/
                res_data = {
                    count:res.info.user.zhima_score,
                    name:res.info.zhima_str,
                    zhima_money:res.info.user.zhima_money
                }
                zmxy.data.state=res.info.state;
                zmxy.data.creditData=res_data;
                var $submit  =  $(".authorization-info .submit");
                var $submit_btn  =  $(".authorization-info .submit button");

                switch (zmxy.data.state){
                    case 1:
                        $submit.show();
                        $(".authorization-info .top .state1").show();
                        $(".authorization-info .top .state2").hide();
                        $(".authorization-info .count").hide();
                        $submit_btn.text("立即授权");
                        break;
                    case 2:
                        $(".authorization-info .top .state2").show();
                        $(".authorization-info .top .state2 h2").text(zmxy.data.creditData.count+'分');
                        $(".authorization-info .top .state2 p").text(zmxy.data.creditData.name);
                        $(".authorization-info .top .state1").hide();
                        $(".authorization-info .count").show();
                        $(".authorization-info .count span").text(zmxy.data.creditData.zhima_money);
                        $submit.hide();
                        break;
                    case 3:
                        $(".authorization-info .top .state2").show();
                        $(".authorization-info .top .state2 h2").text(zmxy.data.creditData.count+'分');
                        $(".authorization-info .top .state2 p").text(zmxy.data.creditData.name);
                        $(".authorization-info .top .state1").hide();
                        $(".authorization-info .count").show();
                        $(".authorization-info .count span").text(zmxy.data.creditData.zhima_money);
                        $submit.show();
                        $submit_btn.text("重新授权");
                        break;
                }

            })
        },
        //押金抵扣额度
        quota:function(count){
            if(count>650&&count<=700){
                return 1000
            }else if(count>700&&count<=750){
                return 1500
            }else if(count>750&&count<=800){
                return 2000
            }else if(count>800){
                return 3000
            }else{
                return 0
            }
        },
        //申请授权
        apply:function () {
            $(".authorization-info").hide();
            $(".authorization").show();
        },
        checkName:function(that) {
            name=$(".authorization .info .name input").val();
            var valiRegExp = new RegExp("[\u4E00-\u9FA5]{2,5}(?:·[\u4E00-\u9FA5]{2,5})*");
            if(!name){
                common.alert_tip1("真实姓名不能为空");
                flag1=false;
                return false;
            }else if(!valiRegExp.test(name)){
                common.alert_tip1("请输入正确真实姓名！");
                flag1=false;
                return false;
            }
            flag1=true;
            zmxy.submitBthState();
        },
        checkNum:function(that) {
            //检查身份证号码
            num=$(".authorization .info .certificates input").val();
            var valiRegExp1 =/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
            if(!num){
                common.alert_tip1("身份证号码不能为空");
                flag2=false;
                return false;
            }else if(!valiRegExp1.test(num)){
                common.alert_tip1("请输入正确身份证号码！");
                flag2=false;
                return false;
            }
            flag2=true;
            zmxy.submitBthState();
        },
        submitBthState:function() {
            if(flag1&&flag2){
                $(".authorization .submit button").addClass('active');
            }
        },
        submit:function() {
            if($(".authorization .submit button").hasClass('active')){
                var  submitData={
                    name:name,
                    num:num
                };
                //debugger;

                //这里是提交支付宝走支付宝
                location.href='{{url('wechat/index/zmxy/info')}}'+'?name='+name+'&certNo='+num;
            }
        }
    };
</script>
<script>
    $(function () {
        pushHistory();
        window.addEventListener("popstate", function(e) {  //回调函数中实现需要的功能
            location.href="{{url('wechat/user/center')}}";  //在这里指定其返回的地址
        }, false);
    })
    function pushHistory() {
        var state = {
            title: "title",
            url: "{{url('wechat/index/zmxy/index')}}"
        };
        window.history.pushState(state, state.title, state.url);
    }
</script>
</body>
</html>