@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">玩具管理</a> <span class="divider">></span></li>
            <li class="active"><a href="{{ route('goods.index') }}">玩具列表</a></li>
        </ul>
        <ul class="buttons">
            <li>
                <a href="javascript:;" class="link_bcPopupSearch"><span class="icon-search"></span><span class="text">玩具查询</span></a>
                <form action="{{route('goods.index')}}" method="get">
                    <div id="bcPopupSearch" class="popup">
                        <div class="head clearfix">
                            <div class="arrow"></div>
                            <span class="isw-zoom"></span>
                            <span class="name">玩具查询</span>
                        </div>
                        <div class="body search row-form">
                            <span>分类</span>
                            <select name="category_id" id="category_id">
                                <option value="0" <?php echo (isset($category_id)&&$category_id==0)?'selected':'';?>>全部</option>
                                @if(count($categorys)>0)
                                    @foreach($categorys as $category)
                                        <option value="{{ $category->id }}" <?php echo (isset($category->id)&&$category->id==$category_id)?'selected':'';?>>{{$category->title}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        @if(count($brands)>0)
                            <div class="body search row-form">
                                <span>品牌</span>
                                <select name="brand_id" id="brand_id">
                                    <option value="0">--请选择--</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" <?php echo (isset($brand->id)&&$brand->id==$brand_id)?'selected':'';?>>{{$brand->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="body search row-form">
                                <span>品牌</span>
                                <select name="brand_id" id="brand_id">
                                    <option value="0">--请选择--</option>
                                </select>
                            </div>
                        @endif


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
                    <h1>玩具列表</h1>
                    <ul class="buttons">
                        <li>
                            <a href="javascript:;" class="isw-settings"></a>
                            <ul class="dd-list">
                                <li><a href="{{ route('goods.create') }}"><span class="isw-plus"></span>添加商品</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <form id="validation" method="post">
                    <div class="block-fluid">
                    @if(count($goods)>0)
                        <table cellpadding="0" cellspacing="0" width="100%" class="table">
                            <thead>
                            <tr>
                                <th>排序</th>
                                <th>玩具名称</th>
                                <th>分类名称</th>
                                <th>所属品牌</th>
                                <th>库存</th>
                                <th>新品抢先</th>
                                <th>热门推荐</th>
                                <th>状态</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody id="lists">
                                @foreach ($goods as $good)
                                <tr>
                                    {{--<td>{{ $loop->iteration }}</td>--}}
                                    <td width="80px"><input style="width: 30%;" type="text" value="{{ $good->sort }}" class="validate[required,custom[number]] sortAction" data-id="{{$good->id}}"></td>
                                    <td>{{ $good->title }}</td>
                                    <td>{{ $good->category->title }}</td>
                                    <td>{{ $good->brand->title }}</td>
                                    <td width="100px"><input style="width: 40%;" type="text" value="{{ $good->store }}" class="validate[required,custom[number]] storeAction" data-id="{{$good->id}}"></td>
                                    <td>{{ $good->is_new==1?'是':'否' }}</td>
                                    <td>{{ $good->is_hot==1?'是':'否' }}</td>
                                    <td>{{ $good->status==\App\Good::STATUS_ON_SALE?'上架':'下架' }}</td>
                                    <td>{{ $good->created_at }}</td>
                                    <td>
                                        <a href="{{ url("admin/goods/$good->id/edit") }}" title="修改" class="tip"><span class="btn btn-mini">修改</span></a>
                                        @if($good->status==\App\Good::STATUS_ON_SALE)
                                            <a href="javascript:;" data-id="{{ $good->id }}" title="下架玩具" class="tip action" status="2"><span class="btn btn-mini">下架玩具</span></a>
                                        @else
                                            <a href="javascript:;" data-id="{{ $good->id }}" title="上架玩具" class="tip action" status="1"><span class="btn btn-mini btn-danger">上架玩具</span></a>
                                        @endif

                                        @if($good->is_new==1)
                                            <a href="javascript:;" data-id="{{ $good->id }}" title="取消新品" class="tip newAction" status="0"><span class="btn btn-mini">取消新品</span></a>
                                        @else
                                            <a href="javascript:;" data-id="{{ $good->id }}" title="设置新品" class="tip newAction" status="1"><span class="btn btn-mini btn-danger">设置新品</span></a>
                                        @endif

                                        @if($good->is_hot==1)
                                            <a href="javascript:;" data-id="{{ $good->id }}" title="取消热门" class="tip hotAction" status="0"><span class="btn btn-mini">取消热门</span></a>
                                        @else
                                            <a href="javascript:;" data-id="{{ $good->id }}" title="设置热门" class="tip hotAction" status="1"><span class="btn btn-mini btn-danger">设置热门</span></a>
                                        @endif

                                        <a href="javascript:;" data-id="{{ $good->id }}" title="删除" class="tip del"><span class="btn btn-mini btn-danger">删除</span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $goods->links() }}
                    @else
                        <div class="toolbar bottom-toolbar clearfix">
                            <div class="tac" style="margin: 10px 0px;">
                                亲~，暂无玩具列表哦~
                            </div>
                        </div>
                    @endif
                </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.del').click(function(){
                var id = $(this).attr('data-id');
                var _method = 'DELETE';
                var url = '{{url('admin/goods')}}' + '/' + id;

                $.confirm({
                    text: "确认删除？",
                    confirm: function(button) {
                        $.post(url,{_method:_method},function(data){
                            cTip(data);
                        }, "json");
                    },
                    confirmButton: "确认",
                    cancelButton: "取消"
                });
            });

            $('.action').click(function(){
                var id = $(this).attr('data-id');
                var status = $(this).attr('status');
                $.confirm({
                    text: status==1?"确认上架玩具?":"确认下架玩具?",
                    confirm: function(button) {
                        $.post("{{route('goods.action')}}",{id:id,status:status},function(data){
                            cTip(data);
                        }, "json");
                    },
                    confirmButton: "确认",
                    cancelButton: "取消"
                });
            });

            $('.newAction').click(function(){
                var id = $(this).attr('data-id');
                var status = $(this).attr('status');
                $.confirm({
                    text: status==1?"确认设置新品?":"确认取消设置新品?",
                    confirm: function(button) {
                        $.post("{{route('goods.new_action')}}",{id:id,status:status},function(data){
                            cTip(data);
                        }, "json");
                    },
                    confirmButton: "确认",
                    cancelButton: "取消"
                });
            });


            $('.hotAction').click(function(){
                var id = $(this).attr('data-id');
                var status = $(this).attr('status');
                $.confirm({
                    text: status==1?"确认设置热门?":"确认取消设置热门?",
                    confirm: function(button) {
                        $.post("{{route('goods.hot_action')}}",{id:id,status:status},function(data){
                            cTip(data);
                        }, "json");
                    },
                    confirmButton: "确认",
                    cancelButton: "取消"
                });
            });

            $('.sortAction').blur(function () {
                if ($("#validation").validationEngine('validate')) {
                    var sort = $(this).val();
                    var good_id = $(this).attr('data-id');

                    $.post("{{route('goods.sort_action')}}",{id:good_id,sort:sort},function(data){
                        //cTip(data);
                    }, "json");
                }
            });

            $('.storeAction').blur(function () {
                if ($("#validation").validationEngine('validate')) {
                    var store = $(this).val();
                    var good_id = $(this).attr('data-id');

                    $.post("{{route('goods.store_action')}}",{id:good_id,store:store},function(data){
                        //cTip(data);
                    }, "json");
                }
            });

            $("#category_id").change(function(){
                var category_id = $(this).val();

                $.post("{{url('admin/brands/get_brands_by_id')}}",{category_id:category_id},function(data){
                    $("#brand_id").html(data.html);
                },'json');
            });

        });
    </script>
@endsection