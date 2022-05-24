<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\HelperPublic;

class IsActivedUser
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
        if(auth('api')->user()->status == false) {
            auth('api')->invalidate();
            $responseMessage = 'User anda telah dinonaktifkan';
            $response = HelperPublic::helpResponse(401, [], $responseMessage, null, null);
            return response()->json($response, 401);
        }

        return $next($request);
    }
}
