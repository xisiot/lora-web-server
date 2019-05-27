<?php

namespace App\Http\Controllers\gateway;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Charts;
Use App\Rules\GatewaysRule;
use App\Rules\latitudeDataRule;
use App\Rules\longitudeDataRule;
use Khill\Lavacharts\Lavacharts;
date_default_timezone_set('prc');

class gatewayController extends Controller
{
    //网关首页
    public function index(){
        $user = Auth::user()->email;
        $userID=md5($user);
        $name=Auth::user()->name;
        $gatewayID=DB::table('GatewayInfo')->where('userId',$userID)->orderBy('updatedAt','desc')->pluck('gatewayId');
        $frequencyPlan=array();
        $model=array();
        for($i=0;$i<count($gatewayID);$i++) {
            $frequencyPlan[$i] = DB::table('GatewayInfo')->where('gatewayId', $gatewayID[$i])->value('frequencyPlan');
            $model[$i] = DB::table('GatewayInfo')->where('gatewayId', $gatewayID[$i])->value('model');
        }
        $success='';
        return view('gateway/list')->with(['name'=>$name,'success'=>$success,'gatewayID'=>$gatewayID,
            'frequencyPlan'=>$frequencyPlan,'model'=>$model]);
    }
    //网关注册页面
    public function register(){
        return view('gateway/register');
    }
    //注册数据存储后台
    public function store(Request $request){
        //表单验证
        $request->validate([
            'gatewayID' => ['required', new GatewaysRule()],
            'type' => 'required',
            'frequencyPlan' => 'required',
            'model' => 'required',
            'longitudeData' => ['required',new longitudeDataRule()],
            'longitude' => 'required',
            'latitudeData' => ['required',new latitudeDataRule()],
            'latitude' => 'required',
        ]);
        if(!empty($request)) {
            $gatewayID = $request->get('gatewayID');
            $type=$request->get('type');
            $frequencyPlan=$request->get('frequencyPlan');
            $model=$request->get('model');
            $location='('.$request->get('longitudeData').$request->get('longitude').','.
                $request->get('latitudeData').$request->get('latitude').')';
            $user=Auth::user()->email;
            $userID=md5($user);
            $name=Auth::user()->name;
            $gatewayIDs=DB::table('GatewayInfo')->where('userId',$userID)->pluck('gatewayId');
            for($i=0;$i<count($gatewayIDs);$i++){
                if($gatewayID == $gatewayIDs[$i]) {
                    $success = '网关ID为：' . $gatewayID . '已存在!请重新注册网关！！！';
                    $gatewayID = DB::table('GatewayInfo')->where('userId',$userID)->orderBy('updatedAt','desc')->pluck('gatewayId');
                    $frequencyPlans = array();
                    $model=array();
                    for($i=0;$i<count($gatewayID);$i++) {
                        $frequencyPlans[$i] = DB::table('GatewayInfo')->where('gatewayId', $gatewayID[$i])->value('frequencyPlan');
                        $model[$i] = DB::table('GatewayInfo')->where('gatewayId', $gatewayID[$i])->value('model');
                    }
                    return view('gateway/list')->with(['name'=>$name,'success'=>$success,'gatewayID'=>$gatewayID,
                        'frequencyPlan'=>$frequencyPlans,'model'=>$model]);
                }
            }
            $time=date('Y-m-d H:i:s');
            DB::table('GatewayInfo')->insert(
                [
                    'gatewayId' => $gatewayID,
                    'type'=>$type,
                    'frequencyPlan'=>$frequencyPlan,
                    'model'=>$model,
                    'location'=>$location,
                    'userID'=>$userID,
                    'createdAt'=>$time,
                    'updatedAt'=>$time,
                ]
            );
            $success = '网关ID为：'.$gatewayID.'注册成功！！！';
            $gatewayID = DB::table('GatewayInfo')->where('userId',$userID)->orderBy('updatedAt','desc')->pluck('gatewayId');
            $frequencyPlans = array();
            $model=array();
            for($i=0;$i<count($gatewayID);$i++) {
                $frequencyPlans[$i] = DB::table('GatewayInfo')->where('gatewayId', $gatewayID[$i])->value('frequencyPlan');
                $model[$i] = DB::table('GatewayInfo')->where('gatewayId', $gatewayID[$i])->value('model');
            }
            return view('gateway/list')->with(['success'=>$success,'name'=>$name,'gatewayID'=>$gatewayID,
                'frequencyPlan'=>$frequencyPlans,'model'=>$model]);
        }
    }
    //overview页面后台
    public function input($input){
        //gateway 信息
        $type=DB::table('GatewayInfo')->where('gatewayId', $input)->value('type');
        $location=DB::table('GatewayInfo')->where('gatewayId', $input)->value('location');
        $frequencyPlan=DB::table('GatewayInfo')->where('gatewayId', $input)->value('frequencyPlan');
        $model=DB::table('GatewayInfo')->where('gatewayId', $input)->value('model');
        $createdAt=DB::table('GatewayInfo')->where('gatewayId', $input)->value('createdAt');
        $updatedAt=DB::table('GatewayInfo')->where('gatewayId', $input)->value('updatedAt');
        $success='';
        return view('gateway/overview')->with(['input'=>$input,'basePlatform'=>$type,'createdAt'=>$createdAt,'updatedAt'=>$updatedAt,
            'frequencyPlan'=>$frequencyPlan, 'location'=>$location,'model'=>$model,'success'=>$success]);
    }
    //网关传输数据后台，返回table列表展示页面
    public function trafficList($input){
        //gateway 收到的信息
        $email = Auth::user()->email;
        $developer_id = DB::table('Developers')->where('email', $email)->value('developer_id');
        $gatewayId = strtolower($input);
        $times = DB::connection('mongodb')->collection('lora_user_'.$developer_id)->where('gatewayId',$gatewayId)
            ->where('msgType', 'GATEWAYSTAT')->orderBy('createdTime', 'desc')->paginate(10);
//        $times=DB::table('GatewayStatus')->where('gatewayId', $input)->orderBy('time','desc')->paginate(10);
        return view('gateway/traffic')->with(['input'=>$input,'time'=>$times]);
    }
    //网关传输数据后台，返回graph图表展示页面
    public function trafficGraph($input,Request $request){
        $year=($request->get('YYYY'))?$request->get('YYYY'):date('Y');
        $month=($request->get('MM'))?$request->get('MM'):date('m');
        $data=($request->get('DD'))?$request->get('DD'):date('d');
        $compareTime=$year.'-'.$month.'-'.$data.' 00:00:00';
        $nowTime = strtotime($compareTime);
        $oldTime = $nowTime - 24*60*60;
        $email = Auth::user()->email;
        $developer_id = DB::table('Developers')->where('email', $email)->value('developer_id');
        $gatewayId = strtolower($input);
        $gateway = DB::connection('mongodb')->collection('lora_user_'.$developer_id)->where('gatewayId',$gatewayId)
            ->where('msgType', 'GATEWAYSTAT')->whereBetween('createdTime', [$oldTime, $nowTime])->orderBy('createdTime', 'desc')->get();
//        $gateway=DB::table('GatewayStatus')->where('gatewayId', $input)->whereDate('createdAt', $compareTime)->orderBy('time','asc')->get();
        $time=array();
        $rxnb=array();
        $rxfw=array();
        $txnb=array();
        $dwnb=array();
        $rxok=array();
        for($i=0;$i<count($gateway);$i++) {
            $time[$i] = $gateway[$i]['createdTime'];
            $rxok[$i] = $gateway[$i]['data']['stat']['rxok'];
            $rxnb[$i] = $gateway[$i]['data']['stat']['rxnb'];
            $rxfw[$i] = $gateway[$i]['data']['stat']['rxfw'];
            $txnb[$i] = $gateway[$i]['data']['stat']['txnb'];
            $dwnb[$i] = $gateway[$i]['data']['stat']['dwnb'];
        }
        $lava = new Lavacharts;
        $chart = $lava->DataTable();
        $chart->addDateTimeColumn("时间")
            ->addNumberColumn('接收无线数据包数量')
            ->addNumberColumn('转发无线数据包数量')
            ->addNumberColumn('发送数据包数量')
            ->addNumberColumn('接收下行数据包数量')
            ->addNumberColumn('接收已授权数据包数量');
        for ($a = 0; $a < count($time); $a++) {
            $chart->addRow([$time[$a], $rxnb[$a],$rxfw[$a],$txnb[$a],$dwnb[$a],$rxok[$a]]);
        }
        $lava->LineChart('chart', $chart, [
            'title' => '数据趋势图',
            'legend' => [
                'position' => ''
            ],
        ]);
        return view('gateway/graph')->with(['input'=>$input,'lava'=>$lava,'year'=>$year,'month'=>$month,'data'=>$data]);
    }

    public function setting($input){
        $model=DB::table('GatewayInfo')->where('gatewayId',$input)->value('model');
       return view('gateway/setting')->with(['input'=>$input,'model'=>$model]);
    }
    public function settingFrequency($input){
        $frequencyPlan=DB::table('GatewayInfo')->where('gatewayId',$input)->value('frequencyPlan');
        return view('gateway/settingFrequency')->with(['input'=>$input,'frequencyPlan'=>$frequencyPlan]);
    }
    public function settingType($input){
        $type=DB::table('GatewayInfo')->where('gatewayId',$input)->value('type');
        return view('gateway/settingType')->with(['input'=>$input,'type'=>$type]);
    }
    public function settingLocation($input){
        $location=DB::table('GatewayInfo')->where('gatewayId',$input)->value('location');
        $arr=explode(',',$location);
        $longitudes=$arr[0];
        $latitudes=$arr[1];
        $longitude=substr($longitudes,-1);
        $longitudeData=substr($longitudes,1,-1);
        $latitude=substr($latitudes,-2,-1);
        $latitudeData=substr($latitudes,0,-2);
        return view('gateway/settingLocation')->with(['input'=>$input,'longitudeData'=>$longitudeData,
            'longitude'=>$longitude,'latitudeData'=>$latitudeData,'latitude'=>$latitude]);
    }
    public function settingPost($input,Request $request){
        if(!empty($request)){
            $model=$request->get('model');
        }
        DB::table('GatewayInfo')->where('gatewayId',$input)->update([
            'model' => $model,
        ]);
        $success='网关ID为：'.$input.'成功修改网关型号信息！！！';
        $basePlatform=DB::table('GatewayInfo')->where('gatewayId', $input)->value('type');
        $location=DB::table('GatewayInfo')->where('gatewayId', $input)->value('location');
        $frequencyPlan=DB::table('GatewayInfo')->where('gatewayId', $input)->value('frequencyPlan');
        $placement=DB::table('GatewayInfo')->where('gatewayId', $input)->value('model');
        $createdAt=DB::table('GatewayInfo')->where('gatewayId', $input)->value('createdAt');
        $updatedAt=DB::table('GatewayInfo')->where('gatewayId', $input)->value('updatedAt');
        return view('gateway/overview')->with(['input'=>$input,'success'=>$success,'basePlatform'=>$basePlatform,
            'frequencyPlan'=>$frequencyPlan,'location'=>$location,'model'=>$placement,'createdAt'=>$createdAt,'updatedAt'=>$updatedAt]);
    }
    public function settingFrequencyPost($input,Request $request){
        if(!empty($request)){
            $frequencyPlan=$request->get('frequencyPlan');
        }
        $time=date('Y-m-d H:i:s');
        DB::table('GatewayInfo')->where('gatewayId',$input)->update([
            'frequencyPlan' => $frequencyPlan,
            'updatedAt'=>$time,
        ]);
        $success='网关ID为：'.$input.'成功修改网关频段信息！！！';
        $basePlatform=DB::table('GatewayInfo')->where('gatewayId', $input)->value('type');
        $location=DB::table('GatewayInfo')->where('gatewayId', $input)->value('location');
        $frequencyPlan=DB::table('GatewayInfo')->where('gatewayId', $input)->value('frequencyPlan');
        $placement=DB::table('GatewayInfo')->where('gatewayId', $input)->value('model');
        $createdAt=DB::table('GatewayInfo')->where('gatewayId', $input)->value('createdAt');
        $updatedAt=DB::table('GatewayInfo')->where('gatewayId', $input)->value('updatedAt');
        return view('gateway/overview')->with(['input'=>$input,'success'=>$success,'basePlatform'=>$basePlatform,
            'frequencyPlan'=>$frequencyPlan,'location'=>$location,'model'=>$placement,'createdAt'=>$createdAt,'updatedAt'=>$updatedAt]);
    }
    public function settingTypePost($input,Request $request){
        if(!empty($request)){
            $type=$request->get('type');
        }
        $time=date('Y-m-d H:i:s');
        DB::table('GatewayInfo')->where('gatewayId',$input)->update([
            'type' => $type,
            'updatedAt'=>$time,
        ]);
        $success='网关ID为：'.$input.'成功修改网关类型信息！！！';
        $basePlatform=DB::table('GatewayInfo')->where('gatewayId', $input)->value('type');
        $location=DB::table('GatewayInfo')->where('gatewayId', $input)->value('location');
        $frequencyPlan=DB::table('GatewayInfo')->where('gatewayId', $input)->value('frequencyPlan');
        $placement=DB::table('GatewayInfo')->where('gatewayId', $input)->value('model');
        $createdAt=DB::table('GatewayInfo')->where('gatewayId', $input)->value('createdAt');
        $updatedAt=DB::table('GatewayInfo')->where('gatewayId', $input)->value('updatedAt');
        return view('gateway/overview')->with(['input'=>$input,'success'=>$success,'basePlatform'=>$basePlatform,
            'frequencyPlan'=>$frequencyPlan,'location'=>$location,'model'=>$placement,'createdAt'=>$createdAt,'updatedAt'=>$updatedAt]);
    }
    public function settingLocationPost($input,Request $request){
        //表单验证
        $request->validate([
            'longitudeData' => [new longitudeDataRule()],
            'longitude' => 'required',
            'latitudeData' => [new latitudeDataRule()],
            'latitude' => 'required',
        ]);
        if(!empty($request)){
            $location='('.$request->get('longitudeData').$request->get('longitude').','.
                $request->get('latitudeData').$request->get('latitude').')';
        }
        $time=date('Y-m-d H:i:s');
        DB::table('GatewayInfo')->where('gatewayId',$input)->update([
            'location' => $location,
            'updatedAt'=>$time,
        ]);
        $success='网关ID为：'.$input.'成功修改网关地理位置信息！！！';
        $basePlatform=DB::table('GatewayInfo')->where('gatewayId', $input)->value('type');
        $location=DB::table('GatewayInfo')->where('gatewayId', $input)->value('location');
        $frequencyPlan=DB::table('GatewayInfo')->where('gatewayId', $input)->value('frequencyPlan');
        $placement=DB::table('GatewayInfo')->where('gatewayId', $input)->value('model');
        $createdAt=DB::table('GatewayInfo')->where('gatewayId', $input)->value('createdAt');
        $updatedAt=DB::table('GatewayInfo')->where('gatewayId', $input)->value('updatedAt');
        return view('gateway/overview')->with(['input'=>$input,'success'=>$success,'basePlatform'=>$basePlatform,
            'frequencyPlan'=>$frequencyPlan,'location'=>$location,'model'=>$placement,'createdAt'=>$createdAt,'updatedAt'=>$updatedAt]);
    }

    public function deletePost(Request $request){
        $gatewayIDget=$request->get('gatewayID');
        DB::table('GatewayStatus')->where('gatewayId',$gatewayIDget)->delete();//delete the child table
        DB::table('GatewayInfo')->where('gatewayId',$gatewayIDget)->delete();//delete the father table
        $user=Auth::user()->email;
        $userID=md5($user);
        $name=Auth::user()->name;
        $gatewayID=DB::table('GatewayInfo')->where('userId',$userID)->orderBy('updatedAt','desc')->pluck('gatewayId');
        $frequencyPlan=array();
        $model=array();
        for($i=0;$i<count($gatewayID);$i++) {
            $frequencyPlan[$i] = DB::table('GatewayInfo')->where('gatewayId', $gatewayID[$i])->value('frequencyPlan');
            $model[$i] = DB::table('GatewayInfo')->where('gatewayId', $gatewayID[$i])->value('model');
        }
        $success='网关ID为：'.$gatewayIDget.' 已经成功删除！！！';
        return view('gateway/list')->with(['name'=>$name,'success'=>$success,'gatewayID'=>$gatewayID,
            'frequencyPlan'=>$frequencyPlan,'model'=>$model]);
    }
}
