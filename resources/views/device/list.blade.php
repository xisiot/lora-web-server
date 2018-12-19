@extends('layouts.app')
@section('content')
    <link href="/css/base.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <div class="panel spotlight">
        <div class="container">
            <div class="main-wrapper">
                <ol class="breadcrumb_giz">
                    <li><a href="{{ '/device' }}">设备管理</a></li>
                </ol>
                @if(count($now_product)==0)
                @else
                    <div class="spotlight-button" data-toggle="modal" data-target=".device-register-modal">
                        <a class="btn btn-primary">设备注册</a>
                    </div>
                    {{--<div class="spotlight-button" data-toggle="modal" data-target=".device-list-modal">--}}
                    {{--<a class="btn btn-primary">选择应用</a>--}}
                    {{--</div>--}}
                @endif
            </div>
        </div>
    </div>

    <div class="main-wrapper product-base main-height-wrapper">
        <div class="panel product-main">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-md-12 column">
                        @if(count($now_product)==0)
                        <h3 class="text-left text-error">
                            暂无产品以及其下的设备
                        </h3>
                            @else
                            <h3 class="text-left text-error">
                                {{($now_product)?($now_product[0]->name):'暂未选择'}}设备
                            </h3>
                        @endif
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
                <div style="height:20px;"></div>
                @if(empty($success))
                @else
                    <h4><waring>{{$success}}</waring></h4>
                @endif
                @if(count($now_product)==0)
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-dismissable alert-info">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><strong></strong></h4> 尚未添加任何产品，请先创建产品！
                            </div>
                        </div>
                    </div>
                @else
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>LoRa设备唯一标识符</th>
                                <th>AES-128密钥</th>
                                <th>激活模式</th>
                                <th>LoRaWAN版本</th>
                                <th>设备地址</th>
                                <th>网络会话密钥</th>
                                <th>应用会话密钥</th>
                                <th>创建时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($devices as $device)
                                <tr>
                                    <td><a href="{{ url('/device/'.$device->DevEUI) }}">{{$device->DevEUI}}</a></td>
                                    <td>{{($device->AppKey)?$device->AppKey:'暂无'}}</td>
                                    <td>{{$device->activationMode}}</td>
                                    <td>{{$device->ProtocolVersion}}</td>
                                    <td>{{($device->DevAddr==null)?'暂无':$device->DevAddr}}</td>
                                    <td>{{($device->NwkSKey==null)?'暂无':$device->NwkSKey}}</td>
                                    <td>{{($device->AppSKey==null)?'暂无':$device->AppSKey}}</td>
                                    <td>{{$device->createdAt}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $devices->links() }}
                    </div>
                </div>
                    @endif
            </div>
        </div>
    </div>


    <div class="modal fade device-list-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">选择产品</h4>
                </div>
                <form class="form form-horizontal " role="form" method="POST" action="{{ '/device' }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="field-wrapper form-group">
                            <label class="col-sm-3 control-label">选择产品 <span class="indict">*</span></label>
                            <div class="col-sm-6">
                                <select name="product_key">
                                    @if(count($products)==0)
                                        <option value=""></option>
                                        @else
                                    @foreach($products as $product)
                                        <option value="{{$product->AppEUI}}"
                                        <?php if (isset($now_product[0]->AppEUI)) {
                                            if (($now_product[0]->AppEUI) === $product->AppEUI) echo 'selected';
                                        }?>>
                                            {{$product->name}}</option>
                                    @endforeach
                                        @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" id="db_add_cancel" data-dismiss="modal">取消</a>
                        <input class="btn btn-primary" type="submit" value="确定"></div>
                </form>
            </div>
        </div>
    </div>
    <!-- /. change device list modal  -->

    <div class="modal fade device-register-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">LoRa设备注册</h4>
                </div>
                <form class="form form-horizontal" method="POST" action="{{ '/device/register' }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        {{--@if(count($now_product)==0)--}}
                            {{--@else--}}
                        {{--<input type="hidden" id="AppEUI" name="AppEUI" value="{{($now_product)?($now_product[0]->AppEUI):null}}">--}}
                        {{--@endif--}}
                        <div class="field-wrapper form-group">
                            <label class="col-sm-5 control-label">设备激活模式 <span class="indict">*</span></label>
                            <div class="col-sm-7">
                                <select class="form-control" name="activationMode" id="activationMode" onchange="change()">
                                    <option value="OTAA" selected="selected">OTAA</option>
                                    <option value="ABP">ABP</option>
                                </select>
                            </div>
                        </div>
                        <div class="field-wrapper form-group">
                            <label class="col-sm-5 control-label">LoRaWAN版本 <span class="indict">*</span></label>
                            <div class="col-sm-7">
                                <select class="form-control" name="ProtocolVersion">
                                    <option value="1.0.2" selected="selected"> LoRaWAN 1.0.2</option>
                                    <option value="1.1"> LoRaWAN 1.1</option>
                                </select>
                            </div>
                        </div>
                        <div class="field-wrapper form-group">
                            <label class="col-sm-5 control-label">所属应用名称<span class="indict">*</span></label>
                            <div class="col-sm-7">
                                <select  validate="" class="form-control " name ="AppEUI">
                                    @foreach($AppEUI as $xuhao=>$AppEUIS)
                                        <option value="{{$AppEUIS}}" selected="selected">{{$AppEUIName[$xuhao]}}        AppEUI:{{$AppEUIS}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="OTA">
                            <div class="field-wrapper form-group">
                                <label class="col-sm-5 control-label">LoRa设备唯一标识符(DevEUI) <span class="indict">*</span></label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="text" name="DevEUI_OTA" required="required"
                                           maxlength=16 pattern="[0-9a-fA-F]{0,16}" value="{{($DevEUI_ABP)?$DevEUI_ABP:null}}"
                                           id="DevEUI_OTA">
                                </div>
                            </div>
                            <div class="field-wrapper form-group">
                                <label class="col-sm-5 control-label">AES-128密钥 <span class="indict">*</span></label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="text" name="AppKey_OTA" required="required"
                                           maxlength=32 pattern="[0-9a-fA-F]{0,32}" value="{{($NwKSKey_ABP)?$NwKSKey_ABP:null}}"
                                           id="AppKey_OTA">
                                </div>
                            </div>
                        </div>
                        <div id="ABP" style="display:none">
                            <div class="field-wrapper form-group">
                                <label class="col-sm-5 control-label"> <span class="indict"></span></label>
                                <div class="col-sm-7">
                                    <span class="ilb" data-toggle="popover" tabindex="999" data-target="#template_name">
                                        <i class="fa ">ABP模式已为您自动生成以下字段，您可修改</i>
                                    </span>
                                </div>
                            </div>
                            <div class="field-wrapper form-group">
                                <label class="col-sm-5 control-label">设备使用频段 <span class="indict">*</span></label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="frequencyPlan">
                                        <option value="433" selected="selected"> 433 MHz</option>
                                        <option value="787"> 787 MHz</option>
                                        <option value="868"> 868 MHz</option>
                                        <option value="915"> 915 MHz</option>
                                    </select>
                                </div>
                            </div>
                            <div class="field-wrapper form-group">
                                <label class="col-sm-5 control-label">LoRa设备唯一标识符(DevEUI) <span class="indict">*</span></label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="text" name="DevEUI_ABP" required="required"
                                           maxlength=16 pattern="[0-9a-fA-F]{0,16}" value="{{($DevEUI_ABP)?$DevEUI_ABP:null}}">
                                </div>
                            </div>
                            <div class="field-wrapper form-group">
                                <label class="col-sm-5 control-label">设备地址(DevAddr) <span class="indict">*</span></label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="text" name="DevAddr_ABP"
                                           maxlength=8 pattern="[0-9a-fA-F]{0,8}" value="{{($DevAddr_ABP)?$DevAddr_ABP:null}}">
                                </div>
                            </div>
                            <div class="field-wrapper form-group">
                                <label class="col-sm-5 control-label">网络会话密钥(NwkSKey) <span class="indict">*</span></label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="text" name="NwkSKey_ABP"
                                           maxlength=32 pattern="[0-9a-fA-F]{0,32}" value="{{($NwKSKey_ABP)?$NwKSKey_ABP:null}}">
                                </div>
                            </div>
                            <div class="field-wrapper form-group">
                                <label class="col-sm-5 control-label">应用会话密钥(AppSKey) <span class="indict">*</span></label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="text" name="AppSKey_ABP"
                                           maxlength=32 pattern="[0-9a-fA-F]{0,32}" value="{{($AppSKey_ABP)?$AppSKey_ABP:null}}">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" id="db_add_cancel" data-dismiss="modal">取消</a>
                        <input class="btn btn-primary" type="submit" value="创建"></div>
                </form>
            </div>
        </div>
    </div>
    <!-- /. LoRa device register modal  -->

    <script>
        {{--LoRa设备注册时选择不同的激活模式展示的form表单--}}
        function change() {
            var ABP=document.getElementById("activationMode");
            var activationMode=ABP.options[ABP.selectedIndex].value;
            if(activationMode == "ABP"){
                document.getElementById("ABP").style.display="";
                document.getElementById("OTA").style.display="none";
                document.getElementById('DevEUI_OTA').required = false;
                document.getElementById('AppKey_OTA').required = false;
            }
            else{
                document.getElementById("ABP").style.display="none";
                document.getElementById("OTA").style.display="";
            }
        }
    </script>
@endsection