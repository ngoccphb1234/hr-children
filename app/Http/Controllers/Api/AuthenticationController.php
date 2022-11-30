<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthenticationController extends Controller
{
    private string $app_code = '12345678';
    private string $app_secret = 'fdgkijirreijretrete';
    private string $key_surveyhr = 'dhughdfugdghfugdhfgh';

    public function register(Request $request){

        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'user_code' => 'required|unique:users',
                'password' => 'required|min:6',
            ]);
            $data = $request->all();
            $user = User::query()->create($data);
            return response()->json($user);

        }catch (\Exception $e){
            return response()->json($e);
        }
    }

    public function logout(Request $request){
        try {
            Session::flush();
            Auth::logout();
            return Redirect::route('home');
        }catch (\Exception $e){
            return Redirect::route('error')->withErrors($e->getMessage());
        }


    }

    public function authByHrpro(Request $request){
        try {
            $get_app_code = $request->get('app_code');
            $get_app_secret = $request->get('app_secret');

            if (!$get_app_code || !$get_app_secret){
                throw new \Exception('ko co key');
            }

            if (strcmp($this->app_code, $get_app_code) != 0 || strcmp($this->app_secret, $get_app_secret) != 0){
                throw new \Exception('key khong dung');
            }
            return response()->json(true);
        }catch (\Exception $e){
            return response()->json($e);
        }
    }



}
