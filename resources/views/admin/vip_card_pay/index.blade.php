@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">押金管理</a> <span class="divider">></span></li>
            <li class="active"><a href="{{ route('vip_card_pays.index') }}">押金列表</a></li>
        </ul>
    </div>

    <div class="workplace">
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-list"></div>
                    <h1>押金列表</h1>
                    <ul class="buttons">
                        <li>
                            <a href="javascript:;" class="isw-settings"></a>
                        </li>
                    </ul>
                </div>
                <div class="block-fluid">
                    @if(count($users)>0)
                        <table cellpadding="0" cellspacing="0" width="100%" class="table">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>支付订单号</th>
                                <th>会员昵称</th>
                                <th>押金</th>
                                <th>剩余天数</th>
                                <th>优惠金额</th>
                                <th>会员卡类型</th>
                                <th>状态</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody id="lists">
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$user->order_code}}</td>
                                    <td>{{$user->user->wechat_nickname}}</td>
                                    <td>{{$user->money}}</td>
                                    <td>{{$user->days}}</td>
                                    <td>{{$user->coupon_price}}</td>
                                    <td>
                                        @if($user->vip_card_type == 1)
                                            月卡
                                        @elseif($user->vip_card_type == 1)
                                            季度卡
                                        @else
                                            半年卡
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->status == 1)
                                            正常
                                        @elseif($user->status == -1)
                                            已过期
                                        @elseif($user->status == -2)
                                            <span style="color: red;">申请提现</span>
                                        @else
                                            <span style="color: blue;">提现成功</span>
                                        @endif
                                    </td>
                                    <td>{{$user->created_at}}</td>
                                    <td>
                                        @if($user->status==-2)
                                            <a href="javascript:;" data-id="{{$user->id}}" title="退还押金" class="tip doAction" data-status="-3"><span class="btn btn-mini btn-warning">退还押金</span></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $users->links() }}
                    @else
                        <div class="toolbar bottom-toolbar clearfix">
                            <div class="tac" style="margin: 10px 0px;">
                                亲~，暂无押金列表哦~
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.doAction').click(function(){
                var id = $(this).attr('data-id');
                var status = $(this).attr('data-status');
                $.confirm({
                    text: "确认操作？",
                    confirm: function(button) {
                        $.post("{{route('admin.vip_card_pay.action')}}",{id:id,status:status},function(data){
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