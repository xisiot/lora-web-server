@extends('layouts.app')
@section('content')
    <link href="/css/base.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    {{ csrf_field() }}
    <div class="panel spotlight">
        <div class="container">
            <div class="main-wrapper">
                <ol class="breadcrumb_giz">
                    <li><a href="/help">帮助</a></li>
                </ol>
                <div class="spotlight-button">
                    <a class="btn btn-primary" data-toggle="modal"
                       data-target=".contact-us-modal">联系我们</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade contact-us-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">联系我们</h4>
                </div>
                <div class="modal-body">
                    <p>联系邮箱为：{{$email}}</p>
                </div>
                <div class="modal-footer">
                    <form action="/help" method="POST">
                        {!! csrf_field() !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <input type="submit" class="btn btn-primary" value="确认">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="main-wrapper product-base main-height-wrapper">
        <div class="panel panel-border-none sidebar">
            <ul activelink data-parent="li">
                <li class="sidebar-section">
                    <ul>
                        <li class="sidebar-section-header">
                            <div class="gizwits-icon icon-menu_ic_information"></div>
                            <span>OverView</span></li>
                        <li class="sidebar-section-menu">
                            <a href="/help">概览</a></li>
                    </ul>
                </li>
                <li class="sidebar-section">
                    <ul>
                        <li class="sidebar-section-header">
                            <div class="gizwits-icon icon-menu_ic_information"></div>
                            <span>Gateway Management</span></li>
                        <li class="sidebar-section-menu">
                            <a href="/help/gateway">网关管理</a></li>
                    </ul>
                </li>
                <li class="sidebar-section">
                    <ul>
                        <li class="sidebar-section-header">
                            <div class="gizwits-icon icon-menu_ic_information"></div>
                            <span>Application Management</span></li>
                        <li class="sidebar-section-menu">
                            <a href="/help/client">应用管理</a></li>
                    </ul>
                </li>
                <li class="sidebar-section">
                    <ul>
                        <li class="sidebar-section-header">
                            <div class="gizwits-icon icon-menu_ic_information"></div>
                            <span>Device Management</span></li>
                        <li class="sidebar-section-menu">
                            <a href="/help/device">设备管理</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        @yield('help')
    </div>
    @endsection