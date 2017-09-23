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
                                <input type="text" value="{{$card->title}}" class="validate[required]" id="title" name="title"/>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">金额：</div>
                            <div class="span9">
                                <input type="text" value="{{$card->price}}" class="validate[required,custom[stock]]" id="price" name="price"/>
                            </div>
                        </div>
                        {{--<div class="row-form clearfix">
                            <div class="span3">有效天数：</div>
                            <div class="span9">
                                <input type="text" value="{{$card->days}}" class="validate[required,custom[stock]]" id="days" name="days"/>
                            </div>
                        </div>--}}
                        <div class="row-form clearfix">
                            <div class="span3">押金：</div>
                            <div class="span9">
                                <input type="text" value="{{$card->money}}" class="validate[required,custom[stock]]" id="money" name="money"/>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">类型：</div>
                            <div class="span9">
                                <select name="select" class="validate[required]" id="type">
                                    <option value="1" {{$card->type==1?'selected':''}}>月卡</option>
                                    <option value="2" {{$card->type==2?'selected':''}}>季度卡</option>
                                    <option value="3" {{$card->type==3?'selected':''}}>半年卡</option>
                                </select>
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
                    var url = "{{route('vip_cards.update',['id'=>$card->id])}}";
                    var title = $("#title").val();
                    var price = $("#price").val();
                    //var days = $("#days").val();
                    var money = $("#money").val();
                    var type = $("#type").val();
                    var _method = 'PUT';

                    $.post(url,
                        {title:title,price:price,money:money,_method:_method,type:type},
                        function(data){
                            cTip(data);
                        }, "json");
                }
            });

        });
    </script>
@endsection