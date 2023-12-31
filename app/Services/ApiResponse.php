<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;

final class ApiResponse
{
    /**
     * @param JsonResource $resource
     *
     * @return JsonResponse
     */
    public function sendData(JsonResource $resource): JsonResponse
    {
        $resourceData = $resource->response()->getData(true);
        $pagination = $resourceData['meta'];
        $links = $resourceData['links'];

        return response()->json([
            'current_page' => $pagination['current_page'],
            'data' => $resourceData['data'],
            'first_page_url' => $links['first'],
            'from' => $pagination['from'],
            'last_page' => $pagination['last_page'],
            'last_page_url' => $links['last'],
            'links' => $pagination['links'],
            'next_page_url' => $links['next'],
            'path' => $pagination['path'],
            'per_page' => $pagination['per_page'],
            'prev_page_url' => $links['prev'],
            'to' => $pagination['to'],
            'total' => $pagination['total'],
        ], Response::HTTP_OK);
    }

    /**
     * @param array<mixed, mixed> $data
     * @param int $statusCode
     *
     * @return JsonResponse
     */
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

    /**
     * @param string $error
     * @param int $statusCode
     *
     * @return JsonResponse
     */
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

    /**
     * @param string $error
     * @param array<string, string>|MessageBag $errors
     * @param array<string, string> $trace
     * @param int $statusCode
     *
     * @return JsonResponse
     */
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

    /**
     * @param int $success
     * @param array<mixed, mixed> $data
     * @param string|null $error
     * @param array<string, string>|MessageBag $errors
     * @param array<string, string> $trace
     * @param int $statusCode
     *
     * @return JsonResponse
     */
    private function buildResponse(int $success = 0, array $data = [], string|null $error = null, array|MessageBag $errors = [], array $trace = [], int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'data' => $data,
            'error' => $error,
            'errors' => $errors,
            'trace' => $trace,
        ], $statusCode);
    }
}
