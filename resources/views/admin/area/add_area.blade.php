@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">字典管理</a> <span class="divider">></span></li>
            <li><a href="{{route('admin.areas.province')}}">省份列表</a> <span class="divider">></span></li>
            <li><a href="{{route('admin.areas.city',['fid'=>$city->fid])}}">{{$province->name}}城市列表</a> <span class="divider">></span></li>
            <li><a href="{{route('admin.areas.area',['fid'=>$city->id])}}">{{$city->name}}区列表</a> <span class="divider">></span></li>
            <li class="active">添加区</li>
        </ul>
    </div>

    <div class="workplace">
        <form id="validation" method="post">
            <div class="row-fluid">
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>区信息</h1>
                    </div>
                    <div class="block-fluid">

                        <div class="row-form clearfix">
                            <div class="span3">所在省份：</div>
                            <div class="span9"><input type="text" value="{{$province->name}}" class="validate[required]" id="" disabled/></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">所在城市：</div>
                            <div class="span9"><input type="text" value="{{$city->name}}" class="validate[required]" id="" disabled/></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">区名称：</div>
                            <div class="span9"><input type="text" value="" class="validate[required]" id="name"/></div>
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
                    var name = $("#name").val();
                    var fid = '{{$fid}}';

                    $.post("{{route('admin.areas.store_area')}}",
                        {name:name,fid:fid},
                        function(data){
                            cTip(data);
                        }, "json");
                }
            });

        });
    </script>

@endsection