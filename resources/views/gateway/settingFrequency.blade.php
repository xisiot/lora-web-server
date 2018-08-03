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
                        <li class="active"><a href="/gateway/{{$input}}/setting/frequencyPlan">频段设置</a></li>
                        <li><a href="/gateway/{{$input}}/setting/type">类型设置</a></li>
                        <li><a href="/gateway/{{$input}}/setting/location">地理位置设置</a></li>
                    </ul>
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <h4 class="col-md-12 column" align="left">网关频段设置</h4>
                        </div>
                    </div>
                    <form class="form form-horizontal " role="form" method="POST" action="/gateway/{{$input}}/setting/frequencyPlan">
                        {{ csrf_field() }}
                        <div class="field-wrapper form-group">
                            <label class="col-sm-3 control-label">频段（frequency plan）</label>
                            <div class="col-sm-6">
                                <select  required="" validate="" class="form-control " name ="frequencyPlan">
                                        @if($frequencyPlan=='Asia 920-923MHz')
                                        <option value="{{$frequencyPlan}}" selected="selected">{{$frequencyPlan}}</option>
                                        <option value="Asia 923-925MHz">Asia 923-925MHz</option>
                                        <option value="Australia 915MHz">Australia 915MHz</option>
                                        <option value="China 433MHz">China 433MHz</option>
                                        <option value="China 470-510MHz">China 470-510MHz</option>
                                        <option value="Europe 868MHz">Europe 868MHz</option>
                                        <option value="India 865-867MHz">India 865-867MHz</option>
                                        <option value="Korea 920-923MHz">Korea 920-923MHz</option>
                                        <option value="United States 915MHz">United States 915MHz</option>
                                            @endif
                                        @if($frequencyPlan=='Asia 923-925MHz')
                                            <option value="{{$frequencyPlan}}" selected="selected">{{$frequencyPlan}}</option>
                                            <option value="Asia 920-923MHz" >Asia 920-923MHz</option>
                                            <option value="Australia 915MHz">Australia 915MHz</option>
                                            <option value="China 433MHz">China 433MHz</option>
                                            <option value="China 470-510MHz">China 470-510MHz</option>
                                            <option value="Europe 868MHz">Europe 868MHz</option>
                                            <option value="India 865-867MHz">India 865-867MHz</option>
                                            <option value="Korea 920-923MHz">Korea 920-923MHz</option>
                                            <option value="United States 915MHz">United States 915MHz</option>
                                        @endif
                                        @if($frequencyPlan=='Australia 915MHz')
                                            <option value="{{$frequencyPlan}}" selected="selected">{{$frequencyPlan}}</option>
                                            <option value="Asia 920-923MHz" >Asia 920-923MHz</option>
                                            <option value="Asia 923-925MHz">Asia 923-925MHz</option>
                                            <option value="China 433MHz">China 433MHz</option>
                                            <option value="China 470-510MHz">China 470-510MHz</option>
                                            <option value="Europe 868MHz">Europe 868MHz</option>
                                            <option value="India 865-867MHz">India 865-867MHz</option>
                                            <option value="Korea 920-923MHz">Korea 920-923MHz</option>
                                            <option value="United States 915MHz">United States 915MHz</option>
                                        @endif
                                        @if($frequencyPlan=='China 433MHz')
                                            <option value="{{$frequencyPlan}}" selected="selected">{{$frequencyPlan}}</option>
                                            <option value="Asia 920-923MHz" >Asia 920-923MHz</option>
                                            <option value="Asia 923-925MHz">Asia 923-925MHz</option>
                                            <option value="Australia 915MHz">Australia 915MHz</option>
                                            <option value="China 470-510MHz">China 470-510MHz</option>
                                            <option value="Europe 868MHz">Europe 868MHz</option>
                                            <option value="India 865-867MHz">India 865-867MHz</option>
                                            <option value="Korea 920-923MHz">Korea 920-923MHz</option>
                                            <option value="United States 915MHz">United States 915MHz</option>
                                        @endif
                                            @if($frequencyPlan=='China 470-510MHz')
                                                <option value="{{$frequencyPlan}}" selected="selected">{{$frequencyPlan}}</option>
                                                <option value="Asia 920-923MHz" >Asia 920-923MHz</option>
                                                <option value="Asia 923-925MHz">Asia 923-925MHz</option>
                                                <option value="Australia 915MHz">Australia 915MHz</option>
                                                <option value="China 433MHz">China 433MHz</option>
                                                <option value="Europe 868MHz">Europe 868MHz</option>
                                                <option value="India 865-867MHz">India 865-867MHz</option>
                                                <option value="Korea 920-923MHz">Korea 920-923MHz</option>
                                                <option value="United States 915MHz">United States 915MHz</option>
                                            @endif
                                            @if($frequencyPlan=='Europe 868MHz')
                                                <option value="{{$frequencyPlan}}" selected="selected">{{$frequencyPlan}}</option>
                                                <option value="Asia 920-923MHz" >Asia 920-923MHz</option>
                                                <option value="Asia 923-925MHz">Asia 923-925MHz</option>
                                                <option value="Australia 915MHz">Australia 915MHz</option>
                                                <option value="China 433MHz">China 433MHz</option>
                                                <option value="China 470-510MHz">China 470-510MHz</option>
                                                <option value="India 865-867MHz">India 865-867MHz</option>
                                                <option value="Korea 920-923MHz">Korea 920-923MHz</option>
                                                <option value="United States 915MHz">United States 915MHz</option>
                                            @endif
                                            @if($frequencyPlan=='India 865-867MHz')
                                                <option value="{{$frequencyPlan}}" selected="selected">{{$frequencyPlan}}</option>
                                                <option value="Asia 920-923MHz" >Asia 920-923MHz</option>
                                                <option value="Asia 923-925MHz">Asia 923-925MHz</option>
                                                <option value="Australia 915MHz">Australia 915MHz</option>
                                                <option value="China 433MHz">China 433MHz</option>
                                                <option value="China 470-510MHz">China 470-510MHz</option>
                                                <option value="Europe 868MHz">Europe 868MHz</option>
                                                <option value="Korea 920-923MHz">Korea 920-923MHz</option>
                                                <option value="United States 915MHz">United States 915MHz</option>
                                            @endif
                                            @if($frequencyPlan=='Korea 920-923MHz')
                                                <option value="{{$frequencyPlan}}" selected="selected">{{$frequencyPlan}}</option>
                                                <option value="Asia 920-923MHz" >Asia 920-923MHz</option>
                                                <option value="Asia 923-925MHz">Asia 923-925MHz</option>
                                                <option value="Australia 915MHz">Australia 915MHz</option>
                                                <option value="China 433MHz">China 433MHz</option>
                                                <option value="China 470-510MHz">China 470-510MHz</option>
                                                <option value="Europe 868MHz">Europe 868MHz</option>
                                                <option value="India 865-867MHz">India 865-867MHz</option>
                                                <option value="United States 915MHz">United States 915MHz</option>
                                            @endif
                                            @if($frequencyPlan=='United States 915MHz')
                                                <option value="{{$frequencyPlan}}" selected="selected">{{$frequencyPlan}}</option>
                                                <option value="Asia 920-923MHz" >Asia 920-923MHz</option>
                                                <option value="Asia 923-925MHz">Asia 923-925MHz</option>
                                                <option value="Australia 915MHz">Australia 915MHz</option>
                                                <option value="China 433MHz">China 433MHz</option>
                                                <option value="China 470-510MHz">China 470-510MHz</option>
                                                <option value="Europe 868MHz">Europe 868MHz</option>
                                                <option value="India 865-867MHz">India 865-867MHz</option>
                                                <option value="Korea 920-923MHz">Korea 920-923MHz</option>
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