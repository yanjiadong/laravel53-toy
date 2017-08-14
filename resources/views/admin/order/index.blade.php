@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">订单管理</a> <span class="divider">></span></li>
            <li class="active"><a href="{{ route('admin.order.index') }}">订单列表</a></li>
        </ul>
    </div>

    <div class="workplace">
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-list"></div>
                    <h1>订单列表</h1>
                    <ul class="buttons">
                        <li>
                            <a href="javascript:;" class="isw-settings"></a>
                        </li>
                    </ul>
                </div>
                <div class="block-fluid">
                    @if(count($orders)>0)
                        <table cellpadding="0" cellspacing="0" width="100%" class="table">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>订单编号</th>
                                <th>订单状态</th>
                                <th>订单价格</th>
                                <th>玩具名称</th>
                                <th>邮费</th>
                                <th>快递公司</th>
                                <th>会员手机号</th>
                                <th>会员微信昵称</th>
                                <th>回寄状态</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody id="lists">
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->code }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $order->price }}</td>
                                    <td>{{ $order->good_title }}</td>
                                    <td>{{ $order->express_price }}</td>
                                    <td>{{ $order->express_title }}</td>
                                    <td>{{ $order->user->telephone }}</td>
                                    <td>{{ $order->user->wechat_nickname }}</td>
                                    <td>{{ $order->status=='已归还'?$order->back_status:'' }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $orders->links() }}
                    @else
                        <div class="toolbar bottom-toolbar clearfix">
                            <div class="tac" style="margin: 10px 0px;">
                                亲~，暂无订单列表哦~
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
                var url = '{{url('admin/categorys')}}' + '/' + id;

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