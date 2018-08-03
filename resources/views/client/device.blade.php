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
                    <li class="active">设备信息</li>
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
                <li class="sidebar-section">
                    <ul>
                        <li class="sidebar-section-header">
                            <div class="gizwits-icon icon-menu_ic_information"></div>
                            <span>Devices</span></li>
                        <li class="sidebar-section-menu">
                            <a href="/client/{{$input}}/device">设备信息</a></li>
                    </ul>
                </li>
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
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <h2 class="col-md-12 column" align="center">设备信息</h2>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <a type="button" href="/device/register/ABP" class="btn btn-default" style="float:right;margin-right:20px">ABP模式设备注册</a>
                        <a type="button" href="/device/register" class="btn btn-default" style="float:right;margin-right:20px">OTAA模式设备注册</a>
                        <div style="height:50px;"></div>
                    </div>
                    @if(empty($success))
                    @else
                        <h4><waring>{{$success}}</waring></h4>
                    @endif
                    <div class="jumbotron well">
                        <div class="form-h orizontal">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>DevEUI</th>
                                    <th>AppKey</th>
                                    <th>设备激活模式</th>
                                    <th>FCntUp</th>
                                    <th>AFCntDown</th>
                                    <th>NFCntDown</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                @foreach($device as $devices)
                                    <tbody>
                                    <tr>
                                        <td ><a href="/device/{{$devices->DevEUI}}">{{$devices->DevEUI}}</a></td>
                                        <td>{{$devices->AppKey}}</td>
                                        <td>{{$devices->activationMode}}</td>
                                        <td>{{$devices->FCntUp}}</td>
                                        <td>{{$devices->AFCntDown}}</td>
                                        <td>{{$devices->NFCntDown}}</td>
                                        <td > <button class="btn btn-primary " value="{{$devices->DevEUI}}"
                                                      type="button" href="#" data-toggle="modal"
                                                      data-target=".product-delete-modal"
                                                      onclick="setdel_product_key(this)">删除</button></td>
                                    </tr>
                                    </tbody>
                                @endforeach
                                {{ $device->links() }}
                                <div class="modal fade product-delete-modal" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">删除设备</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>您确定要要删除该设备？删除后设备将无法编辑操作。</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="/device/{{$input}}/delete" method="POST">
                                                    {!! csrf_field() !!}
                                                    <input type="hidden" id="del_product_key" name="DevEUI" value="">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                                    <input type="submit" class="btn btn-primary" value="确认">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    function setdel_product_key(del_product_key) {
                                        document.getElementById("del_product_key").value = del_product_key.value;
                                    }
                                </script>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection