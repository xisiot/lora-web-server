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
                    <li class="active">设备设置</li>
                    <li class="active">所属应用设置</li>
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
                            <span>Devices</span></li>
                        <li class="sidebar-section-menu">
                            <a href="/device/{{$input}}/data">传输数据</a></li>
                    </ul>
                </li>
                <li class="sidebar-section">
                    <ul>
                        <li class="sidebar-section-header">
                            <div class="gizwits-icon icon-menu_ic_information"></div>
                            <span>Settings</span></li>
                        <li class="sidebar-section-menu">
                            <a href="/device/{{$input}}/setting">设备设置</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="panel product-main">
        <div class="container-fluid">
            <div class="container">
                <div class="col-md-12 column">
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
                        <ul class="pagination">
                            <li><a href="/device/{{$input}}/setting">DevEUI设置</a></li>
                            <li class="active"><a href="/device/{{$input}}/setting/appeui">所属应用设置</a></li>
                        </ul>
                        <div class="row clearfix">
                            <div class="col-md-12 column">
                                <h4 class="col-md-12 column" align="left">所属应用设置</h4>
                            </div>
                        </div>
                        <form class="form form-horizontal " role="form" method="POST" action="/device/{{$input}}/setting/appeui">
                            {{ csrf_field() }}
                            <div class="field-wrapper form-group">
                                <label class="col-sm-3 control-label">所属应用名称（AppName）</label>
                                <div class="col-sm-8">
                                    <select  validate="" class="form-control " name ="AppEUI">
                                        @foreach($AppEUI as $xuhao=>$AppEUIs)
                                            <option value="{{$AppEUIs}}" selected="selected">{{$AppEUIName[$xuhao]}}        AppEUI:{{$AppEUIs}}</option>
                                        @endforeach
                                    </select>
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
    </div>

    <div class="modal fade DevEUI-auto-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">自动生成</h4>
                </div>
                <div class="modal-body">
                    <p>您确定要自动生成DevEUI？自动生成则该输入框无法输入您希望的DevEUI。</p>
                </div>
                <div class="modal-footer">
                    <form action="/device/{{$input}}/setting/autoDevEUI" method="POST">
                        {!! csrf_field() !!}
                        <input type="hidden" id="DevEUIFigPost1" name="DevEUIFig" value="">
                        <input type="hidden" id="AppKeyFigPost1" name="AppKeyFig" value="">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <input type="submit" class="btn btn-primary" value="确认">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade DevEUI-input-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">手动输入</h4>
                </div>
                <div class="modal-body">
                    <p>您确定要手动输入DevEUI？确定后您将手动输入您希望的DevEUI。</p>
                </div>
                <div class="modal-footer">
                    <form action="/device/{{$input}}/setting/inputDevEUI" method="POST">
                        {!! csrf_field() !!}
                        <input type="hidden" id="DevEUIFigPost2" name="DevEUIFig" value="">
                        <input type="hidden" id="AppKeyFigPost2" name="AppKeyFig" value="">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <input type="submit" class="btn btn-primary" value="确认">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function autoDevEUI() {
            document.getElementById("DevEUIFigPost1").value = 0;
            document.getElementById("AppKeyFigPost1").value = document.getElementById("AppKeyFig").value;
        }
        function inputDevEUI() {
            document.getElementById("DevEUIFigPost2").value = 1;
            document.getElementById("AppKeyFigPost2").value = document.getElementById("AppKeyFig").value;
        }
    </script>
    </div>
@endsection