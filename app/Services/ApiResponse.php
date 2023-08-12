<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;

final class ApiResponse
{
    private function buildResponse(int $success=0, array $data=[], string|null $error, array|MessageBag $errors, array $trace=[], int $statusCode): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'data' => $data,
            'error' => $error,
            'errors' => $errors,
            'trace' => $trace
        ], $statusCode);
    }

    public function sendSuccess(array $data = [], $statusCode = Response::HTTP_OK): JsonResponse
    {
        return $this->buildResponse(
            1,
            $data,
            null,
            [],
            [],
            $statusCode
        );
    }

    public function sendError(string $error, $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return $this->buildResponse(
            0,
            [],
            $error,
            [],
            [],
            $statusCode
        );
    }

    public function sendValidationError(string $error, array|MessageBag $errors, array $trace = [], $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY): JsonResponse
    {
        return $this->buildResponse(
            0,
            [],
            $error,
            $errors,
            $trace,
            $statusCode
        );
    }
}
