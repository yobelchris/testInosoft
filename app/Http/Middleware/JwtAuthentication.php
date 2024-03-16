<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtAuthentication extends BaseMiddleware
{
    protected function setJsonResponse($data, int $code, string $message = '') {
        if($code == 200) {
            $message = 'success';
        }else if ($message == ''){
            $message = 'failed';
        }

        if($data == null) {
            $data = [];
        }

        return response()->json([
            "status" => [
                "code" => $code,
                "message" => $message
            ],
            "data" => $data
        ])->setStatusCode($code);
    }

    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->setJsonResponse(null, 401, 'token is invalid');
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->setJsonResponse(null, 401, 'token is expired');
            }else{
                return $this->setJsonResponse(null, 401, 'token not found');
            }
        }
        return $next($request);
    }
}
