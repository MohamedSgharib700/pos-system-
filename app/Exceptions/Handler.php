<?php

namespace App\Exceptions;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (\Exception $e, $request) {
            // Default response of 400
            $status = 400;
            $errors = [];
            if ($e instanceof \PDOException) {
                if ($e->getCode() == "23000" && $request->method() == "DELETE") {
                    $errors['error'] = 'العنصر الذي تحاول حذفة مرتبط بعناصر أخري';
                }
                $code = 422;
            } else if ($e instanceof UnauthorizedException) {
                $errors['error'] = 'You does not have the right permissions';
            } else if ($e instanceof ValidationException) {
                $errors = collect($e->validator->getMessageBag())->mapWithKeys(function ($error, $key) {
                    return [$key => $error[0]];
                });
                $code = 422;
            } else if ($e instanceof AuthenticationException) {
                $code = 401;
            }
            if(!count($errors)) $errors['error'] = $e->getMessage();
            $exception = $this->convertExceptionToArray($e);
            if ($this->isHttpException($e)) $status = $e->getStatusCode();
            return (new Controller)->errorResponse($errors, $code ?? $status, $exception);
        });
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
