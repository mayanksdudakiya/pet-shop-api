<?php

namespace App\Http\Middleware;

use App\Facades\ApiResponse;
use App\Facades\JwtAuth;
use App\Models\JwtToken;
use App\Models\User;
use Closure;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyJwtToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (empty($token)) {
            return ApiResponse::sendError('Invalid token', Response::HTTP_UNAUTHORIZED);
        }

        $parsedToken = JwtAuth::parseToken($token);

        if (!JwtAuth::validateToken($parsedToken)) {
            return ApiResponse::sendError('Invalid token', Response::HTTP_UNAUTHORIZED);
        }

        if ($parsedToken->isExpired(new DateTimeImmutable())) {
            JwtToken::deleteToken($parsedToken);
            return ApiResponse::sendError('Token has expired', Response::HTTP_UNAUTHORIZED);
        }

        User::setAuthenticatedUserInRequest($parsedToken, $request);

        return $next($request);
    }
}
