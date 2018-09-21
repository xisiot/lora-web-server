<?php

namespace App\Http\Controllers\client;
date_default_timezone_set('prc');
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class clientController extends Controller
{

    public function index(){
        $user = Auth::user()->email;
        $userID=md5($user);
        $AppEUI=DB::table('AppInfo')->where('userId',$userID)->orderBy('createdAt','desc')->pluck('AppEUI');
        $name=DB::table('AppInfo')->where('userId',$userID)->orderBy('createdAt','desc')->pluck('name');
        $newAppEUI=$this->getrandom();//随机生成16位随机数
        $appEUIs=DB::table('AppInfo')->pluck('AppEUI');
        $i=0;
        while($i < count($appEUIs)){
            if($newAppEUI==$appEUIs[$i]) {
                $newAppEUI=$this->getrandom();  //重新随机生成16位随机数
                $i=0;
            }
            else $i++;
        }  //判断生成的appEUI是否唯一
        $success= '';
        return view('client/list')->with(['AppEUI'=>$AppEUI,'name'=>$name,'success'=>$success,'newAppEUI'=>$newAppEUI]);
    }

    public function store(Request $request){
        $nameget=$request->get('name');
        $user = Auth::user()->email;
        $userID=md5($user);
        $AppEUIget=$request->get('AppEUI');
        $appEUIs=DB::table('AppInfo')->pluck('AppEUI');
        $i=0;
        while($i < count($appEUIs)){
            if($AppEUIget==$appEUIs[$i]) {
                $AppEUI=DB::table('AppInfo')->where('userId',$userID)->orderBy('createdAt','desc')->pluck('AppEUI');
                $name=DB::table('AppInfo')->where('userId',$userID)->orderBy('createdAt','desc')->pluck('name');
                $newAppEUI=$this->getrandom();//随机生成16位随机数
                $appEUIs=DB::table('AppInfo')->pluck('AppEUI');
                $i=0;
                while($i < count($appEUIs)){
                    if($newAppEUI==$appEUIs[$i]) {
                        $newAppEUI=$this->getrandom();  //重新随机生成16位随机数
                        $i=0;
                    }
                    else $i++;
                }  //判断生成的appEUI是否唯一
                $success= '您修改的AppEUI不唯一，请重新注册';
                return view('client/list')->with(['AppEUI'=>$AppEUI,'name'=>$name,'success'=>$success,'newAppEUI'=>$newAppEUI]);
            }
            else $i++;
        }  //判断用户修改的appEUI是否唯一
        $url="http://47.93.221.82:12235/application";
        $header=array("Content-Type"=>"application/x-www-form-urlencoded");
        $body=array("userID"=>$userID,"AppEUI"=>$AppEUIget,"name"=>$nameget);
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
        $AppEUI=DB::table('AppInfo')->where('userId',$userID)->orderBy('createdAt','desc')->pluck('AppEUI');
        $name=DB::table('AppInfo')->where('userId',$userID)->orderBy('createdAt','desc')->pluck('name');
        $newAppEUI=$this->getrandom();//随机生成8位随机数
        $appEUIs=DB::table('AppInfo')->pluck('AppEUI');
        $i=0;
        while($i < count($appEUIs)){
            if($newAppEUI==$appEUIs[$i]) {
                $newAppEUI=$this->getrandom();  //重新随机生成16位随机数
                $i=0;
            }
            else $i++;
        }  //判断生成的appEUI是否唯一
        $success='应用名称为：' . $nameget . '应用注册成功！';
        return view('client/list')->with(['AppEUI'=>$AppEUI,'name'=>$name,'success'=>$success,'newAppEUI'=>$newAppEUI]);
    }

    public function input($input){
        session_start();
        session(['product_key'=>$input]);
        $AppEUI=DB::table('AppInfo')->where('AppEUI',$input)->get();
        $success='';
        return view('client/overview')->with(['input'=>$input,'name'=>$AppEUI,'success'=>$success]);
    }

    public  function device($input){
        session_start();
        session(['product_key'=>$input]);
        $name=DB::table('AppInfo')->where('AppEUI',$input)->value('name');
        $device=DB::table('DeviceInfo')->where('AppEUI',$input)->orderBy('createdAt','desc')->simplePaginate(5);
        $success='';
        return view('client/device')->with(['input'=>$input,'name'=>$name,'device'=>$device,'success'=>$success]);
    }

    public function setting($input){
        session_start();
        session(['product_key'=>$input]);
        $name=DB::table('AppInfo')->where('AppEUI',$input)->value('name');
        return view('client/setting')->with(['input'=>$input,'name'=>$name]);
    }

    public function settingPost($input,Request $request){
        $nameGet=$request->get('name');
        $time=date('Y-m-d H:i:s');
        DB::table('AppInfo')->where('AppEUI',$input)->update([
                'name'=>$nameGet,
                'updatedAt'=>$time
            ]
        );
        return redirect('/client/'.$input)->withErrors('应用名称修改成功！');
    }

    public function deletePost(Request $request){
        $AppEUIget=$request->get('AppEUI');
        $DevAddr=array();
        $DevEUI=DB::table('DeviceInfo')->where('AppEUI',$AppEUIget)->pluck('DevEUI');
        for($i=0;$i<count($DevEUI);$i++){
            $DevAddr[$i]=DB::table('DeviceInfo')->where('DevEUI',$DevEUI[$i])->value('DevAddr');
            if(!empty($DevAddr[$i])) {
                DB::table('DeviceStatus')->where('DevAddr', $DevAddr[$i])->delete();
                DB::table('DeviceDownlink')->where('DevAddr', $DevAddr[$i])->delete();
                DB::table('DeviceConfig')->where('DevAddr', $DevAddr)->delete();
                DB::table('DeviceRouting')->where('DevAddr', $DevAddr)->delete();
            }
            DB::table('DeviceInfo')->where('DevEUI',$DevEUI[$i])->delete();
        }
        DB::table('AppInfo')->where('AppEUI',$AppEUIget)->delete();
        $success= '应用成功删除!!!';
        return redirect('/client')->with(['success'=>$success]);
    }

    public function getrandom(){
        $random='';
        for($i=0;$i<16;$i++) {
            $a = dechex(mt_rand(0, 15));
            $random=$random.$a;
        }
        return $random;
    }
}

