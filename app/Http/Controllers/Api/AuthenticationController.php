<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthenticationController extends Controller
{
private string $client_key = 'key_12345';

    public function login(Request $request){
        try {
            $client_secret = $request->header($this->client_key);

            if (!$client_secret ){
                    throw new \Exception('ko co client key');
            }

            $client = Client::query()->where('client_key', '=', $this->client_key)->first();
            if (!$client){
                throw new \Exception('ko co client');
            }

            if (strcmp($client['client_secret'], $client_secret) != 0){
                throw new \Exception('client secret ko dung');
            }
            $token = $client->createToken('hrpro token')->accessToken;
            return response()->json(['token' => $token]);
        }catch (\Exception $e){
            return response()->json($e->getMessage());
        }
    }



}
