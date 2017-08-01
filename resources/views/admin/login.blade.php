<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="yanjiadong|http://yanjiadong.net">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <!--[if gt IE 8]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <![endif]-->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link rel="icon" type="image/ico" href="/admin/assets/img/favicon.ico"/>

    <link href="/admin/assets/css/stylesheets.css" rel="stylesheet" type="text/css" />
    <!--[if lt IE 8]>
    <link href="/admin/assets/css/ie7.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <link href="/admin/assets/css/impromptu.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div class="loginBlock" id="login" style="display: block;">
    <h1>欢迎您，请登录！</h1>
    <div class="dr"><span></span></div>
    <div class="loginForm">
        <form class="form-horizontal" method="POST" id="validation">
            <div class="control-group">
                <div class="input-prepend">
                    <span class="add-on"><span class="icon-user"></span></span>
                    <input type="text" id="username" placeholder="用户名" class="validate[required]"/>
                </div>
            </div>
            <div class="control-group">
                <div class="input-prepend">
                    <span class="add-on"><span class="icon-lock"></span></span>
                    <input type="password" id="pwd" placeholder="密码" class="validate[required,minSize[6]]"/>
                </div>
            </div>
            <div class="control-group">
                <div class="input-prepend">
                    <span class="add-on"><span class="icon-qrcode"></span></span>
                    <input type="text" id="captcha" placeholder="验证码" class="validate[required,minSize[4],maxSize[4]]" style="width:125px;;"/>
                    <a href="javascript:void(0);" class="refreshCaptcha" style="margin-left:10px;"><img src="{{ url('admin/login/captcha/1') }}" /></a>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span8">
                    <!--
                    <div class="control-group" style="margin-top: 5px;">
                        <label class="checkbox"><input type="checkbox"> Remember me</label>
                    </div>
                    -->
                </div>
                <div class="span4">
                    <button id="submit" class="btn btn-block">登 录</button>
                </div>
            </div>
        </form>
        <!--
        <div class="dr"><span></span></div>
        <div class="controls">
            <div class="row-fluid">
                <div class="span6">
                    <button class="btn btn-link btn-block" onClick="loginBlock('#forgot');">忘记密码?</button>
                </div>
                <div class="span2"></div>
            </div>
        </div>
        -->
    </div>
</div>

<script type='text/javascript' src="/admin/assets/js/plugins/jquery/jquery-1.10.2.min.js"></script>
<script type='text/javascript' src="/admin/assets/js/plugins/jquery/jquery-ui-1.10.1.custom.min.js"></script>
<script type='text/javascript' src="/admin/assets/js/plugins/jquery/jquery-migrate-1.2.1.min.js"></script>
<script type='text/javascript' src="/admin/assets/js/plugins/jquery/jquery.mousewheel.min.js"></script>
<script type='text/javascript' src="/admin/assets/js/plugins/bootstrap.min.js"></script>

<script type='text/javascript' src="/admin/assets/js/plugins/sparklines/jquery.sparkline.min.js"></script>

<script type='text/javascript' src="/admin/assets/js/plugins/fullcalendar/fullcalendar.min.js"></script>

<script type='text/javascript' src="/admin/assets/js/plugins/select2/select2.min.js"></script>

<script type='text/javascript' src="/admin/assets/js/plugins/uniform/uniform.js"></script>

<script type='text/javascript' src="/admin/assets/js/plugins/maskedinput/jquery.maskedinput-1.3.min.js"></script>

<script type='text/javascript' src="/admin/assets/js/plugins/validation/languages/jquery.validationEngine-zh_CN.js" charset='utf-8'></script>
<script type='text/javascript' src="/admin/assets/js/plugins/validation/jquery.validationEngine.js" charset='utf-8'></script>

<script type='text/javascript' src="/admin/assets/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
<script type='text/javascript' src="/admin/assets/js/plugins/animatedprogressbar/animated_progressbar.js"></script>

<script type='text/javascript' src="/admin/assets/js/plugins/qtip/jquery.qtip-1.0.0-rc3.min.js"></script>

<script type='text/javascript' src="/admin/assets/js/plugins/cleditor/jquery.cleditor.js"></script>

<script type='text/javascript' src="/admin/assets/js/plugins/dataTables/jquery.dataTables.min.js"></script>

<script type='text/javascript' src="/admin/assets/js/plugins/fancybox/jquery.fancybox.pack.js"></script>

<script type='text/javascript' src="/admin/assets/js/plugins/pnotify/jquery.pnotify.min.js"></script>
<script type='text/javascript' src="/admin/assets/js/plugins/ibutton/jquery.ibutton.min.js"></script>

<script type='text/javascript' src="/admin/assets/js/plugins/scrollup/jquery.scrollUp.min.js"></script>
<script type='text/javascript' src="/admin/assets/js/impromptu.js"></script>

<script type='text/javascript' src="/admin/assets/js/actions.js"></script>
<script type='text/javascript' src="/admin/assets/js/plugins.js"></script>

<script>
    $(document).ready(function(){
        $(".refreshCaptcha").click(function(){
            $(this).find('img').attr('src',"{{ url('admin/login/captcha') }}/"+ Math.random());
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#submit').click(function(e) {
            e.preventDefault();

            if ($("#validation").validationEngine('validate')) {
                var username = $("#username").val();
                var pwd = $("#pwd").val();
                var captcha = $("#captcha").val();
                $.post("/admin/login",{username:username,password:pwd,captcha:captcha},function(data){
                    if (data.code == 200) {
                        if (data.url) {
                            window.location.href=data.url;
                        } else {
                            window.location.reload();
                        }
                    } else {
                        $.prompt(data.message, {
                            buttons: { "确定": true }
                        });

                        $(".refreshCaptcha").find('img').attr('src',"{{ url('admin/login/captcha') }}/"+ Math.random());
                    }

                }, "json");
            }
        });
    })
</script>
</body>
</html>
