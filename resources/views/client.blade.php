@extends('help')
@section('help')
    <div class="panel product-main">
        <div class="container-fluid">
            <div class="container">
                <div class="col-md-12 column">
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <h2 class="col-md-12 column" align="center">应用管理页面</h2>
                        </div>
                    </div>
                    <div class="jumbotron well">
                        <h4>1.列表展示用户下的所有应用，可点击进去查看具体应用的详情信息，也可以删除用户不需要的应用：</h4>
                        <img src="/images/applicationM.png" />
                        <h4>2.应用注册：用户点击右上角的添加应用键，输入注册所需的信息（注：AppEUI是后台自动生成的唯一8字节长数据）
                            ，即可成功注册应用：</h4>
                        <img src="/images/applicationM2.png" />
                        <h4>3.应用信息查看、修改：点击进入网关详情之后，可以查看网关属性信息、该应用下的所属设备以及修改应用的属性：</h4>
                        <img src="/images/applicationM3.png" />
                        <h4> 其中该应用下的所属设备可点击进去查看该设备的具体详情，可直接删除不需要的设备，还可以直接跳转至两种设备注册：</h4>
                        <img src="/images/applicationM4.png" />
                        <h4>修改应用的属性:</h4>
                        <img src="/images/applicationM5.png" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection