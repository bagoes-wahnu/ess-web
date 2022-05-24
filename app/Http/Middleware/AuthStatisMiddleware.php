<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Concerns\InteractsWithInput;

class AuthStatisMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $tokenstatis = "Bearer " .config('myconfig.static_token');
        $token = $request->header('Authorization');
        if ($token == null) {
            return response()->json(['status' => 'Authorization Token not found'], 401);
        }else{
            if ($tokenstatis == $token) {
                return $next($request);

                return response()->json(['data' => $token], 401);
            } else{
                return response()->json(['status' => 'token not valid!'], 401);
                // return response()->json($tokenstatis, 401);
                
            }
        }

    }
}
