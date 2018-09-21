<?php

namespace App\Http\Controllers\device;

date_default_timezone_set('prc');
use function GuzzleHttp\Psr7\str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
Use App\Rules\DevAddrRule;
Use App\Rules\DevEUIRule;
Use App\Rules\NwkSKeyRule;
Use App\Rules\AppKeyRule;
Use App\Rules\AppSKeyRule;
use App\Rules\DownlinkRule;
use App\Rules\AppEUIRule;

class deviceController extends Controller
{
    //展示用户所有设备
    public function index(Request $request)
    {
        $user = Auth::user();
        $userID=md5($user->email);
        $products = DB::table('AppInfo')->where('userID',$userID)->orderBy('updatedAt','desc')->get();
        if ($request->get('product_key')) { //用户选择应用后
            $product_key = $request->get('product_key');
            $now_product = DB::table('AppInfo')->where('AppEUI',$product_key)->get();
        } elseif (session('product_key')) { //从session中拿到的数据
            $product_key = session('product_key');
            $now_product = DB::table('AppInfo')->where('AppEUI',$product_key)->get();
            if (count($now_product)==0) {
                $product_key = (isset($products[0]->AppEUI))?($products[0]->AppEUI):null;
                $now_product = DB::table('AppInfo')->where('AppEUI',$product_key)->get();
            }
        } else {  //若都没有，则自动拿表中第一条数据
            $product_key = (isset($products[0]->AppEUI))?($products[0]->AppEUI):null;
            $now_product = DB::table('AppInfo')->where('AppEUI',$product_key)->get();
        }
        session_start();
        session(['product_key'=>$product_key]);
        $devices = DB::table('DeviceInfo')->where('AppEUI', $product_key)->orderBy('updatedAt', 'desc')->paginate(10);
        $DevEUI_ABP=$this->GetRandom(16);
        //判断生成的DevEUI是否是唯一的
        $DevEUIs = DB::table('DeviceInfo')->pluck('DevEUI');
        for( $i=0;$i<count($DevEUIs);$i++){
            if ( $DevEUI_ABP == $DevEUIs[$i] ) {
                $DevEUI_ABP=$this->GetRandom(16);
                $i=0;
            }
        }
        $DevAddr_ABP=$this->GetRandom(8);
        //判断生成的DevAddr是否是唯一的
        $DevAddrs=DB::table('DeviceInfo')->pluck('DevAddr');
        for($i=0;$i<count($DevAddrs);$i++) {
            if ($DevAddr_ABP == $DevAddrs[$i]){
                $DevAddr_ABP=$this->GetRandom(8);
                $i=0;
            }
        }
        $NwKSKey_ABP=$this->GetRandom(32);
        $AppSKey_ABP=$this->GetRandom(32);
        $success='';
        return view('device/list')->with(['now_product' => $now_product, 'products' => $products,
                'devices' => $devices, 'DevEUI_ABP'=>$DevEUI_ABP,'DevAddr_ABP'=>$DevAddr_ABP
                ,'NwKSKey_ABP'=>$NwKSKey_ABP,'AppSKey_ABP'=>$AppSKey_ABP,'success' => $success]);
    }
    //设备注册后台处理
    public function register(Request $request){
        if($request->get('activationMode')=='OTAA'){
            $DevEUIGet = $request->get('DevEUI_OTA');
            $AppEUIGet = $request->get('AppEUI');
            $AppKeyGet = $request->get('AppKey_OTA');
            $ProtocolVersion=$request->get('ProtocolVersion');
            //判断注册的DevEUI是否唯一
            $DevEUIs = DB::table('DeviceInfo')->pluck('DevEUI');
//            $AppKeys=DB::table('DeviceInfo')->pluck('AppKey');
//            for($i=0;$i<count($AppKeys);$i++) {
//                if ($AppKeyGet == $AppKeys[$i]){
//                     return redirect('/device')->withErrors('您输入的AES-128密钥已存在，请重新注册');
//                }
//            }
            for( $i=0;$i<count($DevEUIs);$i++){
                if ( $DevEUIGet == $DevEUIs[$i] ) {
                    return redirect('/device')->withErrors('您输入的LoRa设备唯一标识符已存在，请重新注册');
                }
            }
            //OTA设备注册信息写入
            $url="http://47.93.221.82:12235/device";
            $header=array("Content-Type"=>"application/x-www-form-urlencoded");
            $body=array("AppEUI" => $AppEUIGet, "DevEUI" => $DevEUIGet,"AppKey" => $AppKeyGet,);
            $curl = curl_init($url);
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($body),
                CURLOPT_HTTPHEADER => $header,
                CURLOPT_HEADER => false,
                CURLOPT_NOBODY => false,
            ));
            curl_exec($curl);
            curl_close($curl);
            return redirect('/device')->withErrors('设备成功注册');
        }
        else{
            $DevEUIGet = $request->get('DevEUI_ABP');
            $AppEUIGet = $request->get('AppEUI');
            $ProtocolVersion=$request->get('ProtocolVersion');
            $DevAddrGet=$request->get('DevAddr_ABP');
            $AppSKeyGet=$request->get('AppSKey_ABP');
            $NwkSKeyGet=$request->get('NwkSKey_ABP');
            $frequencyPlan=$request->get('frequencyPlan');
            $time=date('Y-m-d H:i:s');
            //判断注册的DevEUI和DevAddr是否唯一
            $DevEUIs = DB::table('DeviceInfo')->pluck('DevEUI');
            $DevAddrs=DB::table('DeviceInfo')->pluck('DevAddr');
            for($i=0;$i<count($DevAddrs);$i++) {
                if ($DevAddrGet == $DevAddrs[$i]){
                    return redirect('/device')->withErrors('您输入的设备地址已存在，请重新注册');
                }
            }
            for( $i=0;$i<count($DevEUIs);$i++){
                if ( $DevEUIGet == $DevEUIs[$i] ) {
                    return redirect('/device')->withErrors('您输入的LoRa设备唯一标识符已存在，请重新注册');
                }
            }
            $DevNonce=$this->GetRandom(4);
            $product_key=$AppEUIGet.$AppEUIGet;
            //ABP设备注册信息写入 DeviceInfo表
            DB::table('DeviceInfo')->insert(
                [
                    'productKey'=>$product_key,
                    'AppEUI' => $AppEUIGet,
                    'DevEUI' => $DevEUIGet,
                    'DevAddr'=>$DevAddrGet,
                    'AppSKey'=>$AppSKeyGet,
                    'NwkSKey'=>$NwkSKeyGet,
                    'activationMode'=>'ABP',
                    'ProtocolVersion' => $ProtocolVersion,
                    'createdAt'=>$time,
                    'updatedAt'=>$time,
                    'DevNonce'=>$DevNonce,
                ]
            );
            if($frequencyPlan==433){
                $ChMask='00FF';
                $CFList='330A6833029832FAC832F2F832EB2832E35832DB8832D3B8';
                $ChDrRange='5050505050505050';
                $RX1CFList='330A6833029832FAC832F2F832EB2832E35832DB8832D3B8';
                $RX2Freq=434.665;
                $RX2DataRate=0;
                $MaxEIRP=12.15;
            }
            else if($frequencyPlan==915){
                $ChMask='FF00000000000000FF';
                $CFList='7CC5687CBD987CB5C87CADF87CA6287C9E587C96887C8EB8';
                $ChDrRange='5050505050505050';
                $RX1CFList='7E44387E2CC87E15587DFDE87DE6787DCF087DB7987DA028';
                $RX2Freq=923.300;
                $RX2DataRate=8;
                $MaxEIRP=30;
            }
            else if($frequencyPlan==868){
                $ChMask='00FF';
                $CFList='756A987562C8755AF8755328754B58754388753BB87533E8';
                $ChDrRange='5050505050505050';
                $RX1CFList='756A987562C8755AF8755328754B58754388753BB87533E8';
                $RX2Freq=869.525;
                $RX2DataRate=0;
                $MaxEIRP=16;
            }
            else if($frequencyPlan==787){
                $ChMask='00FF';
                $CFList='67E5A867DDD867D60867CE3867c66867BE9867B6C867AEF8';
                $ChDrRange='5050505050505050';
                $RX1CFList='67E5A867DDD867D60867CE3867c66867BE9867B6C867AEF8';
                $RX2Freq=786.000;
                $RX2DataRate=0;
                $MaxEIRP=12.15;
            }
            //ABP设备配置信息写入 DeviceConfig表
            DB::table('DeviceConfig')->insert([
                'DevAddr'=>$DevAddrGet,
                'frequencyPlan'=>$frequencyPlan,
                'ADR'=>0,
                'ChMask'=>$ChMask,
                'CFList'=>$CFList,
                'ChDrRange'=>$ChDrRange,
                'RX1CFList'=>$RX1CFList,
                'RX2Freq'=>$RX2Freq,
                'RX2DataRate'=>$RX2DataRate,
                'MaxEIRP'=>$MaxEIRP,
                'createdAt'=>$time,
                'updatedAt'=>$time,
            ]);
            return redirect('/device')->withErrors('设备成功注册');
        }
    }
    //设备详情数据页面
    public function input($input){
        $DevAddr=DB::table('DeviceInfo')->where('DevEUI',$input)->value('DevAddr');
        $AppKey=DB::table('DeviceInfo')->where('DevEUI',$input)->value('AppKey');
        $activationMode=DB::table('DeviceInfo')->where('DevEUI',$input)->value('activationMode');
        $AppEUI=DB::table('DeviceInfo')->where('DevEUI',$input)->value('AppEUI');
        $name=DB::table('AppInfo')->where('AppEUI',$AppEUI)->value('name');
        $createdAt=DB::table('AppInfo')->where('AppEUI',$AppEUI)->value('createdAt');
        $updatedAt=DB::table('AppInfo')->where('AppEUI',$AppEUI)->value('updatedAt');
        $success='';
        return view('device/overview')->with(['input'=>$input,'success'=>$success,'name'=>$name,
            'activationMode'=>$activationMode,'DevAddr'=>$DevAddr,'AppKey'=>$AppKey,'createdAt'=>$createdAt,
            'updatedAt'=>$updatedAt]);
    }
    //设备上行数据页面
    public function data($input){
        $DevAddr=DB::table('DeviceInfo')->where('DevEUI',$input)->value('DevAddr');
        $device = DB::table('DeviceInfo')->where('DevEUI',$input)->first();
        $datas = DB::connection('mongodb')->collection('lora_productKey_'.$device->productKey)->where('DevAddr',$DevAddr)
            ->where('msgType', 'UPLINK_MSG')->orderBy('createdTime', 'desc')->paginate(10);
        return view('device/data')->with(['input'=>$input,'data'=>$datas]);
    }
    //设备应用数据页面
    public function upLink($input){
        \Log::info(Auth::user()->email . "------->Show device details--------->");
        $device = DB::table('DeviceInfo')->where('DevEUI',$input)->first();
        $now_timestamp=time();
        $old_timestamp=$now_timestamp-60*20;
        $data = DB::connection('mongodb')->collection('productKey:'.$device->productKey)->where('did',$device->did)
            ->where('operation', 'update')->whereBetween('timestamp',[$old_timestamp,$now_timestamp])->orderBy('timestamp', 'desc')->get();
        if(count($data)==0){
            $data = DB::connection('mongodb')->collection('productKey:'.$device->productKey)->where('did',$device->did)
                ->where('operation', 'update')->orderBy('timestamp', 'desc')->first();
            if(isset($data['payload']['state']['reported'])){
                $data_reported=$data['payload']['state']['reported'];
                while(isset($data_reported)) {
                    $table_key = array();
                    while ($key = key($data_reported)) {
                        if (is_array($data_reported[$key])) {
                            while ($key_in = key($data_reported[$key])) {
                                array_push($table_key, $key_in);
                                next($data_reported[$key]);
                            }
                            next($data_reported);
                        }else {
                            array_push($table_key, $key);
                            next($data_reported);
                        }
                    }
                    $deviceType = 1;// 空气、水位等payload有值的设备
                    $details = DB::connection('mongodb')->collection('productKey:' . $device->productKey)->where('did', $device->did)
                        ->where('operation', 'update')->orderBy('timestamp', 'desc')->paginate(10);
                    return view('device/uplink')->with(['input'=>$input,'device' => $device, 'deviceType' => $deviceType,
                        'details' => $details, 'data' => $data, 'table_key' => $table_key]);
                }
            }
            elseif(isset($data['timestamp'])){
                $now_timestamp=$data['timestamp'];
                $old_timestamp=$now_timestamp-60*20;
                $data = DB::connection('mongodb')->collection('productKey:'.$device->productKey)->where('did',$device->did)
                    ->where('operation', 'update')->whereBetween('timestamp',[$old_timestamp,$now_timestamp])->orderBy('timestamp', 'desc')->get();
                for($i=0;$i<count($data);$i++){
                    if(isset($data[$i]['payload']['state']['reported'])){
                        $data_reported=$data[$i]['payload']['state']['reported'];
                        while(isset($data_reported)) {
                            $table_key = array();
                            while ($key = key($data_reported)) {
                                if (is_array($data_reported[$key])) {
                                    while ($key_in = key($data_reported[$key])) {
                                        array_push($table_key, $key_in);
                                        next($data_reported[$key]);
                                    }
                                    next($data_reported);
                                }else {
                                    array_push($table_key, $key);
                                    next($data_reported);
                                }
                            }
                            $deviceType = 1;// 空气、水位等payload有值的设备
                            $details = DB::connection('mongodb')->collection('productKey:' . $device->productKey)->where('did', $device->did)
                                ->where('operation', 'update')->orderBy('timestamp', 'desc')->paginate(10);
                            return view('device/device_detail_lora_upLink')->with(['device' => $device, 'deviceType' => $deviceType,
                                'details' => $details, 'data' => $data, 'table_key' => $table_key]);
                        }
                    }
                    if($i==count($data)&&!isset($data[$i]['payload']['state']['reported'])){
                        $data = DB::connection('mongodb')->collection('productKey:'.$device->productKey)->where('did',$device->did)
                            ->where('operation', 'update')->orderBy('timestamp', 'asc')->get(1);
                        $data_reported=$data[$i]['payload']['state']['reported'];
                        while(isset($data_reported)) {
                            $table_key = array();
                            while ($key = key($data_reported)) {
                                if (is_array($data[$key])) {
                                    while ($key_in = key($data_reported[$key])) {
                                        array_push($table_key, $key_in);
                                        next($data_reported[$key]);
                                    }
                                    next($data_reported);
                                } else {
                                    array_push($table_key, $key);
                                    next($data_reported);
                                }
                            }
                            $deviceType = 1;// 空气、水位等payload有值的设备
                            $details = DB::connection('mongodb')->collection('productKey:' . $device->productKey)->where('did', $device->did)
                                ->where('operation', 'update')->orderBy('timestamp', 'desc')->paginate(10);
                            return view('device/uplink')->with(['input'=>$input,'device' => $device, 'deviceType' => $deviceType,
                                'details' => $details, 'data' => $data, 'table_key' => $table_key]);
                        }
                    }
                }

            }
            else{
                $table_key=array();
                $deviceType = 1;// 空气、水位等payload有值的设备
                $details = DB::connection('mongodb')->collection('productKey:' . $device->productKey)->where('did', $device->did)
                    ->where('operation', 'update')->orderBy('timestamp', 'desc')->paginate(10);
                return view('device/uplink')->with(['input'=>$input,'device' => $device, 'deviceType' => $deviceType,
                    'details' => $details, 'data' => $data, 'table_key' => $table_key]);
            }
        }
        for($i=0;$i<count($data);$i++){
            if(isset($data[$i]['payload']['state']['reported'])){
                $data_reported=$data[$i]['payload']['state']['reported'];
                while(isset($data_reported)) {
                    $table_key = array();
                    while ($key = key($data_reported)) {
                        if (is_array($data_reported[$key])) {
                            while ($key_in = key($data_reported[$key])) {
                                array_push($table_key, $key_in);
                                next($data_reported[$key]);
                            }
                            next($data_reported);
                        }else {
                            array_push($table_key, $key);
                            next($data_reported);
                        }
                    }
                    $deviceType = 1;// 空气、水位等payload有值的设备
                    $details = DB::connection('mongodb')->collection('productKey:' . $device->productKey)->where('did', $device->did)
                        ->where('operation', 'update')->orderBy('timestamp', 'desc')->paginate(10);
                    return view('device/uplink')->with(['input'=>$input,'device' => $device, 'deviceType' => $deviceType,
                        'details' => $details, 'data' => $data, 'table_key' => $table_key]);
                }
            }
            if($i==count($data)&&!isset($data[$i]['payload']['state']['reported'])){
                $data = DB::connection('mongodb')->collection('productKey:'.$device->productKey)->where('did',$device->did)
                    ->where('operation', 'update')->orderBy('timestamp', 'asc')->get(1);
                $data_reported=$data[$i]['payload']['state']['reported'];
                while(isset($data_reported)) {
                    $table_key = array();
                    while ($key = key($data_reported)) {
                        if (is_array($data[$key])) {
                            while ($key_in = key($data_reported[$key])) {
                                array_push($table_key, $key_in);
                                next($data_reported[$key]);
                            }
                            next($data_reported);
                        } else {
                            array_push($table_key, $key);
                            next($data_reported);
                        }
                    }
                    $deviceType = 1;// 空气、水位等payload有值的设备
                    $details = DB::connection('mongodb')->collection('productKey:' . $device->productKey)->where('did', $device->did)
                        ->where('operation', 'update')->orderBy('timestamp', 'desc')->paginate(10);
                    return view('device/uplink')->with(['input'=>$input,'device' => $device, 'deviceType' => $deviceType,
                        'details' => $details, 'data' => $data, 'table_key' => $table_key]);
                }
            }
        }
    }
    //设备下行数据页面
    public function downLink($input){
        $success='';
        $DevAddr=DB::table('DeviceInfo')->where('DevEUI',$input)->value('DevAddr');
        $device = DB::table('DeviceInfo')->where('DevEUI',$input)->first();
        $datas = DB::connection('mongodb')->collection('lora_productKey_'.$device->productKey)->where('DevAddr',$DevAddr)
            ->where('msgType', 'UPLINK_MSG')->orderBy('createdTime', 'desc')->paginate(10);
        return view('device/downlink')->with(['success'=>$success,'input'=>$input,'data'=>$datas]);
    }
    //发送下行数据TODO
    public function downLinkPost($input,Request $request){
        //表单验证
        $request->validate([
            'downlink' => ['required',new DownlinkRule()],
        ]);
        $downlink=$request->get('downlink');
        $DevAddr=DB::table('DeviceInfo')->where('DevEUI',$input)->value('DevAddr');
        if(empty($DevAddr)){
            $success='该设备的DevAddr暂不存在，请等待~';
            $DevAddr=DB::table('DeviceInfo')->where('DevEUI',$input)->value('DevAddr');
            $datas=DB::table('DeviceDownlink')->where('DevAddr',$DevAddr)->orderBy('createdAt','desc')->simplePaginate(5);
            return view('device/downlink')->with(['input'=>$input,'data'=>$datas,'success'=>$success]);
        }
        $DevAddrs=DB::table('DeviceDownlink')->pluck('DevAddr');
        for($i=0;$i<count($DevAddrs);$i++){
            if($DevAddrs[$i] == $DevAddr ){
                $isSent=DB::table('DeviceDownlink')->where('DevAddr',$DevAddr)->pluck('isSent');
                for($j=0;$j<count($isSent);$j++){
                    if($isSent[$j]==false) {
                        $success = '该设备存在未发送下行数据，请稍后发送~';
                        $DevAddr = DB::table('DeviceInfo')->where('DevEUI', $input)->value('DevAddr');
                        $datas = DB::table('DeviceDownlink')->where('DevAddr', $DevAddr)->orderBy('createdAt', 'desc')->simplePaginate(5);
                        return view('device/downlink')->with(['input' => $input, 'data' => $datas, 'success' => $success]);
                    }
                }
                $time=date('Y-m-d H:i:s');
                DB::table('DeviceDownlink')->insert([
                    'FRMPayload'=>$downlink,
                    'DevAddr'=>$DevAddr,
                    'createdAt'=>$time,
                    'updatedAt'=>$time,
                    'isSent'=>false
                ]);
                $success='下行数据正在等待发送，请等候~';
                $DevAddr=DB::table('DeviceInfo')->where('DevEUI',$input)->value('DevAddr');
                $datas=DB::table('DeviceDownlink')->where('DevAddr',$DevAddr)->orderBy('createdAt','desc')->simplePaginate(5);
                return view('device/downlink')->with(['input'=>$input,'data'=>$datas,'success'=>$success]);
            }
        }
        $time=date('Y-m-d H:i:s');
        DB::table('DeviceDownlink')->insert([
            'FRMPayload'=>$downlink,
            'DevAddr'=>$DevAddr,
            'createdAt'=>$time,
            'updatedAt'=>$time,
            'isSent'=>false
        ]);
        $success='下行数据正在等待发送，请等候~';
        $DevAddr=DB::table('DeviceInfo')->where('DevEUI',$input)->value('DevAddr');
        $datas=DB::table('DeviceDownlink')->where('DevAddr',$DevAddr)->orderBy('createdAt','desc')->simplePaginate(5);
        return view('device/downlink')->with(['input'=>$input,'data'=>$datas,'success'=>$success]);
    }
    //设备属性设置
    public function setting($input){
        $user=Auth::user()->email;
        $userID=md5($user);
        $AppEUIName=DB::table('AppInfo')->where('userId',$userID)->orderBy('updatedAt','desc')->pluck('name');
        $AppEUI=DB::table('AppInfo')->where('userId',$userID)->orderBy('updatedAt','desc')->pluck('AppEUI');
        $DevEUIFig=1;
        $AppKey=DB::table('DeviceInfo')->where('DevEUI',$input)->value('AppKey');
        $DevAddr=DB::table('DeviceInfo')->where('DevEUI',$input)->value('DevAddr');
        $NwkSKey=DB::table('DeviceInfo')->where('DevEUI',$input)->value('NwkSkey');
        $AppSKey=DB::table('DeviceInfo')->where('DevEUI',$input)->value('AppSkey');
        return view('device/setting')->with(['input'=>$input,'AppEUI'=>$AppEUI,'AppEUIName'=>$AppEUIName,'DevEUIFig'=>$DevEUIFig,
            'AppKey'=>$AppKey,'DevAddr'=>$DevAddr,'NwkSKey'=>$NwkSKey,'AppSKey'=>$AppSKey]);
    }
    public function settingPost($input,Request $request){
            //表单验证
            $request->validate([
                'DevEUI' =>['required',new DevEUIRule()],
            ]);
            $DevEUIGet=$request->get('DevEUI');
            $DevEUIs=DB::table('DeviceInfo')->pluck('DevEUI');
            for( $i=0;$i<count($DevEUIs);$i++){
                if ( $DevEUIGet == $DevEUIs[$i] ) {
                    $success = '该DevEUI' . $DevEUIGet . '已经存在，请重新修改!!!';
                    $DevAddr=DB::table('DeviceInfo')->where('DevEUI',$input)->value('DevAddr');
                    $AppKey=DB::table('DeviceInfo')->where('DevEUI',$input)->value('AppKey');
                    $activationMode=DB::table('DeviceInfo')->where('DevEUI',$input)->value('activationMode');
                    $AppEUI=DB::table('DeviceInfo')->where('DevEUI',$input)->value('AppEUI');
                    $name=DB::table('AppInfo')->where('AppEUI',$AppEUI)->value('name');
                    return view('device/overview')->with(['input'=>$input,'success'=>$success,'name'=>$name,
                        'activationMode'=>$activationMode,'DevAddr'=>$DevAddr,'AppKey'=>$AppKey]);
                }
            }
            $AppKey=DB::table('DeviceInfo')->where('DevEUI',$input)->value('AppKey');
            $time=date('Y-m-d H:i:s');
            DB::table('DeviceInfo')->where('AppKey', $AppKey)->update(
                [
                    'DevEUI' =>$DevEUIGet,
                    'updatedAt'=>$time,
                ]);
            $input=$DevEUIGet;
            $DevAddr=DB::table('DeviceInfo')->where('DevEUI',$input)->value('DevAddr');
            $activationMode=DB::table('DeviceInfo')->where('DevEUI',$input)->value('activationMode');
            $AppEUI=DB::table('DeviceInfo')->where('DevEUI',$input)->value('AppEUI');
            $name=DB::table('AppInfo')->where('AppEUI',$AppEUI)->value('name');
            $success='已成功修改该设备的DevEUI信息!!!';
            return view('device/overview')->with(['input'=>$input,'success'=>$success,'name'=>$name,
                'activationMode'=>$activationMode,'DevAddr'=>$DevAddr,'AppKey'=>$AppKey]);
    }
    public function settingAppEUI($input){
        $user=Auth::user()->email;
        $userID=md5($user);
        $AppEUIName=DB::table('AppInfo')->where('userId',$userID)->orderBy('updatedAt','desc')->pluck('name');
        $AppEUI=DB::table('AppInfo')->where('userId',$userID)->orderBy('updatedAt','desc')->pluck('AppEUI');
        return view('device/settingAppEUI')->with(['input'=>$input,'AppEUI'=>$AppEUI,'AppEUIName'=>$AppEUIName,]);
    }
    public function settingAppEUIPost($input,Request $request){
        $request->validate([
            'AppEUI' =>'required',
        ]);
        $AppEUIGet=$request->get('AppEUI');
        $time=date('Y-m-d H:i:s');
        DB::table('DeviceInfo')->where('DevEUI', $input)->update(
            [
                'AppEUI' =>$AppEUIGet,
                'updatedAt'=>$time,
            ]);
        $DevAddr=DB::table('DeviceInfo')->where('DevEUI',$input)->value('DevAddr');
        $AppKey=DB::table('DeviceInfo')->where('DevEUI',$input)->value('AppKey');
        $activationMode=DB::table('DeviceInfo')->where('DevEUI',$input)->value('activationMode');
        $AppEUI=DB::table('DeviceInfo')->where('DevEUI',$input)->value('AppEUI');
        $name=DB::table('AppInfo')->where('AppEUI',$AppEUI)->value('name');
        $success='已成功修改该设备的所属应用信息!!!';
        return view('device/overview')->with(['input'=>$input,'success'=>$success,'name'=>$name,
            'activationMode'=>$activationMode,'DevAddr'=>$DevAddr,'AppKey'=>$AppKey]);
    }
    //应用管理中的删除设备,没用了！！！
    public function deletePost(Request $request,$input){
        $DevEUIGet=$request->get('DevEUI');
        $DevAddr=DB::table('DeviceInfo')->where('DevEUI',$DevEUIGet)->value('DevAddr');
        if(!empty($DevAddr)) {
            DB::table('DeviceStatus')->where('DevAddr', $DevAddr)->delete();
            DB::table('DeviceDownlink')->where('DevAddr', $DevAddr)->delete();
        }
        DB::table('DeviceInfo')->where('DevEUI',$DevEUIGet)->delete();
        $name=DB::table('AppInfo')->where('AppEUI',$input)->value('name');
        $device=DB::table('DeviceInfo')->where('AppEUI',$input)->orderBy('updatedAt','desc')->simplePaginate(8);
        $success='DevEUI为：'.$DevEUIGet.'的设备已成功删除！！！';
        return view('client/device')->with(['input'=>$input,'name'=>$name,'device'=>$device,'success'=>$success]);
    }
    //设备管理中的删除设备
    public function deleteDevice(Request $request){
        $DevEUIGet=$request->get('DevEUI');
        $DevAddr=DB::table('DeviceInfo')->where('DevEUI',$DevEUIGet)->value('DevAddr');
        if(!empty($DevAddr)) {
            DB::table('DeviceStatus')->where('DevAddr', $DevAddr)->delete();
            DB::table('DeviceDownlink')->where('DevAddr', $DevAddr)->delete();
            DB::table('DeviceConfig')->where('DevAddr', $DevAddr)->delete();
            DB::table('DeviceRouting')->where('DevAddr', $DevAddr)->delete();
        }
        DB::table('DeviceInfo')->where('DevEUI',$DevEUIGet)->delete();
        $user=Auth::user()->email;
        $userID=md5($user);
        $AppEUIGet=DB::table('AppInfo')->where('userId',$userID)->orderBy('updatedAt','desc')->pluck('AppEUI');
        $DevEUI=array();
        $name=array();
        for($k=0;$k<count($AppEUIGet);$k++){
            $get1=DB::table('DeviceInfo')->where('AppEUI',$AppEUIGet[$k])->orderBy('updatedAt','desc')->pluck('DevEUI');
            $names=DB::table('AppInfo')->where('AppEUI',$AppEUIGet[$k])->value('name');
            if(!empty($get1)){
                for($j=0;$j<count($get1);$j++) {
                    array_push($DevEUI, $get1[$j]);
                    array_push($name, $names);
                }
            }
            else {}
        }
        $success='DevEUI为：'.$DevEUIGet.'的设备成功删除！！！';
        return view('device/list')->with(['success' => $success,'DevEUI'=>$DevEUI,'name'=>$name]);
    }
    //生成随机数
    public function GetRandom($weishu){
        $random='';
        for($i=0;$i<$weishu;$i++) {
            $a = dechex(mt_rand(0, 15));
            $random=$random.$a;
        }
        return $random;
    }
}
