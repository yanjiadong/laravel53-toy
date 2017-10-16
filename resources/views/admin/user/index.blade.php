@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">用户管理</a> <span class="divider">></span></li>
            <li class="active"><a href="{{ route('admin.user.index') }}">用户列表</a></li>
        </ul>

        <ul class="buttons">
            <li>
                <a href="javascript:;" class="link_bcPopupSearch"><span class="icon-search"></span><span class="text">用户查询</span></a>
                <form action="{{route('admin.user.index')}}" method="get">
                    <div id="bcPopupSearch" class="popup">
                        <div class="head clearfix">
                            <div class="arrow"></div>
                            <span class="isw-zoom"></span>
                            <span class="name">用户查询</span>
                        </div>

                        <div class="body search row-form">
                            <span>是否会员</span>
                            <select name="is_vip">
                                <option value="0" <?php echo (isset($is_vip)&&$is_vip==0)?'selected':'';?>>全部</option>
                                <option value="1" <?php echo (isset($is_vip)&&$is_vip==1)?'selected':'';?>>非会员</option>
                                <option value="2" <?php echo (isset($is_vip)&&$is_vip==2)?'selected':'';?>>会员</option>

                            </select>
                        </div>

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
                    <h1>用户列表</h1>
                    <ul class="buttons">
                        <li>
                            <a href="javascript:;" class="isw-settings"></a>
                        </li>
                    </ul>
                </div>
                <div class="block-fluid">
                    @if(count($users)>0)
                        <table cellpadding="0" cellspacing="0" width="100%" class="table">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>手机号</th>
                                <th>微信昵称</th>
                                <th>是否会员</th>
                                <th>会员总天数</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody id="lists">
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$user->telephone}}</td>
                                    <td>{{$user->wechat_nickname}}</td>
                                    <td>{{$user->is_vip==1?"是":'否'}}</td>
                                    <td>{{$user->days}}</td>
                                    <td>{{$user->created_at}}</td>
                                    <td>
                                        @if($user->is_vip==1)
                                            <a href="javascript:;" data-id="{{$user->id}}" title="关闭会员" class="tip doAction" data-status="0"><span class="btn btn-mini btn-warning">关闭会员</span></a>
                                        @else
                                            {{--<a href="javascript:;" data-id="{{$user->id}}" title="开启会员" class="tip doAction" data-status="1"><span class="btn btn-mini">开启会员</span></a>--}}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $users->links() }}
                    @else
                        <div class="toolbar bottom-toolbar clearfix">
                            <div class="tac" style="margin: 10px 0px;">
                                亲~，暂无用户列表哦~
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.doAction').click(function(){
                var id = $(this).attr('data-id');
                var status = $(this).attr('data-status');
                $.confirm({
                    text: "确认操作？",
                    confirm: function(button) {
                        $.post("{{route('admin.user.action')}}",{id:id,status:status},function(data){
                            cTip(data);
                        }, "json");
                    },
                    confirmButton: "确认",
                    cancelButton: "取消"
                });
            });
        });
    </script>
@endsection