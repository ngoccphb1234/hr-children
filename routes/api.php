<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware('auth.app')->group(function (){
    Route::post('register', [\App\Http\Controllers\Api\AuthenticationController::class, 'register']);
});
Route::post('logout', [\App\Http\Controllers\Api\AuthenticationController::class, 'logout'])->name('logoutApi');
Route::post('auth-by-hrpro', [\App\Http\Controllers\Api\AuthenticationController::class, 'authByHrpro']);



