@extends('layouts.app')
@section('content')
    <link href="/css/base.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <div class="panel spotlight">
        <div class="container">
            <div class="main-wrapper">
                <ol class="breadcrumb_giz">
                    <li><a href="/gateway">网关管理</a></li>
                    <li><a href="/gateway/register">注册</a></li>
                </ol>
                <div class="spotlight-button">
                    <a class="btn btn-primary" href="/gateway"> 返回</a>
                </div>
            </div>
        </div>
    </div>
    <div class="main-wrapper product-base main-height-wrapper">
        <div class="panel product-main">
            <div class="container">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <div class="row clearfix">
                                <div class="col-md-12 column">
                                    <h3 class="col-md-12 column" align="center">网关注册</h3>
                                </div>
                            </div>
                            </br>
                            <div class="jumbotron well">

                <form class="form form-horizontal " role="form" method="POST" action="{{ url('/gateway/register') }}" >
                    {{ csrf_field() }}
                    <div class="field-wrapper form-group">
                        <label class="col-sm-3 control-label">网关ID:</label>
                        <div class="col-sm-6">
                            <input type="text" required="" validate="" maxlength=16 class="form-control " name="gatewayID"
                                   placeholder="网关ID必须是唯一的且为8字节长" onKeyUp="keypress1()" id="GatewayID"
                                   pattern="[0-9a-fA-F]{0,16}" >
                        </div>
                        <label class="col-sm-3" id="name1">需输入16位十六进制数</label>
                    </div>
                    <div class="field-wrapper form-group">
                        <label class="col-sm-3 control-label">类型:</label>
                        <div class="col-sm-6">
                            <select  validate="" class="form-control " name ="type">
                                <option value="indoor" selected="selected">indoor</option>
                                <option value="outdoor">outdoor</option>
                            </select>
                        </div>
                    </div>
                    <div class="field-wrapper form-group">
                        <label class="col-sm-3 control-label">频段:</label>
                        <div class="col-sm-6">
                            <select  validate="" class="form-control " name ="frequencyPlan">
                                <option value="Asia 920-923MHz" selected="selected">Asia 920-923MHz</option>
                                <option value="Asia 923-925MHz">Asia 923-925MHz</option>
                                <option value="Australia 915MHz">Australia 915MHz</option>
                                <option value="China 433MHz">China 433MHz</option>
                                <option value="China 470-510MHz">China 470-510MHz</option>
                                <option value="Europe 868MHz">Europe 868MHz</option>
                                <option value="India 865-867MHz">India 865-867MHz</option>
                                <option value="Korea 920-923MHz">Korea 920-923MHz</option>
                                <option value="United States 915MHz">United States 915MHz</option>
                            </select>
                        </div>
                    </div>
                    <div class="field-wrapper form-group">
                        <label class="col-sm-3 control-label">型号:</label>
                        <div class="col-sm-6">
                            <select  validate="" class="form-control " name ="model">
                                <option value="X01" selected="selected">X01</option>
                                <option value="X02">X02</option>
                                <option value="X03">X03</option>
                            </select>
                        </div>
                    </div>
                    <div class="field-wrapper form-group">
                        <label class="col-sm-3 control-label">地理位置:</label>
                        <div class="col-sm-3">
                            <select  validate="" class="form-control " name ="longitude">
                                <option value="E" selected="selected">东经</option>
                                <option value="W">西经</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" required="" validate="" class="form-control "id="longitudeData" name="longitudeData"
                                   placeholder="经度值,如116" pattern="([0-9]|1[0-7][0-9]|180|[0-9][0-9])?(\.[0-9]{0,})?">
                        </div>
                        <label class="col-sm-3" id="name1">需输入<=180的值</label>
                    </div>
                    <div class="field-wrapper form-group">
                        <div class="col-sm-3 control-label"></div>
                        <div class="col-sm-3">
                            <select  validate="" class="form-control " name ="latitude">
                                <option value="N" selected="selected">北纬</option>
                                <option value="S">南纬</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" required="" validate="" class="form-control " id="latitudeData" name="latitudeData"
                                   placeholder="纬度值,如39.5" pattern="([0-9]|90|[0-8][0-9])?(\.[0-9]{0,})?">
                        </div>
                        <label class="col-sm-3" id="name1">需输入<=90的值</label>
                    </div>
                    <center>
                        <input class="btn btn-primary" type="submit" value="注册">
                    </center>
                </form>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
<script>
    function keypress1() //GatewayID输入长度处理
    {
        var text1=document.getElementById("GatewayID").value;
        var len=16-text1.length;
        var show="需输入"+len+"位十六进制数";
        document.getElementById("name1").innerText=show;
    }
    var text1=document.getElementById("GatewayID");
    text1.oninvalid = function(event) {
        event.target.setCustomValidity('请输入正确的十六进制数');
    }
</script>
@endsection
