<?php

namespace App\Services;

use App\Facades\ApiResponse;
use App\Facades\JwtAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Models\JwtToken;
use App\Models\User;
use ErrorException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

final class BaseAuth
{
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $user = User::whereEmail($request->email)->firstOrFail();

            throw_unless($user->password && Hash::check($request->password, $user->password), new AuthenticationException());

            $token = JwtAuth::issueToken($user);

            JwtToken::storeToken($user, $token);

            DB::commit();

            return ApiResponse::sendSuccess([
                'token' => $token->toString(),
            ]);
        } catch (Throwable $e) {
            DB::rollBack();
            return ApiResponse::sendError($e->getMessage());
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $token = JwtToken::whereUniqueId($request->jti)->firstOrFail();
        $token->delete();

        return ApiResponse::sendSuccess();
    }
}
