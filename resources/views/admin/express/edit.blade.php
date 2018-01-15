@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">字典管理</a> <span class="divider">></span></li>
            <li><a href="{{ route('expresses.index') }}"> 快递公司列表</a> <span class="divider">></span></li>
            <li class="active">修改快递公司</li>
        </ul>
    </div>

    <div class="workplace">
        <form id="validation" method="post">
            <div class="row-fluid">
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>快递公司信息</h1>
                    </div>
                    <div class="block-fluid">
                        <div class="row-form clearfix">
                            <div class="span3">快递公司名称：</div>
                            <div class="span9">
                                <input type="text" value="{{$express->title}}" class="validate[required]" id="title" name="title"/>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">快递公司编码：</div>
                            <div class="span9">
                                <input type="text" value="{{$express->com}}" class="validate[required]" id="com" name="com"/>
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
                    var com = $("#com").val();
                    var _method = 'PUT';

                    $.post("{{route('expresses.update',['id'=>$express->id])}}",
                        {title:title,com:com,_method:_method},
                        function(data){
                            cTip(data);
                        }, "json");
                }
            });

        });
    </script>
@endsection