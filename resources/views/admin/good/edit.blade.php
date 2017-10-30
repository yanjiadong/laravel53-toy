@extends('admin.layouts.default')
@include('vendor.ueditor.assets')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">玩具管理</a> <span class="divider">></span></li>
            <li><a href="{{ route('goods.index') }}">玩具列表</a> <span class="divider">></span></li>
            <li class="active">修改玩具</li>
        </ul>
    </div>

    <div class="workplace">
        <form id="validation" method="post">
            <div class="row-fluid">
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-documents"></div>
                        <h1>玩具信息</h1>
                    </div>
                    <div class="block-fluid">
                        <div class="row-form clearfix">
                            <div class="span3">玩具名称：</div>
                            <div class="span9">
                                <input type="text" value="{{$good->title}}" class="validate[required]" id="title" name="title"/>
                            </div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">所属分类：</div>
                            <div class="span9">
                                <select name="select" class="validate[required]" id="category_id">
                                    <option value="0">--请选择--</option>
                                    @if(count($categorys))
                                        @foreach($categorys as $category)
                                            <option value="{{$category->id}}" {{ $category->id == $good->category_id ? 'selected':'' }}>{{$category->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">所属品牌：</div>
                            <div class="span9">
                                <select name="select" class="validate[required]" id="brand_id">
                                    <option value="0">--请选择--</option>
                                    @if(count($brands))
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->id}}" {{ $brand->id == $good->brand_id ? 'selected':'' }}>{{$brand->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">市场价：</div>
                            <div class="span9">
                                <input type="text" value="{{$good->price}}" class="validate[required,custom[number]]" id="price"/>
                                <span>单位：(元) </span>
                            </div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">适用年龄：</div>
                            <div class="span9">
                                <input type="text" value="{{$good->old}}" class="validate[required]]" id="old"/>
                            </div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">视频地址：</div>
                            <div class="span9">
                                <input type="file" class="userfile" id="video-upload" value="上传视频" name="userfile" accept="video/mp4">
                                <br/>
                                <img src="/admin/assets/img/loading.gif"  id="loading2" style="display:none;margin-top:10px;height: 150px;width:150px;" />
                                <input type="text" value="{{$good->video}}"  id="video" readonly>
                                <br/>
                                <span>仅支持MP4格式的视频文件</span>
                                <br/>
                                <div id="video-show">
                                    <video width="320" height="240" controls id="video-play">
                                        <source src="{{$good->video}}" type="video/mp4">
                                    </video>
                                </div>
                            </div>
                        </div>
                        <div class="row-form clearfix stock">
                            <div class="span3">视频长度：</div>
                            <div class="span9"><input type="text" value="{{ $good->video_second }}" class="validate[custom[stock]]" id="video_second" name="video_second"/>
                                <span>单位：(秒) </span>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">封面图：</div>
                            <div class="span9">
                                <input type="file" class="userfile" id="upload" value="上传图片" name="userfile" accept="image/jpeg,image/png,image/gif,image/jpg">
                                <input type="hidden" id="uploadPath" name="uploadPath" value="{{$good->picture}}" />
                                <br/>
                                <img src="{{ $good->picture }}" style="margin-top: 10px;height: 160px;width:160px;" class="showimg" id="showPic"/>
                                <img src="/admin/assets/img/loading.gif"  id="loading" style="display:none;margin-top:10px;height: 150px;width:150px;" />
                                <br/>
                                <span>建议图片尺寸标准为800x800</span>
                            </div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">分类页封面图：</div>
                            <div class="span9">
                                <input type="file" class="userfile" id="categoryUpload" value="上传图片" name="userfile" accept="image/jpeg,image/png,image/gif,image/jpg">
                                <input type="hidden" id="categoryPicture" name="categoryPicture" value="{{$good->category_picture}}" />
                                <br/>
                                <img src="{{$good->category_picture}}" style="margin-top: 10px;height: 160px;width:320px;" class="showimg" id="showPic3"/>
                                <img src="/admin/assets/img/loading.gif"  id="loading3" style="display:none;margin-top:10px;height: 150px;width:150px;" />
                                <br/>
                                <span>建议图片尺寸标准为320x160</span>
                            </div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">图片：</div>
                            <div class="span9">
                                <input type="file" id="J_UploaderBtn" value="上传图片" name="userfile" accept="image/*">
                                <input type="hidden" id="J_Urls" name="urls" value="" />
                                <span>还可以上传<span id="J_UploadCount">5</span>张图片,  (建议图片尺寸标准为800x800, png、jpg格式)</span>
                                <br/>
                                <ul id="J_UploaderQueue" class="grid">
                                    <script type="text/uploader-files">
                                        {!! $picJson !!}
                                    </script>
                                </ul>
                            </div>
                        </div>

                        {{--<div class="row-form clearfix">
                            <div class="span3">玩具品牌：</div>
                            <div class="span9">
                                <input type="text" value="{{$good->brand}}" class="validate[required]" id="brand" name="brand"/>
                            </div>
                        </div>--}}
                        <div class="row-form clearfix">
                            <div class="span3">品牌所属：</div>
                            <div class="span9">
                                <input type="text" value="{{$good->brand_country}}" class="validate[required]" id="brand_country" name="brand_country"/>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">产品类型：</div>
                            <div class="span9">
                                <input type="text" value="{{$good->weight}}" class="validate[required]" id="weight" name="weight"/>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">玩具材质：</div>
                            <div class="span9">
                                <input type="text" value="{{$good->material}}" class="validate[required]" id="material" name="material"/>
                            </div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">操作方式：</div>
                            <div class="span9">
                                <input type="text" value="{{$good->effect}}" class="validate[required]" id="effect" name="effect"/>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">适用级别：</div>
                            <div class="span9">
                                <input type="text" value="{{$good->way}}" class="validate[required]" id="way" name="way"/>
                            </div>
                        </div>
                        <div class="row-form clearfix stock">
                            <div class="span3">库存数量：</div>
                            <div class="span9"><input type="text" value="{{$good->store}}" class="validate[required,custom[stock]]" id="store" name="store"/></div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">新品抢先：</div>
                            <div class="span9">
                                <label class="checkbox inline">
                                    <div class="radio"><span><input type="radio" name="is_new" {{ $good->is_new==0?'checked':'' }} value="0"></span></div> 否
                                </label>
                                <label class="checkbox inline">
                                    <div class="radio"><span class="checked"><input type="radio" name="is_new" value="1" {{ $good->is_new==1?'checked':'' }}></span></div> 是
                                </label>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">热门推荐：</div>
                            <div class="span9">
                                <label class="checkbox inline">
                                    <div class="radio"><span><input type="radio" name="is_hot" value="0" {{ $good->is_hot==0?'checked':'' }}></span></div> 否
                                </label>
                                <label class="checkbox inline">
                                    <div class="radio"><span class="checked"><input type="radio" name="is_hot" value="1" {{ $good->is_hot==1?'checked':'' }}></span></div> 是
                                </label>
                            </div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">排序编号：</div>
                            <div class="span9">
                                <input type="text" value="{{$good->sort}}" class="validate[required,custom[number]]" id="sort"/>
                                <span>排序越小越靠前</span>
                            </div>
                        </div>
                        <div class="row-form clearfix">
                            <div class="span3">请选择标签:</div>
                            <div class="span9">
                                <select name="select" id="chooseArea" style="width: 100%;" multiple="multiple">
                                    @if(count($tags))
                                        @foreach($tags as $tag)
                                            <option value="{{$tag->id}}" {{ in_array($tag->id,$tags_arr)?'selected':'' }}>{{$tag->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="row-form clearfix">
                            <div class="span3">玩具描述：</div>
                            <div class="span9">
                                <!-- 编辑器容器 -->
                                <script id="container" name="content" type="text/plain">{!! $good->desc !!}</script>
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
    <script src="/admin/assets/js/kissy.js" charset="utf-8"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container',{
            initialFrameHeight:640
        });
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#chooseArea").select2();

            var S = KISSY;
            S.use('plugins/uploader/1.5/index,plugins/uploader/1.5/themes/imageUploader/index,plugins/uploader/1.5/themes/imageUploader/style.css', function (S, Uploader,ImageUploader) {
                //上传组件插件
                var plugins = 'plugins/uploader/1.5/plugins/auth/auth,' +
                    'plugins/uploader/1.5/plugins/urlsInput/urlsInput,' +
                    'plugins/uploader/1.5/plugins/proBars/proBars,' +
                    'plugins/uploader/1.5/plugins/filedrop/filedrop,' +
                    'plugins/uploader/1.5/plugins/preview/preview';

                S.use(plugins,function(S,Auth,UrlsInput,ProBars,Filedrop,Preview){
                    var uploader = new Uploader('#J_UploaderBtn',{
                        //处理上传的服务器端脚本路径
                        action:"{{ url('admin/upload',['size'=>'800,800']) }}",
                        multiple:true,
                        multipleLen:5
                    });
                    //使用主题
                    uploader.theme(new ImageUploader({
                        queueTarget:'#J_UploaderQueue'
                    }))
                    //验证插件
                    uploader.plug(new Auth({
                        //最多上传个数
                        max:5,
                        //图片最大允许大小
                        maxSize:2000
                    }))
                    //url保存插件
                        .plug(new UrlsInput({target:'#J_Urls'}))
                        //进度条集合
                        .plug(new ProBars())
                        //拖拽上传
                        .plug(new Filedrop())
                        //图片预览
                        .plug(new Preview())
                    ;

                    @if(!empty($picJson))
                        //默认数据
                        uploader.restore();
                    @endif
                });
            });

            $("#video-upload").uniform();
            $("#video-upload").ajaxfileupload({
                'action': '{{ url('admin/upload') }}',
                'params': {
                    '_token': Laravel.csrfToken
                },
                'onComplete': function(data) {
                    if (data.success == 1) {
                        $("#video-show").show();
                        $('#video').val(data.path);
                        $('#video-play').attr('src',data.path);
                    } else {

                    }
                    $("#loading2").hide();
                },
                'onStart': function() {
                    $("#loading2").show();
                },
                'onCancel': function() {
                }
            });

            $("#upload").uniform();
            $("#upload").ajaxfileupload({
                'action': '{{ url('admin/upload',['size'=>'800,800']) }}',
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

            $("#categoryUpload").uniform();
            $("#categoryUpload").ajaxfileupload({
                'action': '{{ url('admin/upload',['size'=>'320,160']) }}',
                'params': {
                    '_token': Laravel.csrfToken
                },
                'onComplete': function(data) {
                    if (data.success == 1) {
                        $('#categoryPicture').val(data.path);
                        $('#showPic3').attr('src', data.url).show();
                    } else {

                    }
                    $("#loading3").hide();
                },
                'onStart': function() {
                    $("#loading3").show();
                    $("#showPic3").hide();
                },
                'onCancel': function() {
                }
            });

            $("#category_id").change(function(){
                var category_id = $(this).val();

                $.post("{{url('admin/brands/get_brands_by_id')}}",{category_id:category_id},function(data){
                    $("#brand_id").html(data.html);
                },'json');
            });

            $('#submit').click(function(e) {
                e.preventDefault();

                if ($("#validation").validationEngine('validate')) {
                    var title = $("#title").val();
                    var pics = $("#J_Urls").val();
                    var tags = $("#chooseArea").val();
                    var category_id = $("#category_id").val();
                    //var category_tag_id = $("#category_tag_id").val();
                    var price = $("#price").val();
                    var picture = $("#uploadPath").val();
                    var category_picture = $("#categoryPicture").val();
                    var video = $("#video").val();
                    var brand_id = $("#brand_id").val();
                    var brand_country = $("#brand_country").val();
                    var material = $("#material").val();
                    var weight = $("#weight").val();
                    var effect = $("#effect").val();
                    var way = $("#way").val();
                    var store = $("#store").val();
                    var is_hot = $('input[name="is_hot"]:checked').val();
                    var is_new = $('input[name="is_new"]:checked').val();
                    var desc = ue.getContent();
                    var video_second = $("#video_second").val();
                    var old = $("#old").val();
                    var sort = $("#sort").val();

                    var url = "{{route('goods.update',['id'=>$good->id])}}";
                    var _method = 'PUT';

                    if(category_id==0)
                    {
                        eAlert('请选择分类');
                        return;
                    }

                    if(brand_id==0)
                    {
                        eAlert('请选择品牌');
                        return;
                    }

                    $.post(url,
                        {sort:sort,old:old,category_picture:category_picture,video:video,_method:_method,title:title,pics:pics,tags:tags,category_id:category_id,price:price,picture:picture,brand_id:brand_id,
                            brand_country:brand_country,material:material,weight:weight,effect:effect,way:way,store:store,is_hot:is_hot,is_new:is_new,desc:desc,video_second:video_second},
                        function(data){
                            cTip(data);
                        }, "json");
                }
            });

        });
    </script>
@endsection