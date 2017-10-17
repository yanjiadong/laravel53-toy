@extends('admin.layouts.default')

@section('content')
    <div class="breadLine">
        <ul class="breadcrumb">
            <li><a href="javascript:;">数据管理</a> <span class="divider">></span></li>
            <li class="active"><a href="{{ route('admin.crontabs.index') }}">脚本列表</a></li>
        </ul>
    </div>

    <div class="workplace">
        <div class="row-fluid">
            <div class="span12">
                <div class="head clearfix">
                    <div class="isw-list"></div>
                    <h1>脚本列表</h1>
                    <ul class="buttons">

                    </ul>
                </div>
                <div class="block-fluid">
                    @if(count($lists)>0)
                        <table cellpadding="0" cellspacing="0" width="100%" class="table">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>运行时间</th>

                            </tr>
                            </thead>
                            <tbody id="lists">
                            @foreach ($lists as $list)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $list->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="toolbar bottom-toolbar clearfix">
                            <div class="tac" style="margin: 10px 0px;">
                                亲~，暂无脚本列表哦~
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection