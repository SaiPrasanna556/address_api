<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckAPIKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $key = $request->header('API_KEY');
        if(Auth::user() || Auth::user()->api_token != $key){
            return response()->json(['message'=>'Invalid API Key'],401);
        }
        return $next($request);
    }
}
