@extends('help')
@section('help')
    <div class="panel product-main">
        <div class="container-fluid">
            <div class="container">
                <div class="col-md-12 column">
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <h2 class="col-md-12 column" align="center">设备管理页面</h2>
                        </div>
                    </div>
                    <div class="jumbotron well">
                        <h4>1.列表展示用户下的所有设备，可点击进去查看具体设备的详情信息，也可以删除用户不需要的设备：</h4>
                        <img src="/images/deviceM.png" />
                        <h4>2.设备注册：用户点击右上角的设备注册键，输入注册所需的信息（注：其中的DevEUI和AppKey用户可选择自动生成）
                            ，即可成功注册设备：</h4>
                        <h4>OTAA注册模式：</h4>
                        <img src="/images/deviceM2.png" />
                        <h4>ABP注册模式：</h4>
                        <img src="/images/deviceM3.png" />
                        <h4>3.设备信息查看、修改：点击进入设备详情之后，可以查看设备属性信息、设备的上、下行数据以及修改设备的属性：</h4>
                        <img src="/images/deviceM4.png" />
                        <h4>上行数据展示：</h4>
                        <img src="/images/deviceM5.png" />
                        <h4>下行数据页面：可发送下行数据，并且所有发送的历史数据会以列表形式展示：</h4>
                        <img src="/images/deviceM6.png" />
                        <h4>设备属性修改：</h4>
                        <img src="/images/deviceM7.png" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection