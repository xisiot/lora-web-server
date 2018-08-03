@extends('layouts.app')
@section('content')
    <link href="/css/base.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <div class="panel spotlight">
        <div class="container">
            <div class="main-wrapper">
                <ol class="breadcrumb_giz">
                    <li><a href="/gateway">网关管理</a></li>
                </ol>
                <div class="spotlight-button">
                    <a class="btn btn-primary" href="/gateway/register">网关注册</a>
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
                            已注册网关
                        </h3>
                    </div>
                </div>
                <div style="height:20px;"></div>
                @if(empty($success))
                @else
                    <h4><waring>{{$success}}</waring></h4>
                @endif
                @foreach($gatewayID as $xuhao=>$gatewayIDs)
                <div class="row clearfix">
                    <div class="col-md-12 column">
                        <div class="jumbotron well">
                            <div class="row clearfix">
                                <div class="col-md-5 column">
                                    <h3>
                                        <a href="/gateway/{{$gatewayIDs}}">{{$gatewayIDs}}</a>&nbsp;&nbsp;<small>网关所属者：{{$name}}</small>
                                    </h3>
                                </div>
                                <div class="col-md-3 column">
                                    <h3>
                                     &nbsp;<small>频段：{{$frequencyPlan[$xuhao]}}</small>
                                    </h3>
                                </div>
                                <div class="col-md-2 column">
                                    <h3>
                                        &nbsp;<small>型号：{{$model[$xuhao]}}</small>
                                    </h3>
                                </div>
                                <div class="col-md-2 column">
                                    <h3>
                                    </h3>
                                    <button class="btn btn-primary " value="{{$gatewayIDs}}"
                                            style="float:right;"
                                            type="button" href="#" data-toggle="modal"
                                            data-target=".product-delete-modal"
                                            onclick="setdel_product_key(this)">删除网关</button>
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
                                <h4 class="modal-title">删除网关</h4>
                            </div>
                            <div class="modal-body">
                                <p>您确定要要删除该网关？删除后网关将无法编辑操作。</p>
                            </div>
                            <div class="modal-footer">
                                <form action="/gateway/delete" method="POST">
                                    {!! csrf_field() !!}
                                    <input type="hidden" id="del_product_key" name="gatewayID" value="">
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
    </div>
@endsection