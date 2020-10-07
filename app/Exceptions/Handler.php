<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;
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
        switch(true){
            case $exception instanceof ValidationException:
                return $this->convertValidationExceptionToResponse($exception, $request);
            break;

            case $exception instanceof ModelNotFoundException:
                $modelName = strtolower(class_basename($exception->getModel()));
                return $this->errorResponse("Does not exists any {$modelName} with the specified identificator", 404);
            break;

            case $exception instanceof AuthenticationException:
                return $this->unauthenticated($request,$exception);
            break;

            case $exception instanceof AuthorizationException:
                return $this->errorResponse($exception->getMessage(), 403);
            break;

            case $exception instanceof NotFoundHttpException:
                return $this->errorResponse('The specified URL cannot be found', 404);
            break;

            case $exception instanceof HttpException:
                return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
            break;

            case $exception instanceof QueryException:
                $errorCode = $exception->errorInfo[1];
                if( $errorCode == 1451 ){
                    return $this->errorResponse('Cannot remove this resource permanently. It is related with any other resource', 409);
                }
            break;

            default:
                return ( config('app.debug') ? parent::render($request, $exception) : $this->errorResponse('Unexpected Exception. Try later', 500) );
            break;
        }

    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse('Unauthenticated.', 401);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        return $this->errorResponse($errors, 422);
    }
}