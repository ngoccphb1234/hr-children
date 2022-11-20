<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class ApplicationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $default_app_secret = 'sGFdsivu221hgg';
        $default_app_key = 'survey-hr';
        $get_app_secret = $request->header($default_app_key);
        if (!$get_app_secret){
            return response()->json('khong co app key.');
        }
        if (strcmp($default_app_secret, $get_app_secret) != 0){
            return response()->json('app secret khong dung.');
        }
        return $next($request);
    }
}
