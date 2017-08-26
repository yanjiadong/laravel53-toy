@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">会员卡管理</a> <span class="divider">></span></li>
            <li><a href="{{ route('vip_cards.index') }}">会员卡列表</a> <span class="divider">></span></li>
            <li class="active">添加会员卡</li>
        </ul>
    </div>

    <div class="workplace">
        <form id="validation" method="post">
            <div class="row-fluid">
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>会员卡信息</h1>
                    </div>
                    <div class="block-fluid">
                        <div class="row-form clearfix">
                            <div class="span3">会员卡名称：</div>
                            <div class="span9">
                                <input type="text" value="" class="validate[required]" id="title" name="title"/>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">金额：</div>
                            <div class="span9">
                                <input type="text" value="" class="validate[required,custom[stock]]" id="price" name="price"/>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">有效天数：</div>
                            <div class="span9">
                                <input type="text" value="" class="validate[required,custom[stock]]" id="days" name="days"/>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">押金：</div>
                            <div class="span9">
                                <input type="text" value="" class="validate[required,custom[stock]]" id="money" name="money"/>
                            </div>
                        </div>
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
            $('#submit').click(function(e) {
                e.preventDefault();

                if ($("#validation").validationEngine('validate')) {
                    var title = $("#title").val();
                    var price = $("#price").val();
                    var days = $("#days").val();
                    var money = $("#money").val();

                    $.post("{{ route('vip_cards.store') }}",
                        {title:title,price:price,days:days,money:money},
                        function(data){
                            cTip(data);
                        }, "json");
                }
            });

        });
    </script>
@endsection