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
                    <li class="active"><a href="/client/{{$input}}">{{$name[0]->name}}</a></li>
                    <li class="active">基本信息</li>
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
        @yield('client')
    </div>
@endsection