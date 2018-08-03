@extends('layouts.app')
@section('content')
    <link href="/css/base.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    {{--导航栏下侧内容--}}
    <div class="panel spotlight">
        <div class="container">
            <div class="main-wrapper">
                <ol class="breadcrumb_giz">
                    <li><a href="/client">应用详情 </a></li>
                    <li class="active"><a href="/client/{{$input}}">{{$name}}</a></li>
                    <li class="active">应用设置</li>
                </ol>
                <div class="spotlight-button">
                    <a class="btn btn-primary" href="/client"> 返回</a>
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
                            <a href="/client/{{$input}}">基本信息</a></li>
                    </ul>
                </li>
                {{--<li class="sidebar-section">--}}
                    {{--<ul>--}}
                        {{--<li class="sidebar-section-header">--}}
                            {{--<div class="gizwits-icon icon-menu_ic_information"></div>--}}
                            {{--<span>Devices</span></li>--}}
                        {{--<li class="sidebar-section-menu">--}}
                            {{--<a href="/client/{{$input}}/device">设备信息</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                <li class="sidebar-section">
                    <ul>
                        <li class="sidebar-section-header">
                            <div class="gizwits-icon icon-menu_ic_information"></div>
                            <span>Settings</span></li>
                        <li class="sidebar-section-menu">
                            <a href="/client/{{$input}}/setting">应用设置</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        {{--显示部分--}}
        <div class="panel product-main">
        <div class="container-fluid">
            <div class="container">
                </br>
                </br>
                </br>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="jumbotron well">
                    {{--<ul class="pagination">--}}
                        {{--<li><a href="/client/{{$input}}/setting">应用名称设置</a></li>--}}
                        {{--<li><a href="/client/{{$input}}/setting/appeui">应用AppEUI设置</a></li>--}}
                    {{--</ul>--}}
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <h4 class="col-md-12 column" align="left">应用名称设置</h4>
                        </div>
                    </div>
                    <form class="form form-horizontal " role="form" method="POST" action="/client/{{$input}}/setting">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="field-wrapper form-group">
                                <label class="col-sm-3 control-label">应用名称：</label>
                                <div class="col-sm-9">
                                    <input type="text" required="" validate="" class="form-control " name="name"
                                           value="{{$name}}" placeholder="不填则不修改应用名称">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            {{--<a class="btn btn-default" id="db_add_cancel" data-dismiss="modal">取消</a>--}}
                            <input class="btn btn-primary" type="submit" value="修改">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection