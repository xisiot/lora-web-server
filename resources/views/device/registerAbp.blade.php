@extends('layouts.app')
@section('content')
    <link href="/css/base.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <div class="panel spotlight">
        <div class="container">
            <div class="main-wrapper">
                <ol class="breadcrumb_giz">
                    <li><a href="/device">设备管理</a></li>
                    <li><a href="/device/register">注册</a></li>
                </ol>
                <div class="spotlight-button">
                    <a class="btn btn-primary" href="/device"> 返回</a>
                </div>
            </div>
        </div>
    </div>
    <div class="main-wrapper product-base main-height-wrapper">
        <div class="panel product-main">
            <div class="container">
                <ul class="pagination">
                    <li><a href="/device/register">OTAA注册模式</a></li>
                    <li class="active"><a href="/device/register/ABP">ABP注册模式</a></li>
                </ul>
                <div class="row clearfix">
                    <div class="col-md-12 column">
                        <h3 class="col-md-12 column" align="center">设备ABP模式注册</h3>
                    </div>
                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(!empty(session('success')))
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{session('success')}}</li>
                        </ul>
                    </div>
                @endif
                @if(!empty($successFig))
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{$successFig}}</li>
                        </ul>
                    </div>
                @endif
                <div class="jumbotron well">
                    <br>
                <form class="form form-horizontal " role="form" method="POST" action="{{ url('/device/register/ABP') }}">
                    {{ csrf_field() }}
                    @if($DevEUIFig==1)
                        <div class="field-wrapper form-group">
                            <label class="col-sm-3 control-label">LoRa设备唯一标识符（DevEUI）</label>
                            <div class="col-sm-5">
                                <input type="text" required="" validate="" maxlength=16 class="form-control " id="DevEUIInput" name="DevEUI"
                                       value="{{$DevEUIGet}}" placeholder="全球唯一辨识终端设备ID且须为8字节长" onkeyup="keypress1()"
                                       onblur="keypress1()" pattern="[0-9a-fA-F]{0,16}">
                            </div>
                            <label class="col-sm-2" id="name1">还需输入{{$needDevEUI}}位十六进制数</label>
                            <div class="col-sm-2">
                                <button class="btn btn-primary " id="DevEUIFig" value="1"
                                        type="button" href="#" data-toggle="modal"
                                        data-target=".DevEUI-auto-modal"
                                        onclick="autoDevEUI()">自动生成</button>
                            </div>
                        </div>
                    @endif
                    @if($DevEUIFig==0)
                        <div class="field-wrapper form-group">
                            <label class="col-sm-3 control-label">LoRa设备唯一标识符（DevEUI）</label>
                            <div class="col-sm-5">
                                <input type="text" required="" validate="" maxlength=16 class="form-control" id="DevEUI" name="DevEUI"
                                       value="{{$DevEUI}}" placeholder="全球唯一辨识终端设备ID且须为8字节长" onblur="keypress3()"
                                       onkeyup="keypress3()" pattern="[0-9a-fA-F]{0,16}">
                            </div>
                            <label class="col-sm-2" id="name3">还需输入{{$needDevEUI}}位十六进制数</label>
                            <div class="col-sm-2">
                                <input type="hidden" id="DevEUIFig" value="0">
                            </div>
                        </div>
                    @endif
                    @if($AppKeyFig==1)
                        <div class="field-wrapper form-group">
                            <label class="col-sm-3 control-label">******</label>
                            <div class="col-sm-5">
                                <input type="text" required="" validate="" maxlength=32 class="form-control "id="AppKeyInput" name="AppKey"
                                       value="{{$AppKeyGet}}" placeholder="AES-128密钥且须为16字节长" onblur="keypress2()"
                                       onkeyup="keypress2()" pattern="[0-9a-fA-F]{0,32}">
                            </div>
                            <label class="col-sm-2" id="name2">还需输入{{$needAppKey}}位十六进制数</label>
                            <div class="col-sm-2">
                                <button class="btn btn-primary " id="AppKeyFig" value="1"
                                        type="button" href="#" data-toggle="modal"
                                        data-target=".AppKey-auto-modal"
                                        onclick="autoAppKey()">自动生成</button>
                            </div>
                        </div>
                    @endif
                    @if($AppKeyFig==0)
                        <div class="field-wrapper form-group">
                            <label class="col-sm-3 control-label">******</label>
                            <div class="col-sm-5">
                                <input type="text" required="" validate="" maxlength=32 class="form-control " id="AppKey" name="AppKey"
                                       value="{{$AppKey}}" placeholder="AES-128密钥且须为16字节长" onblur="keypress4()"
                                       onkeyup="keypress4()" pattern="[0-9a-fA-F]{0,32}">
                            </div>
                            <label class="col-sm-2" id="name4">还需输入{{$needAppKey}}位十六进制数</label>
                            <div class="col-sm-2">
                                <input type="hidden" id="AppKeyFig" value="0">
                            </div>
                        </div>
                    @endif
                    <div class="field-wrapper form-group">
                        <label class="col-sm-3 control-label">设备地址（DevAddr）</label>
                        <div class="col-sm-5">
                            <input type="text" required="" validate="" size="8" class="form-control " maxlength=8 value="{{$DevAddr}}"
                                   name="DevAddr" placeholder="LoRa设备唯一地址且须为4字节长" id="DevAddr" onkeyup="keypress5()"
                                   onblur="keypress5()" pattern="[0-9a-fA-F]{0,8}">
                        </div>
                        <label class="col-sm-2" id="name5">还需输入{{$needDevAddr}}位十六进制数</label>
                    </div>
                    <div class="field-wrapper form-group">
                        <label class="col-sm-3 control-label">******</label>
                        <div class="col-sm-5">
                            <input type="text" required="" validate="" size="32" class="form-control " maxlength=32 value="{{$NwkSKey}}"
                                   name="NwkSKey" placeholder="网络会话密钥且须为16字节长" id="NwkSKey" onblur="keypress6()"
                                   onkeyup="keypress6()" pattern="[0-9a-fA-F]{0,32}">
                        </div>
                        <label class="col-sm-2" id="name6">还需输入{{$needNwkSKey}}位十六进制数</label>
                    </div>
                    <div class="field-wrapper form-group">
                        <label class="col-sm-3 control-label">******</label>
                        <div class="col-sm-5">
                            <input type="text" required="" validate="" size="32" class="form-control " maxlength=32 value="{{$AppSKey}}"
                                   name="AppSKey" placeholder="应用会话密钥且须为16字节长" id="AppSKey" onkeyup="keypress7()"
                                   onblur="keypress7()" pattern="[0-9a-fA-F]{0,32}">
                        </div>
                        <label class="col-sm-2" id="name7">还需输入{{$needAppSKey}}位十六进制数</label>
                    </div>
                    <div class="field-wrapper form-group">
                        <label class="col-sm-3 control-label">所属应用名称（AppName）</label>
                        <div class="col-sm-5">
                            <select  validate="" class="form-control " id="AppEUI" name ="AppEUI">
                                @foreach($AppEUI as $xuhao=>$AppEUIS)
                                    <option value="{{$AppEUIS}}" selected="selected">{{$AppEUIName[$xuhao]}}        AppEUI:{{$AppEUIS}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if(empty($successFig))
                        <center>
                            <input class="btn btn-primary" type="submit" value="注册" >
                        </center>
                    @endif
                    @if(!empty($successFig))
                        <center>
                            <input class="btn btn-primary" type="submit" value="注册" disabled="disabled">
                        </center>
                    @endif
                </form>
                    <br>
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
                <p>您确定要自动生成DevEUI？将自动生成8字节的DevEUI。</p>
            </div>
            <div class="modal-footer">
                <form action="/device/register/autoDevEUIAbp" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" id="DevEUIFigPost1" name="DevEUIFig" value="">
                    <input type="hidden" id="AppKeyFigPost1" name="AppKeyFig" value="">
                    <input type="hidden" id="AppKeyFigPost2" name="AppKey" value="">
                    <input type="hidden" id="DevAddrPost" name="DevAddr" value="">
                    <input type="hidden" id="NwkSKeyPost" name="NwkSKey" value="">
                    <input type="hidden" id="AppSKeyPost" name="AppSKey" value="">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <input type="submit" class="btn btn-primary" value="确认">
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade AppKey-auto-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">自动生成</h4>
            </div>
            <div class="modal-body">
                <p>您确定要自动生成AppKey？将自动生成16字节的AppKey。</p>
            </div>
            <div class="modal-footer">
                <form action="/device/register/autoAppKeyAbp" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" id="DevEUIFigPost4" name="DevEUI" value="">
                    <input type="hidden" id="DevEUIFigPost3" name="DevEUIFig" value="">
                    <input type="hidden" id="AppKeyFigPost3" name="AppKeyFig" value="">
                    <input type="hidden" id="DevAddrPost2" name="DevAddr" value="">
                    <input type="hidden" id="NwkSKeyPost2" name="NwkSKey" value="">
                    <input type="hidden" id="AppSKeyPost2" name="AppSKey" value="">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <input type="submit" class="btn btn-primary" value="确认">
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function autoDevEUI() //DevEUI自动生成处理
    {
        document.getElementById("DevEUIFigPost1").value = 0;
        if( document.getElementById("AppKeyFig").value == 1 ) {
            document.getElementById("AppKeyFigPost1").value = 1;
            document.getElementById("AppKeyFigPost2").value = document.getElementById("AppKeyInput").value;
        }
        else{
            document.getElementById("AppKeyFigPost1").value = 0;
            document.getElementById("AppKeyFigPost2").value = document.getElementById("AppKey").value;
        }
        document.getElementById("DevAddrPost").value = document.getElementById("DevAddr").value;
        document.getElementById("NwkSKeyPost").value = document.getElementById("NwkSKey").value;
        document.getElementById("AppSKeyPost").value = document.getElementById("AppSKey").value;
    }
    function autoAppKey() //AppKey自动生成处理
    {
        document.getElementById("AppKeyFigPost3").value =  0;
        if( document.getElementById("DevEUIFig").value==1 ){
                document.getElementById("DevEUIFigPost3").value = 1;
                document.getElementById("DevEUIFigPost4").value = document.getElementById("DevEUIInput").value;
        }
        else{
            document.getElementById("DevEUIFigPost3").value = 0;
            document.getElementById("DevEUIFigPost4").value = document.getElementById("DevEUI").value;
        }
        document.getElementById("DevAddrPost2").value = document.getElementById("DevAddr").value;
        document.getElementById("NwkSKeyPost2").value = document.getElementById("NwkSKey").value;
        document.getElementById("AppSKeyPost2").value = document.getElementById("AppSKey").value;
    }
    function keypress1() //DevEUI输入长度处理
    {
        var text1=document.getElementById("DevEUIInput").value;
        var len=16-text1.length;
        var show="还需输入"+len+"位十六进制数";
        document.getElementById("name1").innerText=show;
    }
    function keypress2()//AppKey输入长度处理
    {
        var text1=document.getElementById("AppKeyInput").value;
        var len=32-text1.length;
        var show="还需输入"+len+"位十六进制数";
        document.getElementById("name2").innerText=show;
    }
    function keypress3() //DevEUI输入长度处理
    {
        var text1=document.getElementById("DevEUI").value;
        var len=16-text1.length;
        var show="还需输入"+len+"位十六进制数";
        document.getElementById("name3").innerText=show;
    }
    function keypress4() //AppKey输入长度处理
    {
        var text1=document.getElementById("AppKey").value;
        var len=32-text1.length;
        var show="还需输入"+len+"位十六进制数";
        document.getElementById("name4").innerText=show;
    }
    function keypress5() //DevAddr输入长度处理
    {
        var text1=document.getElementById("DevAddr").value;
        var len=8-text1.length;
        var show="还需输入"+len+"位十六进制数";
        document.getElementById("name5").innerText=show;
    }
    function keypress6() //NwkSKey输入长度处理
    {
        var text1=document.getElementById("NwkSKey").value;
        var len=32-text1.length;
        var show="还需输入"+len+"位十六进制数";
        document.getElementById("name6").innerText=show;
    }
    function keypress7() //AppSKey输入长度处理
    {
        var text1=document.getElementById("AppSKey").value;
        var len=32-text1.length;
        var show="还需输入"+len+"位十六进制数";
        document.getElementById("name7").innerText=show;
    }
    var text1=document.getElementById("DevEUIInput");
    text1.oninvalid = function(event) {
        event.target.setCustomValidity('请输入正确的十六进制数');
    }
    var text2=document.getElementById("AppKeyInput");
    text2.oninvalid = function(event) {
        event.target.setCustomValidity('请输入正确的十六进制数');
    }
    var text3=document.getElementById("DevEUI");
    text3.oninvalid = function(event) {
        event.target.setCustomValidity('请输入正确的十六进制数');
    }
    var text4=document.getElementById("AppKey");
    text4.oninvalid = function(event) {
        event.target.setCustomValidity('请输入正确的十六进制数');
    }
    var text5=document.getElementById("DevAddr");
    text5.oninvalid = function(event) {
        event.target.setCustomValidity('请输入正确的十六进制数');
    }
    var text6=document.getElementById("NwkSKey");
    text6.oninvalid = function(event) {
        event.target.setCustomValidity('请输入正确的十六进制数');
    }
    var text7=document.getElementById("AppSKey");
    text7.oninvalid = function(event) {
        event.target.setCustomValidity('请输入正确的十六进制数');
    }
</script>
@endsection