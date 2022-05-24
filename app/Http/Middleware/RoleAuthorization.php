<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\HelperPublic;

class RoleAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $responseCode = null;
        $responseStatus = null;
        $responseMessage = null;
        $responseData = [];
        $role = auth('api')->user()->role;

        if ($roles) 
        {
            if (in_array($role->id, $roles)) 
            {
                $responseCode = 200;
            } 
            else 
            {
                $responseCode = 403;
                $responseMessage = 'Hak akses ' . $role->nama . ' tidak diizinkan mengakses url ini!';
            }
        } 
        else 
        {
            $responseCode = 200;
        }

        if ($responseCode == 200) 
        {
            return $next($request);
        } 
        else 
        {
            $response = HelperPublic::helpResponse($responseCode, $responseData, $responseMessage, $responseStatus, null);
            return response()->json($response, $responseCode);
        }
    }
}
