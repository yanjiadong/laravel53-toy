@extends('admin.layouts.default')

@section('content')
<div class="breadLine">
    <ul class="breadcrumb">
        <li><a href="javascript:;">字典管理</a> <span class="divider">></span></li>
        <li class="active">省份列表</li>
    </ul>
</div>

<div class="workplace">
    <div class="row-fluid">
        <div class="span12">
            <div class="head clearfix">
                <div class="isw-list"></div>
                <h1>省份列表</h1>
                <ul class="buttons">
                    <li>
                        <a href="javascript:;" class="isw-settings"></a>
                        <ul class="dd-list">
                            <li><a href="{{route('admin.areas.add_province')}}"><span class="isw-plus"></span> 添加省份</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="block-fluid">
                @if(count($provinces)>0)
                <table cellpadding="0" cellspacing="0" width="100%" class="table">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>省份</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody id="lists">
                    @foreach($provinces as $province)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $province->name }}</td>
                            <td>
                                <a href="{{route('admin.areas.edit_province',['id'=>$province->id])}}" title="修改" class="tip"><span class="btn btn-mini">修改</span></a>
                                <a href="{{route('admin.areas.city',['fid'=>$province->id])}}" title="查看城市" class="tip"><span class="btn btn-mini">查看城市</span></a>
                                <a href="javascript:;" title="删除" class="tip delete" data-id="{{$province->id}}"><span class="btn btn-mini btn-danger">删除</span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @else
                    <div class="toolbar bottom-toolbar clearfix">
                        <div class="tac" style="margin: 10px 0px;">
                            亲~，您还没有省份列表哦~
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.delete').click(function(){
            var id = $(this).attr('data-id');

            $.confirm({
                text: "确认删除？",
                confirm: function(button) {
                    $.post("{{route('admin.areas.del_province')}}",{id:id},function(data){
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