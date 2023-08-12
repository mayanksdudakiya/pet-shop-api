<?php

namespace App\Http\Controllers\V1;

use App\Facades\ApiResponse;
use App\Facades\JwtAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::whereEmail($request->email)->firstOrFail();

        throw_unless($user->password && Hash::check($request->password, $user->password), new AuthenticationException());

        $token = JwtAuth::issueToken($user);

        return ApiResponse::sendSuccess([
            'token' => $token->toString(),
        ]);
    }
}
