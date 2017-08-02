@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">标签管理</a> <span class="divider">></span></li>
            <li class="active"><a href="{{ route('tags.index') }}">商品标签列表</a></li>
        </ul>
    </div>

    <div class="workplace">
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-list"></div>
                    <h1>商品标签列表</h1>
                    <ul class="buttons">
                        <li>
                            <a href="javascript:;" class="isw-settings"></a>
                            <ul class="dd-list">
                                <li><a href="{{ route('tags.create') }}"><span class="isw-plus"></span>添加标签</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="block-fluid">
                    @if(count($tags)>0)
                        <table cellpadding="0" cellspacing="0" width="100%" class="table">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>标签名称</th>
                                <th>标签简介</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody id="lists">
                                @foreach ($tags as $tag)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tag->title }}</td>
                                    <td>{{ $tag->desc }}</td>
                                    <td>

                                        <a href="{{ url("admin/tags/$tag->id/edit") }}" title="修改" class="tip"><span class="btn btn-mini">修改</span></a>
                                        <a href="javascript:;" data-id="{{ $tag->id }}" title="删除" class="tip del"><span class="btn btn-mini btn-danger">删除</span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="toolbar bottom-toolbar clearfix">
                            <div class="tac" style="margin: 10px 0px;">
                                亲~，暂无标签列表哦~
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
                var url = '{{url('admin/tags')}}' + '/' + id;

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