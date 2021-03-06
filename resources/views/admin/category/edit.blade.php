@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">分类管理</a> <span class="divider">></span></li>
            <li><a href="{{ route('categorys.index') }}"> 分类列表</a> <span class="divider">></span></li>
            <li class="active">修改分类</li>
        </ul>
    </div>

    <div class="workplace">
        <form id="validation" method="post">
            <div class="row-fluid">
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>分类信息</h1>
                    </div>
                    <div class="block-fluid">
                        <div class="row-form clearfix">
                            <div class="span3">分类名称：</div>
                            <div class="span9">
                                <input type="text" value="{{ $category->title }}" class="validate[required]" id="title" name="title"/>
                            </div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">图片：</div>
                            <div class="span9">
                                <input type="file" class="userfile" id="upload" value="上传图片" name="userfile" accept="image/jpeg,image/png,image/gif,image/jpg">
                                <input type="hidden" id="uploadPath" name="uploadPath" value="{{ $category->picture }}" />
                                <br/>
                                <img src="{{ $category->picture }}" style="margin-top: 10px;height: 130px;width:320px;" class="showimg" id="showPic"/>
                                <img src="/admin/assets/img/loading.gif"  id="loading" style="display:none;margin-top:10px;height: 150px;width:150px;" />
                                <br/>
                                <span>建议图片尺寸标准为960x400</span>
                            </div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">分类描述：</div>
                            <div class="span9">
                                <textarea name="desc" id="desc" class="validate[required]">{{ $category->desc }}</textarea>
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
                'action': '{{ url('admin/upload',['size'=>'960,400']) }}',
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
                    var url = "{{route('categorys.update',['id'=>$category->id])}}";
                    var title = $("#title").val();
                    var desc = $("#desc").val();
                    var picture = $("#uploadPath").val();
                    var _method = 'PUT';

                    if(picture == '')
                    {
                        $.prompt('请先上传图片', {
                            buttons: { "确定": true }
                        });
                        return;
                    }

                    $.post(url,
                        {title:title,desc:desc,picture:picture,_method:_method},
                        function(data){
                            cTip(data);
                        }, "json");
                }
            });

        });
    </script>
@endsection