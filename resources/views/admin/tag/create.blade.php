@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">标签管理</a> <span class="divider">></span></li>
            <li><a href="{{ route('tags.index') }}">玩具标签列表</a> <span class="divider">></span></li>
            <li class="active">添加玩具标签</li>
        </ul>
    </div>

    <div class="workplace">
        <form id="validation" method="post">
            <div class="row-fluid">
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>标签信息</h1>
                    </div>
                    <div class="block-fluid">
                        <div class="row-form clearfix">
                            <div class="span3">标签名称：</div>
                            <div class="span9">
                                <input type="text" value="" class="validate[required]" id="title" name="title"/>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">标签简介：</div>
                            <div class="span9">
                                <input type="text" value="" class="validate[required]" id="desc" name="desc"/>
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('#submit').click(function(e) {
                e.preventDefault();

                if ($("#validation").validationEngine('validate')) {
                    var title = $("#title").val();
                    var desc = $("#desc").val();

                    $.post("{{ route('tags.store') }}",
                        {title:title,desc:desc},
                        function(data){
                            cTip(data);
                        }, "json");
                }
            });

        });
    </script>
@endsection