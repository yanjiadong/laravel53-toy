@extends('admin.layouts.default')
@include('vendor.ueditor.assets')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">字典管理</a> <span class="divider">></span></li>
            <li class="active">微信设置</li>
        </ul>
    </div>

    <div class="workplace">
        <form id="validation" method="post">
            <div class="row-fluid">
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>微信设置</h1>
                    </div>
                    <div class="block-fluid">
                        <div class="row-form clearfix">
                            <div class="span3">关注公众号自动回复：</div>
                            <div class="span9">
                                <!-- 编辑器容器 -->
                                <script id="1" name="content" type="text/plain">
                                    {!! isset($content[0])?$content[0]:'' !!}
                                </script>
                            </div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">寄回地址弹出内容：</div>
                            <div class="span9">
                                <!-- 编辑器容器 -->
                                <script id="2" name="content" type="text/plain">
                                    {!! isset($content[1])?$content[1]:'' !!}
                                </script>
                            </div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">联系客服弹出内容：</div>
                            <div class="span9">
                                <!-- 编辑器容器 -->
                                <script id="3" name="content" type="text/plain">
                                    {!! isset($content[2])?$content[2]:'' !!}
                                </script>
                            </div>
                        </div>

                        <div class="footer tar">
                            <button class="btn" id="submit">保 存</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue1 = UE.getEditor('1',{
            initialFrameHeight:320,
            initialFrameWidth:700,
        });
        ue1.ready(function() {
            ue1.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>

    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue2 = UE.getEditor('2',{
            initialFrameHeight:320,
            initialFrameWidth:700,
        });
        ue2.ready(function() {
            ue2.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>

    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue3 = UE.getEditor('3',{
            initialFrameHeight:320,
            initialFrameWidth:700,
        });
        ue3.ready(function() {
            ue3.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#submit').click(function(e) {
                e.preventDefault();

                if ($("#validation").validationEngine('validate')) {
                    var config = [];

                    var desc1 = ue1.getContent();
                    config.push(desc1);

                    var desc2 = ue2.getContent();
                    config.push(desc2);

                    var desc3 = ue3.getContent();
                    config.push(desc3);

                    $.post("{{route('admin.wechat_config.store')}}",
                        {config:config},
                        function(data){
                            cTip(data);
                        }, "json");
                }
            });

        });
    </script>
@endsection