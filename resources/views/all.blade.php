@extends('layouts.app')
@section('content')
    <link href="/css/base.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    {{ csrf_field() }}
    <div class="panel spotlight">
        <div class="container">
            <div class="main-wrapper">
                <ol class="breadcrumb_giz">
                    <li><a href="/all">概览</a></li>
                </ol>
            </div>
        </div>
    </div>

    <div class="main-wrapper product-base main-height-wrapper">
        <div class="panel product-main">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-md-12 column">
                        <h3 class="text-left text-error">
                            已注册网关、应用、设备
                        </h3>
                    </div>
                </div>
                <div class="col-md-12 column">
                    <div class="jumbotron well" href="/gateway">
                        <div class="row clearfix" >
                            <div class="col-md-2 column">
                                <img src="/images/gateway.png"/>
                            </div>
                            <div class="col-md-4 column">
                                 <h3 class="col-md-12 column">网关总数 &nbsp&nbsp&nbsp{{$count3}}</h3>
                                <h4> &nbsp    <a href="/gateway">查看详细</a></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 column">
                    <div class="jumbotron well">
                        <div class="row clearfix">
                            <div class="col-md-2 column">
                                <img src="/images/application.png"/>
                            </div>
                            <div class="col-md-4 column">
                                <h3 class="col-md-12 column">应用总数 &nbsp&nbsp&nbsp{{$count1}}</h3>
                                <h4> &nbsp    <a href="/client">查看详细</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 column">
                    <div class="jumbotron well">
                        <div class="row clearfix">
                            <div class="col-md-2 column">
                                <img src="/images/device.png"/>
                            </div>
                            <div class="col-md-4 column">
                                <h3 class="col-md-12 column">设备总数 &nbsp&nbsp&nbsp{{$count2}}</h3>
                                <h4> &nbsp    <a href="/device">查看详细</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection