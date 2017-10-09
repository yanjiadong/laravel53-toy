@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">订单管理</a> <span class="divider">></span></li>
            <li><a href="{{route('admin.order.index')}}">订单列表</a> <span class="divider">></span></li>
            <li class="active">订单详情</li>
        </ul>
    </div>

    <div class="workplace">
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>订单详情</h1>
                </div>
                <div class="block-fluid">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <tbody id="lists">
                        <tr>
                            <td>订单编号：</td>
                            <td>{{$order->code}}</td>
                        </tr>
                        <tr>
                            <td>订单价格：</td>
                            <td>{{$order->price}}元</td>
                        </tr>
                        <tr>
                            <td>包装清理费：</td>
                            <td>{{$order->clean_price}}元</td>
                        </tr>
                        <tr>
                            <td>订单状态：</td>
                            <td>{{$order->status}}</td>
                        </tr>
                        <tr>
                            <td>玩具名称：</td>
                            <td>{{$order->good_title}}</td>
                        </tr>
                        <tr>
                            <td>玩具市场价：</td>
                            <td>{{$order->good_price}}</td>
                        </tr>
                        <tr>
                            <td>玩具分类：</td>
                            <td>{{$order->category->title}}</td>
                        </tr>

                        <tr>
                            <td>下单时间：</td>
                            <td>{{$order->created_at}}</td>
                        </tr>
                        <tr>
                            <td>确认收货时间：</td>
                            <td>{{$order->confirm_time}}</td>
                        </tr>
                        <tr>
                            <td>收货人：</td>
                            <td>{{$order->receiver}}</td>
                        </tr>
                        <tr>
                            <td>收货人电话：</td>
                            <td>{{$order->receiver_telephone}}</td>
                        </tr>
                        <tr>
                            <td>收货地址：</td>
                            <td>{{$order->receiver_address}}</td>
                        </tr>
                        <tr>
                            <td>快递公司：</td>
                            <td>{{$order->express_title}}</td>
                        </tr>
                        <tr>
                            <td>快递单号：</td>
                            <td>{{$order->express_no}}</td>
                        </tr>
                        <tr>
                            <td>邮费：</td>
                            <td>{{$order->express_price}}元</td>
                        </tr>

                        <tr>
                            <td>会员手机号：</td>
                            <td>{{$order->user->telephone}}</td>
                        </tr>



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </form>
    </div>

    <div class="workplace">
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-documents"></div>
                    <h1>回寄信息</h1>
                </div>
                <div class="block-fluid">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <tbody id="lists">

                        @if($order->status=='已归还')
                            <tr>
                                <td>回寄状态：</td>
                                <td>{{$order->back_status}}</td>
                            </tr>
                            <tr>
                                <td>回寄快递公司：</td>
                                <td>{{$order->back_express_title}}</td>
                            </tr>
                            <tr>
                                <td>回寄快递单号：</td>
                                <td>{{$order->back_express_no}}</td>
                            </tr>
                            <tr>
                                <td>回寄时间：</td>
                                <td>{{$order->back_time}}</td>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                    <div class="footer tar">
                        <a href="javascript:;" onclick="window.history.back();"><button class="btn">返 回</button></a>
                        @if($order->status=='已归还' && $order->back_status=='待验证')
                            <a href="javascript:;" data-id="{{$order->id}}" title="验证寄回" class="tip verifyAction"><span class="btn">验证寄回</span></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.verifyAction').click(function(){
                var id = $(this).attr('data-id');
                $.confirm({
                    text: "确认寄回？",
                    confirm: function(button) {
                        $.post("{{route('admin.order.verify')}}",{id:id},function(data){
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