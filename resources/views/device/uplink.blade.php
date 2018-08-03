@extends('layouts.app')
@section('content')
    <link href="/css/base.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    {{--导航栏下侧内容--}}
    <div class="panel spotlight">
        <div class="container">
            <div class="main-wrapper">
                <ol class="breadcrumb_giz">
                    <li><a href="/device">设备详情 </a></li>
                    <li class="active"><a href="/device/{{$input}}">{{$input}}</a></li>
                    <li class="active">上行数据</li>
                </ol>
                <div class="spotlight-button">
                    <a class="btn btn-primary" href="/device"> 返回</a>
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
                            <a href="/device/{{$input}}">基本信息</a></li>
                    </ul>
                </li>
                <li class="sidebar-section">
                    <ul>
                        <li class="sidebar-section-header">
                            <div class="gizwits-icon icon-menu_ic_information"></div>
                            <span>Traffic</span></li>
                        <li class="sidebar-section-menu">
                            <a href="/device/{{$input}}/data">数据展示</a></li>
                    </ul>
                </li>
                {{--<li class="sidebar-section">--}}
                {{--<ul>--}}
                {{--<li class="sidebar-section-header">--}}
                {{--<div class="gizwits-icon icon-menu_ic_information"></div>--}}
                {{--<span>Settings</span></li>--}}
                {{--<li class="sidebar-section-menu">--}}
                {{--<a href="/device/{{$input}}/setting">设备设置</a></li>--}}
                {{--</ul>--}}
                {{--</li>--}}
            </ul>
        </div>

        {{--显示部分--}}
        <div class="panel product-main">
            <div class="container-fluid">
                <div class="container">
                    <div class="col-md-12 column">
                        <ul class="pagination">
                            <li><a href="/device/{{$input}}/data">上行数据</a></li>
                            {{--<li class="active"><a href="/device/{{$input}}/data/uplink">应用数据</a></li>--}}
                            <li><a href="/device/{{$input}}/data/downlink">下行数据</a></li>
                        </ul>
                        <div class="row clearfix">
                            <div id="uplink" class="col-md-12 column">
                                <h4 class="col-md-12 column" align="left">应用数据展示</h4>
                            </div>
                        </div>
                        @if(empty($table_key))
                            <div class="alert alert-danger">
                                该设备暂时没有应用数据，请等待！
                            </div>
                        @else
                        <div class="jumbotron well">
                            <div class="form-h orizontal">
                                <table class="table table-striped">
                                    @if($deviceType == 1)
                                        <thead>
                                        @if(!empty($table_key))
                                            <tr>
                                                <td>时间</td>
                                                <td>数据类型</td>
                                                @foreach($table_key as $table_keys)
                                                    <td>{{$table_keys}}</td>
                                                @endforeach
                                            </tr>
                                        @endif
                                        </thead>
                                        <tbody>
                                        @foreach($details as $detail)
                                            <tr>
                                                <td>{{date('Y-m-d H:i:s', $detail['timestamp'])}}</td>
                                                @if(isset($detail['payload']['state']['reported']))
                                                    <td>上行</td>
                                                    @foreach($detail['payload']['state']['reported'] as $key=>$value)
                                                        @if(is_array($value))
                                                            @foreach($value as $keySec=>$valueSec)
                                                                <td>{{$valueSec}}</td>
                                                            @endforeach
                                                        @else
                                                            <td>{{$value}}</td>
                                                        @endif
                                                    @endforeach
                                                @elseif(isset($detail['payload']['state']['desired']))
                                                    <td>下行</td>
                                                    @foreach($table_key as $table_keys)
                                                        @if(isset($detail['payload']['state']['desired']['data'][$table_keys]))
                                                            <td>{{$detail['payload']['state']['desired']['data'][$table_keys]}}</td>
                                                        @else
                                                            <td>无</td>
                                                        @endif
                                                    @endforeach
                                                @endif

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    @endif
                                </table>
                                {{ $details->links() }}
                            </div>
                        </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection