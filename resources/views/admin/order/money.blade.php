@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">订单管理</a> <span class="divider">></span></li>
            <li class="active"><a href="{{ route('admin.order.money') }}">押金列表</a></li>
        </ul>
        <ul class="buttons">
            <li>
                <a href="javascript:;" class="link_bcPopupSearch"><span class="icon-search"></span><span class="text">押金查询</span></a>
                <form action="{{route('admin.order.money')}}" method="get">
                    <div id="bcPopupSearch" class="popup">
                        <div class="head clearfix">
                            <div class="arrow"></div>
                            <span class="isw-zoom"></span>
                            <span class="name">订单查询</span>
                        </div>
                        <div class="body search row-form">
                            <span>支付订单编号</span>
                            <input type="text" placeholder="订单编号" id="code" name="code" value="<?php echo (isset($code))?$code:'';?>"/>
                        </div>
                        <div class="body search row-form">
                            <span>状态</span>
                            <select name="status">
                                <option value="0" <?php echo (isset($status)&&$status==0)?'selected':'';?>>全部押金</option>
                                <option value="1" <?php echo (isset($status)&&$status==1)?'selected':'';?>>不可提现</option>
                                <option value="2" <?php echo (isset($status)&&$status==2)?'selected':'';?>>可提现</option>
                                <option value="3" <?php echo (isset($status)&&$status==3)?'selected':'';?>>已申请提现</option>
                                <option value="4" <?php echo (isset($status)&&$status==4)?'selected':'';?>>提现成功</option>
                            </select>
                        </div>
                        <div class="footer">
                            <button class="btn" type="submit">查询</button>
                            <button class="btn btn-danger link_bcPopupSearch" type="button">关闭</button>
                        </div>
                    </div>
                </form>
            </li>
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
                    @if(count($orders)>0)
                        <table cellpadding="0" cellspacing="0" width="100%" class="table">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>用户昵称</th>
                                <th>支付订单号</th>
                                <th>押金金额</th>
                                <th>逾期天数</th>
                                <th>应退还押金金额</th>
                                <th width="150px">申请提现时间</th>
                                <th>押金状态</th>
                                <th>订单状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody id="lists">
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->out_trade_no }}</td>
                                    <td>{{ $order->money }}</td>
                                    <td>{{ $order->over_days }}(逾期金额:{{ number_format($order->over_days*$order->good_day_price,2,".",'') }})</td>
                                    <td>{{  number_format($order->money - $order->over_days*$order->good_day_price,2,'.','') }}</td>
                                    <td>{{ $order->apply_money_time }}</td>
                                    <td>
                                        @if($order->money_status == 0 && $order->status == '已归还' && $order->back_status == '已验证')
                                            可提现
                                        @elseif($order->money_status == 1)
                                            <div style="color: red;">已申请提现</div>
                                        @elseif($order->money_status == 2)
                                            <div style="color: green">提现成功</div>
                                        @else
                                            不可提现
                                        @endif
                                    </td>
                                    <td>{{ $order->status }}</td>
                                    <td>
                                        @if($order->money_status==1)
                                            <a href="javascript:;" data-id="{{$order->id}}" title="退还押金" class="tip doAction" data-status="2"><span class="btn btn-mini btn-warning">退还押金</span></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $orders->links() }}
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
                $.confirm({
                    text: "确认已退还押金？",
                    confirm: function(button) {
                        $.post("{{route('admin.order.confirm_money')}}",{id:id},function(data){
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