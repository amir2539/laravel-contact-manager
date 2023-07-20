<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
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
     * @param $request
     * @param  Throwable  $e
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request, Throwable $e): \Illuminate\Http\JsonResponse
    {
        if (app()->isLocal()) {
            $message = $e->getMessage();
        } else {
            $message = null;
        }


        if ($e instanceof ValidationException) {
            return apiResponse(Response::HTTP_UNPROCESSABLE_ENTITY, "The given data is invalid", $e->errors(),);
        }
        if ($e instanceof AuthorizationException) {
            return apiResponse(code: 403, message: $message);
        }
        if ($e instanceof AuthenticationException) {
            return apiResponse(code: 401, message: $message);
        }
        if ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
            return apiResponse(code: 404, message: $message);
        }
        if ($e instanceof HttpException && $e->getStatusCode() == 503) {
            return apiResponse(code: 503, message: $message);
        }
        if ($e instanceof TooManyRequestsHttpException) {
            return apiResponse(code: 429, message: "Too many requests. please try again later.");
        }
        if (app()->isLocal()) {
            return apiResponse(code: 500,
                message: $e->getMessage().$e->getFile().$e->getLine());
        }

        return apiResponse(code: Response::HTTP_BAD_REQUEST, message: $e->getMessage());
    }
}
