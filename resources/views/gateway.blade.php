@extends('help')
@section('help')
    <div class="panel product-main">
        <div class="container-fluid">
            <div class="container">
                <div class="col-md-12 column">
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <h2 class="col-md-12 column" align="center">网关管理页面</h2>
                        </div>
                    </div>
                    <div class="jumbotron well">
                        <h4>1.列表展示用户下的所有网关，可点击进去查看具体网关的详情信息，也可以删除用户不需要的网关：</h4>
                        <img src="/images/gatewayM.png" />
                       <h4>2.网关注册：用户点击右上角的网关注册键，输入注册所需的信息（注：网关ID必须是唯一的8字节长数据）
                            ，即可成功注册网关：</h4>
                        <img src="/images/gatewayM2.png" />
                        <h4>3.网关信息查看、修改：点击进入网关详情之后，可以查看网关属性信息、网关的传输数据以及修改网关的属性：</h4>
                        <img src="/images/gatewayM3.png" />
                        <h4>列表展示网关数据：</h4>
                        <img src="/images/gatewayM4.png" />
                        <h4>趋势图展示网关数据：</h4>
                        <img src="/images/gatewayM5.png" />
                        <h4>网关属性修改：</h4>
                        <img src="/images/gatewayM6.png" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection