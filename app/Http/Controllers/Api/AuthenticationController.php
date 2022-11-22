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



}
