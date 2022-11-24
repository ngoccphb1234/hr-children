<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function home(Request $request)
    {
        $user_code = $request->query('user_code');
        if ($user_code) {
//            $redis = Redis::connection();
//            $user_redis = $redis->get($user_code);
            $user = User::query()->where('user_code', '=', $user_code)->first();

            if ($user) {
                Auth::login($user);
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

    public function callback(Request $request)
    {
        $app_key = 'key_fjfue783332';
        $app_secret = 'secret_ugfu8r84hdre783ff';
        $code = $request->get('code');
        $url_hrpro = 'http://hrpro.local:8000/';
        $survey_code = 'code_fdjghdfughrue84433';
        if (!$code && strcmp($survey_code, $code) != 0) {
            return Redirect::route('home');
        }
        $response = Http::post($url_hrpro . 'api/oauth/token', [
            'app_key' => $app_key,
            'app_secret' => $app_secret,
            'code' => $code,
        ]);

        if ($response->failed()) {
            throw new \Exception('Co loi khi goi api hrpro');
        }
        $access_token = $response->json()['access_token'];
        $response_user = Http::acceptJson()->post($url_hrpro . 'oauth/user', [
            'access_token' => $access_token,
        ]);
        dd($response_user->json());

    }

}
