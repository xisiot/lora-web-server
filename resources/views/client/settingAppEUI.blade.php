@extends('client.detail')
@section('client')
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
                        <li><a href="/client/{{$input}}/setting">应用名称设置</a></li>
                        <li><a href="/client/{{$input}}/setting/appeui">应用AppEUI设置</a></li>
                    </ul>
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <h4 class="col-md-12 column" align="left">应用AppEUI设置</h4>
                        </div>
                    </div>
                    <form class="form form-horizontal " role="form" method="POST" action="/client/{{$input}}/setting/appeui">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="field-wrapper form-group">
                                <label class="col-sm-3 control-label">AppEUI：</label>
                                <div class="col-sm-9" >
                                    <input type="text" class="form-control" placeholder="移除现有的AppEUI,生成新的AppEUI" value="{{$AppEUI}}"
                                           readonly="readonly" />
                                    <input type="hidden" name="setAppEUI" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            {{--<a class="btn btn-default" id="db_add_cancel" data-dismiss="modal">取消</a>--}}
                            <input class="btn btn-primary" type="submit" value="修改">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection