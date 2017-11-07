var common = {
    /*获取购物车数量 订单数量*/
    getCarAndOrder:function (url,user_id) {
        //获取购物车数量
        //debugger
        var num,order_num;
        /*common.httpRequest('http://toy.yanjiadong.net/api/user/get_cart_order_num','post',{user_id:user_id},function (res) {*/
        common.httpRequest(url,'post',{user_id:user_id},function (res) {
        //假数据
            /*res={
                info:{
                    cart_num:3,
                    order_num:3
                }
            };*/
            //console.log(res);
            num = res.info.cart_num;
            order_num = res.info.order_num;
            localStorage.shop_car_num = num;
            localStorage.order_num = order_num;
            //确定ul的长度
            var wid=0;
            var $li =$('.index-nav .nav li');
            if($li.length>0){
                for(var i=0;i<$li.length;i++){
                    wid +=$($li[i]).outerWidth();
                }
                $('.index-nav .nav').width(wid+'px');
            }
            /*底部购物车 订单赋值*/
            if($('.icon-footer-shop-car').length>0) {
                if (localStorage.shop_car_num > 0) {
                    $('.icon-footer-shop-car').html('<span>' + localStorage.shop_car_num + '</span>');
                } else {
                    $('.icon-footer-shop-car').html('');
                }
            }
            if($(".icon-footer-order").length>0){
                if(localStorage.order_num > 0) {
                    $('.icon-footer-order').html('<span>'+localStorage.order_num+'</span>');
                }else
                {
                    $('.icon-footer-order').html('');
                }
            }
            alert('order_num'+localStorage.order_num);
            alert('shop_car_num'+localStorage.shop_car_num);
        });
        /*底部购物车 订单赋值*/
        if($('.icon-footer-shop-car').length>0) {
            if (localStorage.shop_car_num > 0) {
                $('.icon-footer-shop-car').html('<span>' + localStorage.shop_car_num + '</span>');
            } else {
                $('.icon-footer-shop-car').html('');
            }
        }
        if($(".icon-footer-order").length>0){
            if(localStorage.order_num > 0) {
                $('.icon-footer-order').html('<span>'+localStorage.order_num+'</span>');
            }else
            {
                $('.icon-footer-order').html('');
            }
        }
    },

    /*确认框*/
    confirm_tip:function (title,msg,call1,call2,btn2_name) {
        if(btn2_name){
            var tip_content = '<div class="confirm-alert-wrap"><div class="confirm-alert-main"> <div class="confirm-content"><h4 class="title">'+
                title+'</h4>'+'<div class="cont">'+msg+'</div></div><div class="confirm-btn-wrap clear">' +
                '<button class="confirm-btn-cancel fl">取消</button>' +
                '<button class="confirm-btn-ensure fr">'+btn2_name+'</button></div> </div></div>';
        }else{
            var tip_content = '<div class="confirm-alert-wrap"><div class="confirm-alert-main"> <div class="confirm-content"><h4 class="title">'+
                title+'</h4>'+'<div class="cont">'+msg+'</div></div><div class="confirm-btn-wrap clear">' +
                '<button class="confirm-btn-cancel fl">取消</button>' +
                '<button class="confirm-btn-ensure fr">确定</button></div> </div></div>';
        }
        $("body").append(tip_content);
        $(".confirm-alert-wrap .confirm-alert-main").css({"top": "0","opacity": 0});
        $(".confirm-alert-wrap .confirm-alert-main").animate({ "opacity": 1, "top": "50%" }, 500);
        $(".confirm-btn-cancel").click(function(){
            if(call1){
                call1();
            }else{
                $(".confirm-alert-wrap").remove();

            }
        });
       $(".confirm-btn-ensure").click(function () {
           if(call2){
               call2()
           }else{
               $(".confirm-alert-wrap").remove();
           }
       })
    },

    //提示框
    alert_tip:function (msg,color,title,call,btn_name){
        if(!title){
            title = "提示";
        }
        var tip_content = '<div class="tips-alert-wrap"><div class="tips-alert-main"> <div class="confirm-content"><h4 class="title">'+
            title+ '</h4>'+'<div class="cont">'+msg+'</div></div><div class="confirm-btn-wrap clear">' +
            '<button class="tips-btn-ensure">'+(btn_name?btn_name:'确定')+'</button></div> </div></div>';
        $("body").append(tip_content);
        $(".tips-alert-wrap .tips-alert-main").css({"top": "0","opacity": 0});
        $(".tips-alert-wrap .tips-alert-main").animate({ "opacity": 1, "top": "50%" }, 500);
        if(color){
            $(".tips-alert-wrap .cont").css("color",color);
        }
        $(".tips-btn-ensure").click(function(){
            if(call){
                call();
            }else{
                $(".tips-alert-wrap").remove();
            }
        });
    },

    //提示框
    alert_tip1:function (msg,color,title,call){
        var tip_content='<div class="success-tip-wrap">'+msg+'</div>';
        $('body').append(tip_content);
        $(".success-tip-wrap").css({'bottom':'50%'}).fadeIn();
        setTimeout(function () {
            $(".success-tip-wrap").fadeOut().remove();
        },1000)
    },
    //成功提示
    success_tip:function (msg) {
       var tip_content='<div class="success-tip-wrap">'+msg+'</div>';
       $('body').append(tip_content);
        $(".success-tip-wrap").css({'bottom':'50%'}).fadeIn(1000);
        setTimeout(function () {
            $(".success-tip-wrap").fadeOut().remove();
        },1000)
    },
    //失败提示
    fail_tip:function (msg) {
        var tip_content='<div class="success-tip-wrap">'+msg+'</div>';
        $('body').append(tip_content);
        $(".success-tip-wrap").css({'bottom':'50%'}).fadeIn(1000);
        setTimeout(function () {
            $(".success-tip-wrap").fadeOut().remove();
        },2000)
    },
    /*请求数据url 接口  type为请求类型 data向后端数据 successCall请求后回调*/
    httpRequest:function (url,type,data,successCall) {
        $.ajax({
            type: type,
            url: url,
            data:data,
            success: function (response) {
                successCall(response);
            },
            error: function (response) {
                console.log(response);
            }
        })
    },

    /*底部菜单*/
   /* footer:function (parentClass,num,shop_num) {
        if(shop_num){
            var footcont ='<footer><table><tr><td class="active"><a href="/view/index.html"><div>' +
                '<i class="icon-footer-home"></i></div><div class="font">首页</div></a></td><td> ' +
                '<a href="/view/lease_order.html"><div><i class="icon-footer-order"></i></div><div class="font">订单</div></a> ' +
                '</td><td><a href="/view/toys_car.html"><div><i class="icon-footer-shop-car"><span>'+shop_num+'</span></i></div><div class="font">玩具箱</div>' +
                '</a></td><td><a href="/view/user_center.html"><div><i class="icon-footer-user-center"></i></div><div class="font">我的</div>' +
                '</a></td></tr></table></footer>';
        }else{
            var footcont ='<footer><table><tr><td class="active"><a href="/view/index.html"><div>' +
                '<i class="icon-footer-home"></i></div><div class="font">首页</div></a></td><td> ' +
                '<a href=""><div><i class="icon-footer-order"></i></div><div class="font">订单</div></a> ' +
                '</td><td><a href="/view/toys_car.html"><div><i class="icon-footer-shop-car"></i></div><div class="font">玩具箱</div>' +
                '</a></td><td><a href="/view/user_center.html"><div><i class="icon-footer-user-center"></i></div><div class="font">我的</div>' +
                '</a></td></tr></table></footer>';
        }
        $(footcont).appendTo("."+parentClass);
        if(num){
            $("."+parentClass+" footer td").removeClass('active');
            $("."+parentClass+" footer td").eq(num-1).addClass('active');
        }
    },*/
    setCookie: function (name, value, minutes) {
        //var Days = 30;
        minutes = minutes || 43200;
        var exp = new Date();
        exp.setTime(exp.getTime() + minutes * 60 * 1000);
        document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString() + ";path=/";
    },
    getCookie: function (name) {
        var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
        if (arr = document.cookie.match(reg))
            return unescape(arr[2]);
        else
            return null;
    },
    delCookie: function (name) {
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval = this.getCookie(name);
        if (cval != null)
            document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString() + ";path=/";
    },
    getParam: function (name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) return decodeURI(r[2]); return "";
    },
    dateFormat:function (nS) {
        nS = parseInt(nS);
        var time = new Date(nS);
        var date_cont =(time.getFullYear())+'-'+(time.getMonth()+1)+'-'+(time.getDate())+' '+time.getHours()+':'+time.getMinutes();
        return date_cont;
    },
    dateFormat1:function (nS) {
        nS = parseInt(nS);
        var time = new Date(nS);
        var date_cont =(time.getFullYear())+'-'+(time.getMonth()+1)+'-'+(time.getDate())+' '+time.getHours()+':'+time.getMinutes()+':'+time.getSeconds();
        return date_cont;
    }

};
var checkInput = {
    phone: function (phone) {
        var regex = /^1[3|4|5|7|8]\d{9}$/;
        return regex.test(phone);
    }
};
