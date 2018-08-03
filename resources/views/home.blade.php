@extends('layouts.app')

@section('content')
    <div class="container" class="text-center">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title" class="text-center">Congratulations!</h3>
                    </div>
                    <div class="panel-body" class="text-center">You are logged in!<br>
                        3秒后实现自动跳转~<br>
                        <a herf="/all">点击此处跳转至首页~</a>
                    </div>
                    <meta http-equiv="refresh" content="3;URL=/all">
                </div>
            </div>
        </div>
    </div>
@endsection