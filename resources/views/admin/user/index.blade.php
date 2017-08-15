@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">用户管理</a> <span class="divider">></span></li>
            <li class="active"><a href="{{ route('admin.user.index') }}">用户列表</a></li>
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
                                <th>创建时间</th>
                                <th>状态</th>
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
                                    <td>{{$user->created_at}}</td>
                                    <td>{{$user->status==1?"启用":'禁用'}}</td>
                                    <td>
                                        @if($user->status==1)
                                            <a href="javascript:;" data-id="{{$user->id}}" title="禁用" class="tip doAction" data-status="2"><span class="btn btn-mini btn-warning">禁用</span></a>
                                        @else
                                            <a href="javascript:;" data-id="{{$user->id}}" title="启用" class="tip doAction" data-status="1"><span class="btn btn-mini">启用</span></a>
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