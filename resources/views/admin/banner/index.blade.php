@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">Banner管理</a> <span class="divider">></span></li>
            <li class="active"><a href="{{ route('banners.index') }}">Banner列表</a></li>
        </ul>
    </div>

    <div class="workplace">
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-list"></div>
                    <h1>Banner列表</h1>
                    <ul class="buttons">
                        <li>
                            <a href="javascript:;" class="isw-settings"></a>
                            <ul class="dd-list">
                                <li><a href="{{ route('banners.create') }}"><span class="isw-plus"></span>添加Banner</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="block-fluid">
                    @if(count($banners)>0)
                        <table cellpadding="0" cellspacing="0" width="100%" class="table">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>Banner图片</th>
                                <th>简介</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody id="lists">
                                @foreach ($banners as $banner)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a class="fancybox" href="{{$banner->picture}}" data-fancybox-group="gallery" title="">
                                            <img src="{{$banner->picture}}" style="margin-top: 10px;height: 80px;width:160px;"/>
                                        </a>
                                    </td>
                                    <td>{{ $banner->intro }}</td>
                                    <td>
                                        <a href="{{ url("admin/banners/$banner->id/edit") }}" title="修改" class="tip"><span class="btn btn-mini">修改</span></a>
                                        <a href="javascript:;" data-id="{{ $banner->id }}" title="删除" class="tip del"><span class="btn btn-mini btn-danger">删除</span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="toolbar bottom-toolbar clearfix">
                            <div class="tac" style="margin: 10px 0px;">
                                亲~，暂无Banner列表哦~
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
                var url = '{{url('admin/banners')}}' + '/' + id;

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