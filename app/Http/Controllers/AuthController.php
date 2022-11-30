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
    private string $app_code = '12345678';
    private string $app_secret = 'fdgkijirreijretrete';
    private string $key_surveyhr = 'dhughdfugdghfugdhfgh';

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
        dd('get usser');

    }

    public function authCheck(Request $request){
            $app_code = $request->get('app_code');
            if (!$app_code || strcmp($this->app_code, $app_code) != 0){
                return Redirect::to('http://hrpro.local:8000');
            }
        return Redirect::to('http://hrpro.local:8000/auth/callback/?app_secret='.$this->app_secret);
    }

    public function loginByHRPRO(Request $request){
        try {
            $get_app_code = $request->get('app_code');
            $get_app_secret = $request->get('app_secret');
            $get_key_surveyhr = $request->get('key_surveyhr');
            $get_user_id = $request->get('user_id');
            return response()->json(1);

            if (!$get_app_code || !$get_app_secret || !$get_key_surveyhr || !$get_user_id){
                throw new \Exception('ko co key');
            }
            if (strcmp($this->app_code, $get_app_code) != 0 || strcmp($this->app_secret, $get_app_secret) != 0 || strcmp($this->key_surveyhr, $get_key_surveyhr) != 0){
                throw new \Exception('key khong dung');
            }

            $user = User::query()->where('id_hrpro', '=', $get_user_id)->first();
            if (!$user){
                throw new \Exception('ko co user');
            }
            Auth::loginUsingId($user->id);
            return response()->json('success');
        }catch (\Exception $e){
            throw new \Exception($e);

        }
    }

}
