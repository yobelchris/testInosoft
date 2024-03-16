<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return $this->setJsonResponse(null, 401, 'Unauthorized');
        }

        return $this->setJsonResponse([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ], 200);
    }

    public function logout()
    {
        try{
            auth()->logout();
        }catch (\Exception $e) {
            return $this->setJsonResponse(null, 401, 'Unauthorized');
        }

        return $this->setJsonResponse(null, 200);
    }
}
