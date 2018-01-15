@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">用户管理</a> <span class="divider">></span></li>
            <li class="active"><a href="{{ route('admin.user.recommend') }}">邀请用户列表</a></li>
        </ul>
    </div>

    <div class="workplace">
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-list"></div>
                    <h1>邀请用户列表</h1>
                    <ul class="buttons">
                    </ul>
                </div>
                <div class="block-fluid">
                    @if(count($users)>0)
                        <table cellpadding="0" cellspacing="0" width="100%" class="table">
                            <thead>
                            <tr>
                                <th>用户昵称</th>
                                <th>手机号</th>
                                <th>金币数量</th>
                                <th>邀请好友数量</th>
                                <th>好友下单人数</th>
                                <th>兑换减免券次数</th>
                            </tr>
                            </thead>
                            <tbody id="lists">
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->telephone}}</td>
                                        <td>{{$user->award_num}}</td>
                                        <td>{{$user->user_recommends_count}}</td>
                                        <td>{{$user->user_recommends_order_count}}</td>
                                        <td>{{$user->exchange_coupon_count}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $from_users->links() }}
                    @else
                        <div class="toolbar bottom-toolbar clearfix">
                            <div class="tac" style="margin: 10px 0px;">
                                亲~，邀请用户列表哦~
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection