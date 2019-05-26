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
                    <li class="active">下行数据</li>
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
                            <li><a href="/device/{{$input}}/data" >上行数据</a></li>
                            <li><a href="/device/{{$input}}/data/uplink">应用数据</a></li>
                            <li class="active"><a href="/device/{{$input}}/data/downlink"  >下行数据</a></li>
                        </ul>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(empty($success))
                    @else
                        <div class="alert alert-danger">
                            <li>{{$success}}</li>
                        </div>
                    @endif
                    <div class="row clearfix">
                        <div id="downlink" class="col-md-12 column">
                            <h4 class="col-md-12 column" align="left">已发送的下行数据</h4>
                        </div>
                    </div>
                    <div class="jumbotron well">
                        <div class="form-h orizontal">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>时间</th>
                                    <th>数据</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $datas)
                                    <tr>
                                        <td>{{date('Y-m-d H:i:s',$datas['createdTime'])}}</td>
                                        <td>
                                            {{dump($datas['data'])}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection