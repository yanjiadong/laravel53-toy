@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">Banner管理</a> <span class="divider">></span></li>
            <li><a href="{{ route('banners.index') }}"> Banner列表</a> <span class="divider">></span></li>
            <li class="active">添加Banner</li>
        </ul>
    </div>

    <div class="workplace">
        <form id="validation" method="post">
            <div class="row-fluid">
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>Banner信息</h1>
                    </div>
                    <div class="block-fluid">
                        <div class="row-form clearfix">
                            <div class="span3">简介：</div>
                            <div class="span9">
                                <input type="text" value="" class="validate[required]" id="intro" name="intro"/>
                            </div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">图片：</div>
                            <div class="span9">
                                <input type="file" class="userfile" id="upload" value="上传图片" name="userfile" accept="image/jpeg,image/png,image/gif,image/jpg">
                                <input type="hidden" id="uploadPath" name="uploadPath" value="" />
                                <br/>
                                <img src="/admin/assets/img/default.png" style="margin-top: 10px;height: 160px;width:320px;" class="showimg" id="showPic"/>
                                <img src="/admin/assets/img/loading.gif"  id="loading" style="display:none;margin-top:10px;height: 150px;width:150px;" />
                                <br/>
                                <span>建议图片尺寸标准为1600x800</span>
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

    <script type="text/javascript" src="/admin/assets/js/jquery.ajaxfileupload.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#upload").uniform();
            $("#upload").ajaxfileupload({
                'action': '{{ url('admin/upload',['size'=>'1600,800']) }}',
                'params': {
                    '_token': Laravel.csrfToken
                },
                'onComplete': function(data) {
                    if (data.success == 1) {
                        $('#uploadPath').val(data.path);
                        $('#showPic').attr('src', data.url).show();
                    } else {

                    }
                    $("#loading").hide();
                },
                'onStart': function() {
                    $("#loading").show();
                    $("#showPic").hide();
                },
                'onCancel': function() {
                }
            });

            $('#submit').click(function(e) {
                e.preventDefault();

                if ($("#validation").validationEngine('validate')) {
                    var intro = $("#intro").val();
                    var picture = $("#uploadPath").val();

                    if(picture == '')
                    {
                        $.prompt('请先上传图片', {
                            buttons: { "确定": true }
                        });
                        return;
                    }

                    $.post("{{ route('banners.store') }}",
                        {intro:intro,picture:picture},
                        function(data){
                            cTip(data);
                        }, "json");
                }
            });

        });
    </script>
@endsection