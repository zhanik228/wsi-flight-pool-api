<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
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

//        $this->renderable(function (ValidationException $e, Request $request) {
//
//        });
    }

    public function render($request, \Exception|Throwable $exception) {
        if ($exception instanceof ValidationException) {
            return response()->json([
                'error' => [
                    'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'message' => 'Validation error',
                    'errors' => $exception->errors(),
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return parent::render($request, $exception);
    }
}
