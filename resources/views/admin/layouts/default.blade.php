<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="yanjiadong|http://yanjiadong.net">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="renderer" content="webkit">
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
    <link href="/admin/assets/css/sticky.full.css" rel="stylesheet" type="text/css" />

    <script type='text/javascript' src="/admin/assets/js/plugins/jquery/jquery-1.10.2.min.js"></script>
    <script type='text/javascript' src="/admin/assets/js/plugins/jquery/jquery-ui-1.10.1.custom.min.js"></script>
    <script type='text/javascript' src="/admin/assets/js/plugins/jquery/jquery-migrate-1.2.1.min.js"></script>
    <script type='text/javascript' src="/admin/assets/js/plugins/jquery/jquery.mousewheel.min.js"></script>

    <script type='text/javascript' src="/admin/assets/js/plugins/cookie/jquery.cookies.2.2.0.min.js"></script>
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
    <script type='text/javascript' src="/admin/assets/js/jquery.confirm.js"></script>
    <script type='text/javascript' src="/admin/assets/js/impromptu.js"></script>
    <script type='text/javascript' src="/admin/assets/js/sticky.full.js"></script>
    <script type='text/javascript' src="/admin/assets/js/cookies.js"></script>
    <script type='text/javascript' src="/admin/assets/js/actions.js"></script>
    <script type='text/javascript' src="/admin/assets/js/plugins.js"></script>
    <script type='text/javascript' src='/admin/assets/js/jquery.tagsinput.min.js'></script>
    <script src="/admin/assets/My97DatePicker/WdatePicker.js"></script>

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
<div class="wrapper">
    {{--@include('admin.shared.message')--}}
    <div class="header">
        <a class="logo" href=""><img src="/admin/assets/img/logo.jpg" alt="{{ config('app.name') }}" title="{{ config('app.name') }}"/></a>
        <ul class="header_menu">
            <li class="list_icon"><a href="#">&nbsp;</a></li>
        </ul>
    </div>

    <div class="menu">

        <div class="breadLine">
            <div class="arrow"></div>
            <div class="adminControl active">
                您好，{{ $username }}
            </div>
        </div>

        <div class="admin" style="display: block;">
            <div class="image">
                <img src="/admin/assets/img/logo2.png" class="img-polaroid"/>
            </div>
            <ul class="control">
                <li><span class="icon-cog"></span><a href="{{ url('admin/setting') }}">设置</a></li>
                <li><span class="icon-share-alt"></span><a href="javascript:;" id="logout">退出</a></li>
                <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </ul>
            <!--
            <div class="info">
                <span>欢迎回来! 你最后一次访问时间: 2014-12-14 19:55:55</span>
            </div>
            -->
        </div>

        <ul class="navigation">

            <li class="<?php echo (isset($menu) && ($menu == 'main')) ? 'active' : '';?>">
                <a href="/admin/main">
                    <span class="isw-user"></span><span class="text">欢迎界面</span>
                </a>
            </li>

            <li class="openable <?php echo (isset($menu) && ($menu == 'order')) ? 'active' : '';?>">
                <a href="javascript:;">
                    <span class="isw-list"></span><span class="text">订单管理</span>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('admin.order.index',['status'=>1]) }}">
                            <span class="icon-th-list"></span><span class="text">待发货订单</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.order.index',['status'=>2]) }}">
                            <span class="icon-th-list"></span><span class="text">已发货订单</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.order.index',['status'=>3]) }}">
                            <span class="icon-th-list"></span><span class="text">租用中订单</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.order.index',['status'=>4]) }}">
                            <span class="icon-th-list"></span><span class="text">已归还订单</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.order.index',['status'=>-1]) }}">
                            <span class="icon-th-list"></span><span class="text">已取消订单</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.order.money') }}">
                            <span class="icon-th-list"></span><span class="text">押金列表</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="openable <?php echo (isset($menu) && ($menu == 'user')) ? 'active' : '';?>">
                <a href="javascript:;">
                    <span class="isw-list"></span><span class="text">用户管理</span>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('admin.user.index') }}">
                            <span class="icon-th-list"></span><span class="text">用户列表</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!--
            <li class="openable <?php echo (isset($menu) && ($menu == 'vip_card_pay')) ? 'active' : '';?>">
                <a href="javascript:;">
                    <span class="isw-list"></span><span class="text">押金管理</span>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('vip_card_pays.index') }}">
                            <span class="icon-th-list"></span><span class="text">押金列表</span>
                        </a>
                    </li>
                </ul>
            </li>
            -->
            <li class="openable <?php echo (isset($menu) && ($menu == 'banner')) ? 'active' : '';?>">
                <a href="javascript:;">
                    <span class="isw-list"></span><span class="text">Banner管理</span>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('banners.index') }}">
                            <span class="icon-th-list"></span><span class="text">Banner列表</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="openable <?php echo (isset($menu) && ($menu == 'category')) ? 'active' : '';?>">
                <a href="javascript:;">
                    <span class="isw-list"></span><span class="text">分类管理</span>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('categorys.index') }}">
                            <span class="icon-th-list"></span><span class="text">分类列表</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="openable <?php echo (isset($menu) && ($menu == 'brand')) ? 'active' : '';?>">
                <a href="javascript:;">
                    <span class="isw-list"></span><span class="text">品牌管理</span>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('brands.index') }}">
                            <span class="icon-th-list"></span><span class="text">品牌列表</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="openable <?php echo (isset($menu) && ($menu == 'tag')) ? 'active' : '';?>">
                <a href="javascript:;">
                    <span class="isw-list"></span><span class="text">标签管理</span>
                </a>
                <ul>
                    {{--<li>
                        <a href="{{ route('category_tags.index') }}">
                            <span class="icon-th-list"></span><span class="text">适合年龄列表</span>
                        </a>
                    </li>--}}
                    <li>
                        <a href="{{ route('tags.index') }}">
                            <span class="icon-th-list"></span><span class="text">玩具标签列表</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="openable <?php echo (isset($menu) && ($menu == 'good')) ? 'active' : '';?>">
                <a href="javascript:;">
                    <span class="isw-list"></span><span class="text">玩具管理</span>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('goods.index') }}">
                            <span class="icon-th-list"></span><span class="text">玩具列表</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="openable <?php echo (isset($menu) && ($menu == 'activity')) ? 'active' : '';?>">
                <a href="javascript:;">
                    <span class="isw-list"></span><span class="text">活动管理</span>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('activitys.index') }}">
                            <span class="icon-th-list"></span><span class="text">活动列表</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="openable <?php echo (isset($menu) && ($menu == 'vip_card')) ? 'active' : '';?>">
                <a href="javascript:;">
                    <span class="isw-list"></span><span class="text">会员卡管理</span>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('vip_cards.index') }}">
                            <span class="icon-th-list"></span><span class="text">会员卡列表</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="openable <?php echo (isset($menu) && ($menu == 'coupon')) ? 'active' : '';?>">
                <a href="javascript:;">
                    <span class="isw-list"></span><span class="text">优惠券管理</span>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('coupons.index') }}">
                            <span class="icon-th-list"></span><span class="text">优惠券列表</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="openable <?php echo (isset($menu) && ($menu == 'dictionary')) ? 'active' : '';?>">
                <a href="javascript:;">
                    <span class="isw-list"></span><span class="text">字典管理</span>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('admin.areas.province') }}">
                            <span class="icon-th-list"></span><span class="text">区域列表</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('expresses.index') }}">
                            <span class="icon-th-list"></span><span class="text">快递公司列表</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.system_config') }}">
                            <span class="icon-th-list"></span><span class="text">系统设置</span>
                        </a>
                    </li>
                    {{--<li>
                        <a href="{{ route('admin.wechat_config') }}">
                            <span class="icon-th-list"></span><span class="text">微信设置</span>
                        </a>
                    </li>--}}
                </ul>
            </li>

            <li class="openable <?php echo (isset($menu) && ($menu == 'crontab')) ? 'active' : '';?>">
                <a href="javascript:;">
                    <span class="isw-list"></span><span class="text">数据管理</span>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('admin.crontabs.index') }}">
                            <span class="icon-th-list"></span><span class="text">脚本列表</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.user_open_times.index') }}">
                            <span class="icon-th-list"></span><span class="text">首页登录时间列表</span>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>

    <div class="content">
        @yield('content')
    </div>
</div>
<script type="text/javascript" src="/admin/assets/js/tip.js"></script>
<script>
    $(document).ready(function(){
        $("#logout").click(function (e) {
            e.preventDefault();

            $("#logout-form").submit();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
</body>
</html>
