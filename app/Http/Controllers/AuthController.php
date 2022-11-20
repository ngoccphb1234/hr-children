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
        $user_email = $request->query('user_email');
        if ($user_email) {

            $redis = Redis::connection();
            //co nen truyen query string ko, hay goi api get roi truyen vao header
            $user_redis = $redis->get($user_email);
            if ($user_redis){
                $decode_user = json_decode($user_redis);
                $user = User::query()->where('email', '=', $decode_user->email)->first();
                if (!$user){
                    throw new \Exception('user not found!');
                }
                Auth::login($user);
            }
        }
        return view('home');
    }

    public function register()
    {
        return view('register');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect::route('home');
    }

}
