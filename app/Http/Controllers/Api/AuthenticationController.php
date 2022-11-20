<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthenticationController extends Controller
{

    public function register(Request $request){

        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);
            $data = $request->all();
            $user = User::query()->create($data);
            if ($user){
                Auth::login($user);
            }
            return response()->json($user);

        }catch (\Exception $e){
            return response()->json($e);
        }
    }



}
