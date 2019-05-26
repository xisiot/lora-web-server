@extends('layouts.app')
@section('content')
    <link href="/css/base.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    {{--导航栏下侧内容--}}
    <div class="panel spotlight">
        <div class="container">
            <div class="main-wrapper">
                <ol class="breadcrumb_giz">
                    <li><a href="/gateway">网关详情 </a></li>
                    <li class="active"><a href="/gateway/{{$input}}">{{$input}}</a></li>
                    <li class="active">数据展示</li>
                    <li class="active">数据列表</li>
                </ol>
                <div class="spotlight-button">
                    <a class="btn btn-primary" href="/gateway"> 返回</a>
                </div>
            </div>
        </div>
    </div>
    {{--左侧导航栏--}}
    <div class="main-wrapper product-base main-height-wrapper">
        <div class="panel panel-border-none sidebar">
            <ul activelink data-parent="li">
                <li class="sidebar-section">
                    <ul>
                        <li class="sidebar-section-header">
                            <div class="gizwits-icon icon-menu_ic_information"></div>
                            <span>OverView</span></li>
                        <li class="sidebar-section-menu">
                            <a href="/gateway/{{$input}}">基本信息</a></li>
                    </ul>
                </li>
                <li class="sidebar-section">
                    <ul>
                        <li class="sidebar-section-header">
                            <div class="gizwits-icon icon-menu_ic_information"></div>
                            <span>Traffic</span></li>
                        <li class="sidebar-section-menu">
                            <a href="/gateway/{{$input}}/traffic/list">数据展示</a></li>
                    </ul>
                </li>
                <li class="sidebar-section">
                    <ul>
                        <li class="sidebar-section-header">
                            <div class="gizwits-icon icon-menu_ic_information"></div>
                            <span>Settings</span></li>
                        <li class="sidebar-section-menu">
                            <a href="/gateway/{{$input}}/setting">网关设置</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        {{--显示部分--}}
    <div class="panel product-main">
        <div class="container-fluid">
            <div class="container">
                <div class="col-md-12 column">
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <h2 class="col-md-12 column" align="center">数据列表展示</h2>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <ul class="pagination">
                            <li class="active"><a href="/gateway/{{$input}}/traffic/list">数据列表</a></li>
                            <li><a href="/gateway/{{$input}}/traffic/graph">数据趋势图</a></li>
                        </ul>
                    </div>
                    <div class="jumbotron well">
                        <div class="form-h orizontal">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>时间</th>
                                    {{--<th>纬度</th>--}}
                                    {{--<th>经度</th>--}}
                                    {{--<th>高度</th>--}}
                                    <th>接收无线数据包数量</th>
                                    <th>接收已授权数据包数量</th>
                                    <th>转发无线数据包数量</th>
                                    <th>已授权上行数据占比</th>
                                    <th>接收下行数据包数量</th>
                                    <th>发送数据包数量</th>
                                </tr>
                                </thead>
                                @foreach($time as $times)
                                    <tbody>
                                    <tr>
                                        <td>{{date('Y-m-d H:i:s',$times['createdTime'])}}</td>
                                        {{--<td>{{$times->lati}}</td>--}}
                                        {{--<td>{{$times->long}}</td>--}}
                                        {{--<td>{{$times->alti}}</td>--}}
                                        <td>{{$times['data']['stat']['rxnb']}}</td>
                                        <td>{{$times['data']['stat']['rxok']}}</td>
                                        <td>{{$times['data']['stat']['rxfw']}}</td>
                                        <td>{{$times['data']['stat']['ackr']}}%</td>
                                        <td>{{$times['data']['stat']['dwnb']}}</td>
                                        <td>{{$times['data']['stat']['txnb']}}</td>
                                    </tr>
                                    </tbody>
                                @endforeach
                                {{ $time->links() }}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection