@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">字典管理</a> <span class="divider">></span></li>
            <li class="active"><a href="{{ route('expresses.index') }}">快递公司列表</a></li>
        </ul>
    </div>

    <div class="workplace">
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-list"></div>
                    <h1>快递公司列表</h1>
                    <ul class="buttons">
                        <li>
                            <a href="javascript:;" class="isw-settings"></a>
                            <ul class="dd-list">
                                <li><a href="{{ route('expresses.create') }}"><span class="isw-plus"></span>添加快递公司</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="block-fluid">
                    @if(count($expresses)>0)
                        <table cellpadding="0" cellspacing="0" width="100%" class="table">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>快递公司名称</th>
                                <th>快递100编码</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody id="lists">
                            @foreach ($expresses as $express)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $express->title }}</td>
                                    <td>{{ $express->com }}</td>
                                    <td>
                                        <a href="{{ url("admin/expresses/$express->id/edit") }}" title="修改" class="tip"><span class="btn btn-mini">修改</span></a>
                                        <a href="javascript:;" data-id="{{ $express->id }}" title="删除" class="tip del"><span class="btn btn-mini btn-danger">删除</span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="toolbar bottom-toolbar clearfix">
                            <div class="tac" style="margin: 10px 0px;">
                                亲~，暂无快递公司列表哦~
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
                var url = '{{url('admin/expresses')}}' + '/' + id;

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