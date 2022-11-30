<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function (){
    Route::get('', [\App\Http\Controllers\AuthController::class, 'home'])->name('home');
    Route::get('register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
    Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::get('callback', [\App\Http\Controllers\AuthController::class, 'callback'])->name('callback');
    Route::get('info', [\App\Http\Controllers\AuthController::class, 'info'])->name('info')->middleware('auth');
    Route::get('checkauth', [\App\Http\Controllers\AuthController::class, 'authCheck'])->name('authCheck');
    Route::post('login-by-hrpro', [\App\Http\Controllers\AuthController::class, 'loginByHRPRO'])->name('loginByHRPRO');
});

