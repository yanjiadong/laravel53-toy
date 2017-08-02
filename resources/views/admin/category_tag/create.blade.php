@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">标签管理</a> <span class="divider">></span></li>
            <li><a href="{{ route('category_tags.index') }}">适合年龄列表</a> <span class="divider">></span></li>
            <li class="active">添加适合年龄</li>
        </ul>
    </div>

    <div class="workplace">
        <form id="validation" method="post">
            <div class="row-fluid">
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>适合年龄信息</h1>
                    </div>
                    <div class="block-fluid">
                        <div class="row-form clearfix">
                            <div class="span3">适合年龄名称：</div>
                            <div class="span9">
                                <input type="text" value="" class="validate[required]" id="title" name="title"/>
                            </div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">所属分类：</div>
                            <div class="span9">
                                <select name="select" class="validate[required]" id="category_id">
                                    <option value="0">--请选择--</option>
                                    @if(count($categorys))
                                        @foreach($categorys as $category)
                                            <option value="{{$category->id}}">{{$category->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
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
                    var category_id = $("#category_id").val();

                    $.post("{{ route('category_tags.store') }}",
                        {title:title,category_id:category_id},
                        function(data){
                            cTip(data);
                        }, "json");
                }
            });

        });
    </script>
@endsection