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
                    <li class="active">DevEUI设置</li>
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
                        <li class="active"><a href="/device/{{$input}}/setting">DevEUI设置</a></li>
                        <li><a href="/device/{{$input}}/setting/appeui">所属应用设置</a></li>
                    </ul>
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <h4 class="col-md-12 column" align="left">DevEUI设置</h4>
                        </div>
                    </div>
                    <form class="form form-horizontal " role="form" method="POST" action="/device/{{$input}}/setting">
                        {{ csrf_field() }}
                        @if($DevEUIFig==1)
                            <div class="field-wrapper form-group">
                                <label class="col-sm-3 control-label">LoRa设备唯一标识符（DevEUI）</label>
                                <div class="col-sm-6">
                                    <input type="text" validate="" size="16" class="form-control " name="DevEUI" id="DevEUI" maxlength=16
                                           placeholder="全球唯一辨识终端设备ID且须为8字节长" value="{{$input}}"onkeyup="keypress1()" onblur="keypress1()" >
                                </div>
                                <label class="col-sm-3" id="name1">需输入0位十六进制数</label>
                            </div>
                        @endif
                        @if($DevEUIFig==0)
                            <div class="field-wrapper form-group">
                                <label class="col-sm-4 control-label">LoRa设备唯一标识符（DevEUI）</label>
                                <div class="col-sm-6">
                                    <input type="text" validate="" size="16" class="form-control " name="DevEUI"
                                           placeholder="移除现有的DevEUI，生成新的DevEUI" readonly="readonly">
                                </div>
                                <div class="col-sm-2">
                                    <input type="hidden" name="DevEUIFig" value="0">
                                    <button class="btn btn-primary " id="DevEUIFig" value="0"
                                            type="button" href="#" data-toggle="modal"
                                            data-target=".DevEUI-input-modal"
                                            onclick="inputDevEUI()">手动输入</button>
                                </div>
                            </div>
                        @endif
                        <div class="modal-footer">
                            <input class="btn btn-primary" type="submit" value="修改">
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
<script>
    function keypress1() //DevEUI输入长度处理
    {
        var text1=document.getElementById("DevEUI").value;
        var len=16-text1.length;
        var show="需输入"+len+"位十六进制数";
        document.getElementById("name1").innerText=show;
    }
</script>
    </div>
@endsection