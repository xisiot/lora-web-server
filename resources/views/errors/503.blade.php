@extends('layouts.app')
<style>
    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .content {
        font-size: 39px;
        margin-top: 66px;
    }

</style>
@section('content')
    <a class="panel-left pull-left green" href="/all">
        <i class="fa fa-sign-out fa-5x"></i>
    </a><br clear="both">
    <div class="flex-center content">
        503服务不可用！<a href="/all">返回</a>
    </div>
@endsection
