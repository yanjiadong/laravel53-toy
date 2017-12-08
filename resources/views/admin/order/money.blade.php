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
                                <option value="0" <?php echo (isset($status)&&$status==0)?'selected':'';?>>全部</option>
                                <option value="1" <?php echo (isset($status)&&$status==1)?'selected':'';?>>未申请</option>
                                <option value="-1" <?php echo (isset($status)&&$status==2)?'selected':'';?>>申请中</option>
                                <option value="-3" <?php echo (isset($status)&&$status==3)?'selected':'';?>>申请成功</option>
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
                                <th>支付订单号</th>
                                <th>押金金额</th>
                                <th>逾期天数</th>
                                <th>逾期金额</th>
                                <th>申请提现时间</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody id="lists">
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->out_trade_no }}</td>
                                    <td>{{ $order->money }}</td>
                                    <td>{{ $order->over_days }}</td>
                                    <td>{{ $order->over_days*$order->good_day_price }}</td>
                                    <td>{{ $order->apply_money_time }}</td>
                                    <td>
                                        @if($order->money_status == 0)
                                            未申请
                                        @elseif($order->money_status == 1)
                                            申请中
                                        @else
                                            申请完成
                                        @endif
                                    </td>
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
                    text: "确认寄回？",
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