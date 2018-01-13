@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">优惠券管理</a> <span class="divider">></span></li>
            <li><a href="{{ route('coupons.index') }}">优惠券列表</a> <span class="divider">></span></li>
            <li class="active">添加优惠券</li>
        </ul>
    </div>

    <div class="workplace">
        <form id="validation" method="post">
            <div class="row-fluid">
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>优惠券信息</h1>
                    </div>
                    <div class="block-fluid">
                        <div class="row-form clearfix">
                            <div class="span3">优惠券名称：</div>
                            <div class="span9">
                                <input type="text" value="" class="validate[required]" id="title" name="title"/>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">优惠券类型：</div>
                            <div class="span9">
                                <select name="select" class="validate[required]" id="type">
                                    <option value="1">新手优惠券</option>
                                    <option value="2">满减优惠券</option>
                                    <option value="3">租金折扣券</option>
                                </select>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">抵扣金额：</div>
                            <div class="span9">
                                <input type="text" value="" class="validate[required,custom[stock]]" id="price" name="price"/>
                            </div>
                        </div>
                        <div class="row-form clearfix condition">
                            <div class="span3">满多少能减：</div>
                            <div class="span9">
                                <input type="text" value="0" class="validate[required,custom[stock]]" id="condition" name="condition"/>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">有效天数：</div>
                            <div class="span9">
                                <input type="text" value="0" class="validate[required,custom[stock]]" id="days" name="days"/>
                            </div>
                        </div>
                        <div class="row-form clearfix" id="award" style="display: none;">
                            <div class="span3">奖励名额数量：</div>
                            <div class="span9">
                                <input type="text" value="0" class="validate[required,custom[stock]]" id="need_award_num" name="need_award_num"/>
                            </div>
                        </div>
                        {{--<div class="row-form clearfix">
                            <div class="span3">开始时间：</div>
                            <div class="span9">
                                <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',errDealMode:2})" placeholder="开始时间" class="form-control validate[required,custom[date]]" id="start_time" name="start_time"  value="">
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">结束时间：</div>
                            <div class="span9">
                                <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',errDealMode:2})" placeholder="结束时间" class="form-control validate[required,custom[date]]" id="end_time" name="end_time"  value="">
                            </div>
                        </div>--}}
                        <div class="footer tar">
                            <button class="btn" id="submit">保 存</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#type").change(function(){
                var type = $(this).val();
                if(type == 3)
                {
                    $("#award").show();
                }
                else
                {
                    $("#award").hide();
                }
            });

            $('#submit').click(function(e) {
                e.preventDefault();

                if ($("#validation").validationEngine('validate')) {
                    var title = $("#title").val();
                    var price = $("#price").val();
                    var type = $("#type").val();
                    //var start_time = $("#start_time").val();
                    //var end_time = $("#end_time").val();
                    var condition = $("#condition").val();
                    var days = $("#days").val();
                    var need_award_num = $("#need_award_num").val();

                    $.post("{{ route('coupons.store') }}",
                        {title:title,price:price,type:type,days:days,condition:condition,need_award_num:need_award_num},
                        function(data){
                            cTip(data);
                        }, "json");
                }
            });

        });
    </script>
@endsection