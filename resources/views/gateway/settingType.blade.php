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
                        <li class="active"><a href="/gateway/{{$input}}/setting/type">类型设置</a></li>
                        <li><a href="/gateway/{{$input}}/setting/location">地理位置设置</a></li>
                    </ul>
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <h4 class="col-md-12 column" align="left">网关类型设置</h4>
                        </div>
                    </div>
                    <form class="form form-horizontal " role="form" method="POST" action="/gateway/{{$input}}/setting/type">
                        {{ csrf_field() }}
                        <div class="field-wrapper form-group">
                            <label class="col-sm-3 control-label">类型（type）</label>
                            <div class="col-sm-6">
                                <select required="" validate="" class="form-control " name ="type">
                                    @if($type=='indoor')
                                        <option value="indoor" selected="selected">indoor</option>
                                        <option value="outdoor">outdoor</option>
                                    @endif
                                    @if($type=='outdoor')
                                        <option value="outdoor" selected="selected">outdoor</option>
                                        <option value="indoor">indoor</option>
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

