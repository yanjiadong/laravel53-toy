@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">订单管理</a> <span class="divider">></span></li>
            <li class="active"><a href="{{ route('admin.order.index') }}">订单列表</a></li>
        </ul>
        <ul class="buttons">
            <li>
                <a href="javascript:;" class="link_bcPopupSearch"><span class="icon-search"></span><span class="text">订单查询</span></a>
                <form action="{{route('admin.order.index')}}" method="get">
                    <div id="bcPopupSearch" class="popup">
                        <div class="head clearfix">
                            <div class="arrow"></div>
                            <span class="isw-zoom"></span>
                            <span class="name">订单查询</span>
                        </div>
                        <div class="body search row-form">
                            <span>订单编号</span>
                            <input type="text" placeholder="订单编号" id="code" name="code" value="<?php echo (isset($code))?$code:'';?>"/>
                        </div>
                        <div class="body search row-form">
                            <span>状态</span>
                            <select name="status">
                                <option value="0" <?php echo (isset($status)&&$status==0)?'selected':'';?>>全部</option>
                                <option value="1" <?php echo (isset($status)&&$status==1)?'selected':'';?>>待发货</option>
                                <option value="2" <?php echo (isset($status)&&$status==2)?'selected':'';?>>已发货</option>
                                <option value="3" <?php echo (isset($status)&&$status==3)?'selected':'';?>>租用中</option>
                                <option value="4" <?php echo (isset($status)&&$status==4)?'selected':'';?>>已归还</option>
                                <option value="-1" <?php echo (isset($status)&&$status==-1)?'selected':'';?>>已取消</option>
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
                                        <a href="{{route('admin.order.show',['id'=>$order->id])}}" title="查看" class="tip"><span class="btn btn-mini">查看</span></a>
                                        @if($order->status=='待发货')
                                            <a href="javascript:;" data-id="{{$order->id}}" title="发货" class="tip send"><span class="btn btn-mini btn-warning">发货</span></a>
                                            <a href="javascript:;" data-id="{{$order->id}}" title="取消订单" class="tip cancelAction"><span class="btn btn-mini btn-danger">取消订单</span></a>
                                        @endif

                                        @if($order->status=='已归还' && $order->back_status=='待验证')
                                                <a href="javascript:;" data-id="{{$order->id}}" title="验证寄回" class="tip verifyAction"><span class="btn btn-mini">验证寄回</span></a>
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
                                亲~，暂无订单列表哦~
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="span6" id="dialog" style="display:none;">
        <div class="block messaging">
            <div class="controls">
                <div class="control">
                    <input type="hidden" value="" id="id" />

                    <input type="text" value="" class="" id="express_no" placeholder="输入快递单号..." style="width: 100%;"/>

                        <select name="select" class="" id="express_id" style="width: 100%;">
                            <option value="0">--请选择--</option>
                            @if(count($express)>0)
                                @foreach($express as $v)
                                    <option value="{{$v->id}}">{{$v->title}}</option>
                                @endforeach
                            @endif
                        </select>
                </div>
                <button class="btn sendSubmit">确定发货</button>
                <button class="btn closed">关闭</button>
            </div>
        </div>
    </div>


    <link href="/admin/assets/css/easydialog.css" rel="stylesheet" type="text/css" />
    <script src="/admin/assets/js/easydialog.js" charset="utf-8"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".send").click(function(){
                var id = $(this).attr('data-id');
                $("#id").val(id);
                easyDialog.open({
                    container : 'dialog',
                    fixed : false
                });
            });

            $(".closed").click(function(){
                easyDialog.close();
            });

            $(".sendSubmit").click(function(){
                var id = $("#id").val();
                var express_no = $("#express_no").val();
                var express_id = $("#express_id").val();
                if (!express_no) {
                    eAlert('请输入快递单号');
                    return false;
                }

                $.post("{{route('admin.order.send')}}", {id:id,express_no:express_no,express_id:express_id}, function(data){
                    easyDialog.close();
                    cTip(data);
                }, "json");
            });

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

            $('.cancelAction').click(function(){
                var id = $(this).attr('data-id');
                $.confirm({
                    text: "确认取消？",
                    confirm: function(button) {
                        $.post("{{route('admin.order.action')}}",{id:id,status:-1},function(data){
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