<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    private string $app_key = 'key_123456';
    private string $app_secret = 'secret_123456';
    private string $url_hrpro = 'http://hrpro.local:8000/';

    public function home()
    {
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
        $code = $request->get('code');
        if (!$code) {
            throw new \Exception('ko co code');
        }

        $response = Http::post($this->url_hrpro . 'api/oauth/user', [
            'app_key' => $this->app_key,
            'app_secret' => $this->app_secret,
            'code' => $code
        ]);
        if ($response->failed()) {
            throw new \Exception('Co loi khi goi api hrpro');
        }
        $user_hrpro = $response->json();
        $user = User::query()->where('email', '=', $user_hrpro['email'])->first();
        if (!$user) {
            $data = [
                'name' => $user_hrpro['name'],
                'email' => $user_hrpro['email'],
            ];
           $new_user = User::query()->create($data);
           Auth::loginUsingId($new_user['id']);
        }else{
            Auth::loginUsingId($user['id']);
        }
        return Redirect::route('home');


        //login user
    }

    public function callbackURL(){
        return \redirect()->to('http://hrpro.local:8000/oauth/authorize?app_key=key_123456');
    }

}
