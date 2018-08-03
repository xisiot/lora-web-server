@extends('layouts.app')
@section('content')
    <link href="/css/base.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <div class="panel spotlight">
        <div class="container">
            <div class="main-wrapper">
                <ol class="breadcrumb_giz">
                    <li><a href="{{ url('/client') }}">应用管理</a></li>
                </ol>
                <div class="spotlight-button">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" href="#" data-toggle="modal"
                                data-target="#myModal">添加应用</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-wrapper product-base main-height-wrapper">
        <div class="panel product-main">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-md-12 column">
                        <h3 class="text-left text-error">
                            已注册应用
                        </h3>
                    </div>
                </div>
                <div style="height:20px;"></div>
                @if(empty($success))
                @else
                    <h4><waring>{{$success}}</waring></h4>
                @endif
                @foreach($AppEUI as $xuhao=>$AppEUIs)
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <div class="jumbotron well">
                                <div class="row clearfix">
                                    <div class="col-md-4 column">
                                        <h3>
                                            <a href="/client/{{$AppEUIs}}">{{$name[$xuhao]}}</a>&nbsp;&nbsp;
                                        </h3>
                                    </div>
                                    <div class="col-md-6 column">
                                        <h3>
                                            &nbsp;&nbsp;<small>AppEUI：{{$AppEUIs}}</small>
                                        </h3>
                                    </div>
                                    <div class="col-md-2 column">
                                        <h3>
                                        </h3>
                                        <button class="btn btn-primary " value="{{$AppEUIs}}"
                                                style="float:right;"
                                                type="button" href="#" data-toggle="modal"
                                                data-target=".product-delete-modal"
                                                onclick="setdel_product_key(this)">删除应用</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="modal fade product-delete-modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">删除应用</h4>
                            </div>
                            <div class="modal-body">
                                <p>您确定要要删除该应用？删除后该应用下的所有设备也将被删除！</p>
                            </div>
                            <div class="modal-footer">
                                <form action="/client/delete" method="POST">
                                    {!! csrf_field() !!}
                                    <input type="hidden" id="del_product_key" name="AppEUI" value="">
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
            </div>
        </div>

    <!-- 模态框（Modal） -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">应用注册</h4>
                </div>
                <div class="modal-body">
                    <form class="form form-horizontal " role="form" method="POST" action="{{ url('/client') }}">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="field-wrapper form-group">
                                <label class="col-sm-3 control-label">应用名称：</label>
                                <div class="col-sm-6">
                                    <input type="text" required="" validate="" class="form-control " name="name" placeholder="应用名称">
                                </div>
                            </div>
                            <div class="field-wrapper form-group">
                                <label class="col-sm-3 control-label">AppEUI：</label>
                                <div class="col-sm-6" >
                                    <input type="text" class="form-control" placeholder="{{$newAppEUI}}  该AppEUI为系统自动生成的"
                                           name="AppEUI" value="{{$newAppEUI}}" pattern="[0-9a-fA-F]{0,16}" onKeyUp="keypress1()"
                                           maxlength=16 id="AppEUI"/>
                                </div>
                                <label class="col-sm-3" id="name1">需输入16位十六进制数</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-default" id="db_add_cancel" data-dismiss="modal">取消</a>
                            <input class="btn btn-primary" type="submit" value="创建">
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
        <script>
            function keypress1() //AppEUI输入长度处理
            {
                var text1=document.getElementById("AppEUI").value;
                var len=16-text1.length;
                var show="需输入"+len+"位十六进制数";
                document.getElementById("name1").innerText=show;
            }
            var text1=document.getElementById("AppEUI");
            text1.oninvalid = function(event) {
                event.target.setCustomValidity('请输入正确的十六进制数');
            }
        </script>
@endsection