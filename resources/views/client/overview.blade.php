@extends('client.detail')
@section('client')
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
                            <h2 class="col-md-12 column" align="center">应用信息展示</h2>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    {!! implode('<br>', $errors->all()) !!}
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- /. alert error  -->

                    <br>
                    <div class="jumbotron well">
                        <div class="row clearfix">
                            <div  class="col-md-4 column">
                                <h4 align="right">应用名称：</h4>
                            </div>
                            <div  class="col-md-6 column">
                                <h4 align="left">{{$name[0]->name}}</h4>
                            </div>
                        </div>
                        <div class="row clearfix" align="right">
                            <div  class="col-md-4 column">
                                <h4>应用唯一标识符(AppEUI)：</h4>
                            </div>
                            <div class="col-md-6" align="left">
                                <h4>{{$input}}</h4>
                            </div>
                        </div>
                        <div class="row clearfix" align="right">
                            <div  class="col-md-4 column">
                                <h4>创建时间：</h4>
                            </div>
                            <div class="col-md-6" align="left">
                                <h4>{{$name[0]->createdAt}}</h4>
                            </div>
                        </div>
                        <div class="row clearfix" align="right">
                            <div  class="col-md-4 column">
                                <h4>更新时间：</h4>
                            </div>
                            <div class="col-md-6" align="left">
                                <h4>{{$name[0]->updatedAt}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection