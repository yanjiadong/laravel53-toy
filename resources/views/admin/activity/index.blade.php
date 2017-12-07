@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">活动管理</a> <span class="divider">></span></li>
            <li class="active"><a href="{{ route('activitys.index') }}">活动列表</a></li>
        </ul>
    </div>

    <div class="workplace">
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-list"></div>
                    <h1>活动列表</h1>
                    <ul class="buttons">
                        <li>
                            <a href="javascript:;" class="isw-settings"></a>
                            <ul class="dd-list">
                                <li><a href="{{ route('activitys.create') }}"><span class="isw-plus"></span>添加活动</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="block-fluid">
                    @if(count($activitys)>0)
                        <table cellpadding="0" cellspacing="0" width="100%" class="table">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>活动图片</th>
                                <th>活动名称</th>
                                <th>活动链接</th>
                                <th>活动类型</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody id="lists">
                            @foreach ($activitys as $activity)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a class="fancybox" href="{{$activity->picture}}" data-fancybox-group="gallery" title="">
                                            <img src="{{$activity->picture}}" style="margin-top: 10px;height: 80px;width:160px;"/>
                                        </a>
                                    </td>
                                    <td>{{ $activity->title }}</td>
                                    <td>{{ $activity->url }}</td>
                                    <td>
                                        @if($activity->type == 1)
                                            运营活动
                                        @else
                                            新手指南
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url("admin/activitys/$activity->id/edit") }}" title="修改" class="tip"><span class="btn btn-mini">修改</span></a>
                                        <a href="javascript:;" data-id="{{ $activity->id }}" title="删除" class="tip del"><span class="btn btn-mini btn-danger">删除</span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="toolbar bottom-toolbar clearfix">
                            <div class="tac" style="margin: 10px 0px;">
                                亲~，暂无活动列表哦~
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.del').click(function(){
                var id = $(this).attr('data-id');
                var _method = 'DELETE';
                var url = '{{url('admin/activitys')}}' + '/' + id;

                $.confirm({
                    text: "确认删除？",
                    confirm: function(button) {
                        $.post(url,{_method:_method},function(data){
                            cTip(data);
                        }, "json");
                    },
                    confirmButton: "确认",
                    cancelButton: "取消"
                });
            });
        });
    </script>
@endsection