<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function home(Request $request)
    {
        $user_code = $request->query('user_code');
        if ($user_code) {
            $redis = Redis::connection();
            $user_redis = $redis->get($user_code);
            if ($user_redis){
                $decode_user = json_decode($user_redis);
                $user = User::query()->where('user_code', '=', $decode_user->user_code)->first();
                if (!$user){
                   $new_user = User::query()->create((array)$decode_user);
                    Auth::loginUsingId($new_user->id);
                }else{
                    Auth::loginUsingId($user->id);
                }
            }
        }
        return view('home');
    }

    public function info()
    {
        return view('info');
    }


    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
        return Redirect::route('home');
    }

}
