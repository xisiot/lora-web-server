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
                        <li><a href="/gateway/{{$input}}/setting">型号设置</a></li>
                        <li><a href="/gateway/{{$input}}/setting/frequencyPlan">频段设置</a></li>
                        <li><a href="/gateway/{{$input}}/setting/type">类型设置</a></li>
                        <li class="active"><a href="/gateway/{{$input}}/setting/location">地理位置设置</a></li>
                    </ul>
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <h4 class="col-md-12 column" align="left">网关地理位置设置</h4>
                        </div>
                    </div>
                    <form class="form form-horizontal " role="form" method="POST" action="/gateway/{{$input}}/setting/location">
                        {{ csrf_field() }}
                        <div class="field-wrapper form-group">
                            <label class="col-sm-3 control-label">地理位置（location）</label>
                            <div class="col-sm-2">
                                <select  validate="" class="form-control " name ="longitude">
                                    @if($longitude=='E')
                                            <option value="E" selected="selected">东经</option>
                                            <option value="W">西经</option>
                                        @endif
                                    @if($longitude=='W')
                                            <option value="W" selected="selected">西经</option>
                                            <option value="E">东经</option>
                                        @endif
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="text"  validate="" class="form-control " name="longitudeData" value="{{$longitudeData}}"
                                       placeholder="{{$longitudeData}} 不填则不修改原数据">
                            </div>
                        </div>
                        <div class="field-wrapper form-group">
                            <div class="col-sm-3 control-label"></div>
                            <div class="col-sm-2">
                                <select  validate="" class="form-control " name ="latitude">
                                    @if($latitude=='N')
                                        <option value="N" selected="selected">北纬</option>
                                        <option value="S">南纬</option>
                                    @endif
                                    @if($latitude=='S')
                                        <option value="S" selected="selected">南纬</option>
                                        <option value="N">北纬</option>
                                        @endif
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="text"  validate="" class="form-control " name="latitudeData" value="{{$latitudeData}}"
                                       placeholder="{{$latitudeData}} 不填则不修改原数据">
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