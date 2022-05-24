<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Helpers\HelperPublic;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e, $request) {
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException) {
                if(null === $e->getPrevious()) {
                    $responseMessage = 'Token tidak dicantumkan dalam request. Silahkan login kembali';
                    $response = HelperPublic::helpResponse($e->getStatusCode(), [], $responseMessage, null, null);
                    return response()->json($response, $e->getStatusCode());
                }

                switch (get_class($e->getPrevious())) { //untuk package tymon jwt auth
                    case \Tymon\JWTAuth\Exceptions\TokenExpiredException::class:
                        $responseMessage = 'Token anda sudah kadaluwarsa. Silahkan login kembali';
                        $response = HelperPublic::helpResponse($e->getStatusCode(), [], $responseMessage, null, null);
                        return response()->json($response, $e->getStatusCode());
                    case \Tymon\JWTAuth\Exceptions\TokenInvalidException::class:
                        $responseMessage = 'Token anda tidak valid. Silahkan login kembali';
                        $response = HelperPublic::helpResponse($e->getStatusCode(), [], $responseMessage, null, null);
                        return response()->json($response, $e->getStatusCode());
                    case \Tymon\JWTAuth\Exceptions\TokenBlacklistedException::class:
                        $responseMessage = 'Token anda telah diblacklist. Silahkan login kembali';
                        $response = HelperPublic::helpResponse($e->getStatusCode(), [], $responseMessage, null, null);
                        return response()->json($response, $e->getStatusCode());
                    case \Tymon\JWTAuth\Exceptions\UserNotDefinedException::class:
                        $responseMessage = 'User tidak ditemukan. Silahkan login kembali';
                        $response = HelperPublic::helpResponse($e->getStatusCode(), [], $responseMessage, null, null);
                        return response()->json($response, $e->getStatusCode());
                    default:
                        break;
                }
            }
        });
    }
}
