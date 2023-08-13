<?php

namespace App\Http\Controllers\V1;

use App\Facades\BaseAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        return BaseAuth::login($request);
    }

    public function logout(Request $request): JsonResponse
    {
        return BaseAuth::logout($request);
    }
}
