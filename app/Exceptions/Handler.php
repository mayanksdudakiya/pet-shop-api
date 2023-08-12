<?php

namespace App\Exceptions;

use App\Facades\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        return match (true) {
            $e instanceof PostTooLargeException => ApiResponse::sendError('The uploaded file is too large.', Response::HTTP_REQUEST_ENTITY_TOO_LARGE),
            $e instanceof AuthenticationException => ApiResponse::sendError('Failed to authenticate user', Response::HTTP_UNAUTHORIZED),
            $e instanceof ThrottleRequestsException => ApiResponse::sendError('Too Many Requests.', Response::HTTP_TOO_MANY_REQUESTS),
            $e instanceof ModelNotFoundException => ApiResponse::sendError($e->getMessage(), Response::HTTP_NOT_FOUND),
            $e instanceof ValidationException => ApiResponse::sendValidationError('Validation error occured', $e->validator->errors()),
            $e instanceof QueryException => ApiResponse::sendError('Database query error.', Response::HTTP_INTERNAL_SERVER_ERROR),
            $e instanceof HttpResponseException => $e->getResponse(),
            $e instanceof FileNotFoundException => ApiResponse::sendError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR),
            $e instanceof \Error => ApiResponse::sendError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR),
            default => parent::render($request, $e),
        };
    }
}
