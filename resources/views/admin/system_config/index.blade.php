@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">字典管理</a> <span class="divider">></span></li>
            <li class="active">系统设置</li>
        </ul>
    </div>

    <div class="workplace">
        <form id="validation" method="post">
            <div class="row-fluid">
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>系统设置</h1>
                    </div>
                    <div class="block-fluid">
                        <div class="row-form clearfix">
                            <div class="span3">每个自然月内前几次免邮费：</div>
                            <div class="span9"><input type="text" value="{{isset($content[0])?$content[0]:2}}" class="validate[required,custom[integer]]" id="1"/></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">超过之后的邮费：</div>
                            <div class="span9"><input type="text" value="{{isset($content[1])?$content[1]:0}}" class="validate[required,custom[price]]" id="2"/></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">寄回地址收件人：</div>
                            <div class="span9"><input type="text" value="{{isset($content[2])?$content[2]:''}}" class="validate[required]" id="3"/></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">寄回地址电话：</div>
                            <div class="span9"><input type="text" value="{{isset($content[3])?$content[3]:''}}" class="validate[required,custom[phone]]" id="4"/></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">寄回地址：</div>
                            <div class="span9"><input type="text" value="{{isset($content[4])?$content[4]:''}}" class="validate[required]" id="5"/></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">寄回温馨提示：</div>
                            <div class="span9">
                                <textarea class="validate[required]" id="6">
                                    {{isset($content[5])?$content[5]:''}}
                                </textarea>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">非会员状态提示框：</div>
                            <div class="span9"><input type="text" value="{{isset($content[6])?$content[6]:''}}" class="validate[required]" id="7"/></div>
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
                    var config = [];
                    for (var i=1;i<8;i++)
                    {
                        config.push($("#"+i).val());
                    }

                    $.post("{{route('admin.system_config.store')}}",
                        {config:config},
                        function(data){
                            cTip(data);
                        }, "json");
                }
            });

        });
    </script>
@endsection