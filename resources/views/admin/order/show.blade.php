@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">订单管理</a> <span class="divider">></span></li>
            <li><a href="javascript:;" onclick="window.history.back();">订单列表</a> <span class="divider">></span></li>
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
                            <td>订单状态：</td>
                            <td>{{$order->status}}</td>
                        </tr>
                        <tr>
                            <td>租用天数：</td>
                            <td>{{$order->days}}(¥{{ $order->good_day_price }}/天)</td>
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
                            <td>{{$order->receiver_province}} {{$order->receiver_city}} {{$order->receiver_area}} {{$order->receiver_address}}</td>
                        </tr>
                        <tr>
                            <td>快递公司：</td>
                            <td>
                                <select name="select" class="" id="express_id">
                                    <option value="0">--请选择--</option>
                                    @if(count($express)>0)
                                        @foreach($express as $v)
                                            <option value="{{$v->id}}" {{$v->com==$order->express_com?'selected':''}}>{{$v->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>快递单号：</td>
                            <td>
                                <input type="text" value="{{$order->express_no}}" class="validate[required]" id="express_no" name="express_no"/>
                            </td>
                        </tr>
                        <tr>
                            <td>发货时间：</td>
                            <td>
                                <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',errDealMode:2})" placeholder="发货时间" class="form-control validate[required,custom[date]]" id="send_time" name="send_time"  value="{{$order->send_time?$order->send_time:''}}">
                            </td>
                        </tr>
                        <tr>
                            <td>邮费：</td>
                            <td>{{$order->express_price}}元</td>
                        </tr>

                        <tr>
                            <td>会员手机号：</td>
                            <td>{{$order->user->telephone}}</td>
                        </tr>
                        <tr>
                            <td>租期开始时间：</td>
                            <td>
                                <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',errDealMode:2})" placeholder="开始时间" class="form-control validate[required,custom[date]]" id="start_time" name="start_time"  value="{{$order->start_time?$order->start_time:''}}">
                            </td>
                        </tr>
                        <tr>
                            <td>租期结束时间：</td>
                            <td>
                                <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',errDealMode:2})" placeholder="结束时间" class="form-control validate[required,custom[date]]" id="end_time" name="end_time"  value="{{$order->end_time?$order->end_time:''}}">
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="footer tar">
                        @if($order->status == '已发货')
                            <a href="javascript:;" title="修改物流" class="tip sendEdit"><span class="btn btn-warning">修改物流</span></a>
                        @endif

                        @if($order->status == '租用中')
                            <a href="javascript:;" title="修改订单" class="tip editOrder"><span class="btn btn-warning">修改订单</span></a>
                        @endif
                    </div>
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

            $(".sendEdit").click(function(){
                var id = '{{$order->id}}';
                var express_no = $("#express_no").val();
                var express_id = $("#express_id").val();
                var send_time = $("#send_time").val();
                if (!express_no) {
                    eAlert('请输入快递单号');
                    return false;
                }

                $.post("{{route('admin.order.send')}}", {type:2,id:id,express_no:express_no,express_id:express_id,send_time:send_time}, function(data){
                    cTip(data);
                }, "json");
            });

            $(".editOrder").click(function(){
                var id = '{{$order->id}}';
                var start_time = $("#start_time").val();
                var end_time = $("#end_time").val();

                $.post("{{route('admin.order.update')}}", {id:id,start_time:start_time,end_time:end_time}, function(data){
                    cTip(data);
                }, "json");
            });
        });
    </script>
@endsection