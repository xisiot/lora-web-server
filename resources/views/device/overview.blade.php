@extends('device.detail')
@section('device')
    {{--显示部分--}}
    <div class="panel product-main">
        <div class="container-fluid">
            <div class="container">
                @if(empty($success))
                @else
                    <div class="col-md-offset-2"><h4>{{$success}}</h4></div>
                @endif
                <div class="col-md-12 column">
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <h2 class="col-md-12 column" align="center">设备信息展示</h2>
                        </div>
                    </div>
                    <br>
                    <div class="jumbotron well">
                        <div class="row clearfix">
                            <div  class="col-md-3 column">
                                <h4 align="right">DevEUI：</h4>
                            </div>
                            <div  class="col-md-6 column">
                                <h4 align="left">{{$input}}</h4>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div  class="col-md-3 column">
                                <h4 align="right">AppKey：</h4>
                            </div>
                            <div  class="col-md-6 column">
                                <h4 align="left">{{$AppKey}}</h4>
                            </div>
                        </div>
                        <div class="row clearfix" align="right">
                            <div  class="col-md-3 column">
                                <h4>激活模式：</h4>
                            </div>
                            <div class="col-md-6" align="left">
                                <h4>{{$activationMode}}</h4>
                            </div>
                        </div>
                        @if(!empty($DevAddr))
                        <div class="row clearfix" align="right">
                            <div  class="col-md-3 column">
                                <h4>DevAddr：</h4>
                            </div>
                            <div class="col-md-6" align="left">
                                <h4>{{$DevAddr}}</h4>
                            </div>
                        </div>
                            @endif
                        <div class="row clearfix">
                            <div  class="col-md-3 column" align="right">
                                <h4>创建时间：</h4>
                            </div>
                            <div  class="col-md-6 column" align="left">
                                <h4>{{$createdAt}}</h4>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div  class="col-md-3 column" align="right">
                                <h4>更新时间：</h4>
                            </div>
                            <div  class="col-md-6 column" align="left">
                                <h4>{{$updatedAt}}</h4>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection