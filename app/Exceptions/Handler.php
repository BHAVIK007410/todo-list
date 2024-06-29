<?php

namespace App\Exceptions;

use Error;
use Illuminate\Auth\AuthenticationException as AuthAuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Passport\Exceptions\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

/**
 * Class Handler
 *
 * @package App\Exceptions
 */
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
     * @param Request $request
     * @param Throwable $exception
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function render($request, Throwable $exception): JsonResponse
    {
        if ($request->expectsJson()) {
            $response = response()->json(
                [
                    'success' => false,
                    'message' => 'Something went wrong'
                ],
                400
            );

            if ($exception instanceof RouteNotFoundException) {
                $response = response()->json(
                    [
                        'success' => false,
                        'message' => __('messages.auth_exception')
                    ],
                    400
                );
            }

            if ($exception instanceof MethodNotAllowedHttpException) {
                $response = response()->json(
                    [
                        'success' => false,
                        'message' => __('messages.method_not_allowed')
                    ],
                    400
                );
            }

            if ($exception instanceof NotFoundHttpException) {
                $response = response()->json(
                    [
                        'success' => false,
                        'message' => 'Route not found'
                    ],
                    400
                );
            }

            if ($exception instanceof AuthenticationException) {
                $response = response()->json(
                    [
                        'success' => false,
                        'message' => __('messages.auth_exception')
                    ],
                    401
                );
            }

            if ($exception instanceof AuthAuthenticationException) {
                $response = response()->json(
                    [
                        'success' => false,
                        'message' => __('messages.auth_exception')
                    ],
                    401
                );
            }

            if ($exception instanceof ThrottleRequestsException) {
                $response = response()->json(
                    [
                        'success' => false,
                        'message' => 'Too Many Requests,Please Slow Down'
                    ],
                    429
                );
            }

            if ($exception instanceof QueryException) {
                $response = response()->json(
                    [
                        'success' => false,
                        'message' => 'There was Issue with the Query',
                        'exception' => $exception

                    ],
                    500
                );
            }

            if ($exception instanceof UnauthorizedException) {
                $response = response()->json(
                    [
                        'success' => false,
                        'message' => 'Missing authorization',
                        'exception' => $exception

                    ],
                    500
                );
            }

            if ($exception instanceof Error) {
                $response = response()->json(
                    [
                        'success' => false,
                        'message' => "There was some internal error",
                        'exception' => $exception
                    ],
                    500
                );
            }

            return $response;
        }

        return parent::render($request, $exception);
    }
}
