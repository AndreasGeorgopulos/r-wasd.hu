<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param Exception $exception
	 * @return void
	 * @throws Throwable
	 */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param Request $request
	 * @param Exception $exception
	 * @return Response
	 * @throws Throwable
	 */
    public function render($request, Throwable $exception): Response
    {
        return parent::render($request, $exception);
    }
}
