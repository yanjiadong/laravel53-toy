@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">设置</a></li>
        </ul>
    </div>

    <div class="workplace">
        <form id="validation" method="POST" action="">
            <div class="row-fluid">
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>密码修改</h1>
                    </div>
                    <div class="block-fluid">
                        <div class="row-form clearfix">
                            <div class="span3">原始密码：</div>
                            <div class="span9"><input type="password" value="" name="old_password" class="validate[required,minSize[6]]" id="old_password"/></div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">新密码：</div>
                            <div class="span9"><input type="password" value="" name="password" class="validate[required,minSize[6]]" id="password"/></div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">确认密码：</div>
                            <div class="span9"><input type="password" value="" name="password_confirmation" class="validate[condRequired[password],equals[password]]" id="password_confirmation"/></div>
                        </div>

                        <div class="footer tar">
                            <button class="btn" id="submit">提 交</button>
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
                    var old_password = $("#old_password").val();
                    var password = $("#password").val();
                    var password_confirmation = $("#password_confirmation").val();

                    $.post("{{ url('admin/setting') }}",{old_password:old_password,password:password,password_confirmation:password_confirmation},function(data){
                        cTip(data);
                    }, "json");
                }
            });

        });
    </script>
@endsection