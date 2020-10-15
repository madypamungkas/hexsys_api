<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Traits\ResponseAPI;

class Handler extends ExceptionHandler
{
    use ResponseAPI;
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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $response = $this->handleException($request, $exception);
        return $response;
    }

    public function handleException($request, Throwable $exception)
    {
        if ($request->is('api/*')) {
            if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
                return $this->error('Unauthorized.', 401);
            }
            if ($exception instanceof MethodNotAllowedHttpException) {
                return $this->error('Method dilarang.', 405);
            }
            if ($exception instanceof NotFoundHttpException) {
                return $this->error('Endpoint tidak ditemukan.', 404);
            }
            if ($exception instanceof ModelNotFoundException) {
                return $this->error('Model tidak ditemukan.', 404);
            }
            if ($exception instanceof HttpException) {
                return $this->error($exception->getMessage(), $exception->getStatusCode());
            }
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return $this->error('Unexpected Exception.', 500);

    }
}
