@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">商品管理</a> <span class="divider">></span></li>
            <li><a href="{{ route('goods.index') }}">商品列表</a> <span class="divider">></span></li>
            <li class="active">添加商品</li>
        </ul>
    </div>

    <div class="workplace">
        <form id="validation" method="post">
            <div class="row-fluid">
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>商品信息</h1>
                    </div>
                    <div class="block-fluid">
                        <div class="row-form clearfix">
                            <div class="span3">商品名称：</div>
                            <div class="span9">
                                <input type="text" value="" class="validate[required]" id="title" name="title"/>
                            </div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">所属分类：</div>
                            <div class="span9">
                                <select name="select" class="validate[required]" id="category_id">
                                    <option value="0">--请选择--</option>
                                    @if(count($categorys))
                                        @foreach($categorys as $category)
                                            <option value="{{$category->id}}">{{$category->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">适合年龄：</div>
                            <div class="span9">
                                <select name="select" class="validate[required]" id="category_tag_id">
                                    <option value="0">--请选择--</option>
                                </select>
                            </div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">市场价：</div>
                            <div class="span9">
                                <input type="text" value="" class="validate[required,custom[number]]" id="price"/>
                                <span>单位：(元) </span>
                            </div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">封面图：</div>
                            <div class="span9">
                                <input type="file" class="userfile" id="upload" value="上传图片" name="userfile" accept="image/jpeg,image/png,image/gif,image/jpg">
                                <input type="hidden" id="uploadPath" name="uploadPath" value="" />
                                <br/>
                                <img src="/admin/assets/img/default.png" style="margin-top: 10px;height: 160px;width:160px;" class="showimg" id="showPic"/>
                                <img src="/admin/assets/img/loading.gif"  id="loading" style="display:none;margin-top:10px;height: 150px;width:150px;" />
                                <br/>
                                <span>建议图片尺寸标准为160x160</span>
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
                'action': '{{ url('admin/upload',['size'=>'160,160']) }}',
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

            $("#category_id").change(function(){
                var category_id = $(this).val();

                $.post("{{url('admin/category_tags/get_tags_by_id')}}",{category_id:category_id},function(data){
                    $("#category_tag_id").html(data.html);
                },'json');
            });

            $('#submit').click(function(e) {
                e.preventDefault();

                if ($("#validation").validationEngine('validate')) {
                    var title = $("#title").val();
                    var category_id = $("#category_id").val();

                    $.post("{{ route('category_tags.store') }}",
                        {title:title,category_id:category_id},
                        function(data){
                            cTip(data);
                        }, "json");
                }
            });

        });
    </script>
@endsection