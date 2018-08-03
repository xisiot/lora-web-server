<?php

namespace App\Http\Controllers;
date_default_timezone_set('prc');
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class allController extends Controller
{
    public function index()
    {
        if (empty(Auth::user()->email)) {
            return view('auth/login');
        }
        else {
            $user = Auth::user()->email;
            $userID = md5($user);   //获得该用户的userID
            $users = DB::table('Developers')->pluck('developer_id');
            for ($i = 0; $i < count($users); $i++) {
                if ($user = $users[$i]) {
                    $AppEUI = DB::table('AppInfo')->where('userId', $userID)->pluck('AppEUI');
                    $gatewayID = DB::table('GatewayInfo')->where('userId', $userID)->pluck('gatewayId');
                    $DevEUI = array();
                    for ($k = 0; $k < count($AppEUI); $k++) {
                        $get1 = DB::table('DeviceInfo')->where('AppEUI', $AppEUI[$k])->pluck('DevEUI');
                        if (!empty($get1)) {
                            for ($j = 0; $j < count($get1); $j++) {
                                array_push($DevEUI, $get1[$j]);
                            }
                        } else {
                        }
                    }
                    $count1 = count($AppEUI);
                    $count2 = count($DevEUI);
                    $count3 = count($gatewayID);
                    return view('all')->with(['count1' => $count1, 'count2' => $count2, 'count3' => $count3]);
                }
            }
        }
    }
}
