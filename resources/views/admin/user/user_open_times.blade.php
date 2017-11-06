@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">数据管理</a> <span class="divider">></span></li>
            <li class="active"><a href="{{ route('admin.user_open_times.index') }}">首页登录时间列表</a></li>
        </ul>

    </div>

    <div class="workplace">
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-list"></div>
                    <h1>首页登录时间列表</h1>
                    <ul class="buttons">
                        <li>
                            <a href="javascript:;" class="isw-settings"></a>
                        </li>
                    </ul>
                </div>
                <div class="block-fluid">
                    @if(count($list)>0)
                        <table cellpadding="0" cellspacing="0" width="100%" class="table">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>手机号</th>
                                <th>微信昵称</th>
                                <th>登录时间</th>

                            </tr>
                            </thead>
                            <tbody id="lists">
                            @foreach ($list as $v)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$v->user->telephone}}</td>
                                    <td>{{$v->user->wechat_nickname}}</td>
                                    <td>{{$v->created_at}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $list->links() }}
                    @else
                        <div class="toolbar bottom-toolbar clearfix">
                            <div class="tac" style="margin: 10px 0px;">
                                亲~，暂无列表哦~
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection