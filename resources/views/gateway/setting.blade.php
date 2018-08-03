@extends('gateway.settingBlade')
@section('gatewaySetting')
    <div class="panel product-main">
        <div class="container-fluid">
            <div class="container">
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
                        <li class="active"><a href="/gateway/{{$input}}/setting">型号设置</a></li>
                        <li><a href="/gateway/{{$input}}/setting/frequencyPlan">频段设置</a></li>
                        <li><a href="/gateway/{{$input}}/setting/type">类型设置</a></li>
                        <li><a href="/gateway/{{$input}}/setting/location">地理位置设置</a></li>
                    </ul>
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <h4 class="col-md-12 column" align="left">网关型号设置</h4>
                        </div>
                    </div>
                <form class="form form-horizontal " role="form" method="POST" action="/gateway/{{$input}}/setting">
                    {{ csrf_field() }}
                    <div class="field-wrapper form-group">
                        <label class="col-sm-3 control-label">型号（model）</label>
                        <div class="col-sm-6">
                            <select  required="" validate="" class="form-control " name ="model">
                                @if($model=='X01')
                                    <option value="X01" selected="selected">X01</option>
                                    <option value="X02">X02</option>
                                    <option value="X03">X03</option>
                                    @endif
                                @if($model=='X02')
                                        <option value="X02" selected="selected">X02</option>
                                        <option value="X01">X01</option>
                                        <option value="X03">X03</option>
                                    @endif
                                @if($model=='X03')
                                        <option value="X03" selected="selected">X03</option>
                                        <option value="X01">X01</option>
                                        <option value="X02">X02</option>
                                    @endif
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <div class="col-sm-offset-6 col-sm-3" ><input class="btn btn-primary" type="submit" value="修改"></div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    @endsection