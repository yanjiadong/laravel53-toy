@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">玩具管理</a> <span class="divider">></span></li>
            <li class="active"><a href="{{ route('goods.index') }}">玩具列表</a></li>
        </ul>
    </div>

    <div class="workplace">
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-list"></div>
                    <h1>玩具列表</h1>
                    <ul class="buttons">
                        <li>
                            <a href="javascript:;" class="isw-settings"></a>
                            <ul class="dd-list">
                                <li><a href="{{ route('goods.create') }}"><span class="isw-plus"></span>添加商品</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="block-fluid">
                    @if(count($goods)>0)
                        <table cellpadding="0" cellspacing="0" width="100%" class="table">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>玩具名称</th>
                                <th>分类名称</th>
                                <th>适合年龄</th>
                                <th>库存</th>
                                <th>新品抢先</th>
                                <th>热门推荐</th>
                                <th>状态</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody id="lists">
                                @foreach ($goods as $good)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $good->title }}</td>
                                    <td>{{ $good->category->title }}</td>
                                    <td>{{ $good->category_tag->title }}</td>
                                    <td>{{ $good->store }}</td>
                                    <td>{{ $good->is_new==1?'是':'否' }}</td>
                                    <td>{{ $good->is_hot==1?'是':'否' }}</td>
                                    <td>{{ $good->status==\App\Good::STATUS_ON_SALE?'上架':'下架' }}</td>
                                    <td>{{ $good->created_at }}</td>
                                    <td>
                                        <a href="{{ url("admin/goods/$good->id/edit") }}" title="修改" class="tip"><span class="btn btn-mini">修改</span></a>
                                        @if($good->status==\App\Good::STATUS_ON_SALE)
                                            <a href="javascript:;" data-id="{{ $good->id }}" title="下架玩具" class="tip action" status="2"><span class="btn btn-mini btn-warning">下架玩具</span></a>
                                        @else
                                            <a href="javascript:;" data-id="{{ $good->id }}" title="上架玩具" class="tip action" status="1"><span class="btn btn-mini btn-info">上架玩具</span></a>
                                        @endif
                                        <a href="javascript:;" data-id="{{ $good->id }}" title="删除" class="tip del"><span class="btn btn-mini btn-danger">删除</span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="toolbar bottom-toolbar clearfix">
                            <div class="tac" style="margin: 10px 0px;">
                                亲~，暂无玩具列表哦~
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
                var url = '{{url('admin/goods')}}' + '/' + id;

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

            $('.action').click(function(){
                var id = $(this).attr('data-id');
                var status = $(this).attr('status');
                $.confirm({

                    text: status==1?"确认上架玩具?":"确认下架玩具?",
                    confirm: function(button) {
                        $.post("{{route('goods.action')}}",{id:id,status:status},function(data){
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