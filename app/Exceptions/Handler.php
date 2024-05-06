<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\Exception\FlattenException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
       if ($request->is('api/*')) {
           return $this->renderForApi($request, $exception);
        }
        
        return parent::render($request, $exception);
        
    }

    public function renderForApi($request, Exception $exception)
    {
        $fe = FlattenException::create($exception);
         //$statusCode = $fe->getStatusCode();
        $statusCode = 500; 
        
        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
        }

        $error = ['error' => class_basename($exception)];
        $message = $exception->getMessage();

        if ($exception instanceof ValidationException) {
         
            $error['validation'] = $exception->validator->errors()->getMessages();
            $statusCode = 422;
            //$statusCode = $fe->getTrace();
        } else if ($exception instanceof QueryException) {
            // hide the sql and bindings if not in debug.
            //if (!config('app.debug')) {
                $message = $exception->getPrevious()->getMessage();
           // }
             
        } else if ($exception instanceof AuthorizationException) {
            $statusCode = 403;
        }

        if (!empty($message)) {
            $error['reason'] = $message;
        }
       
        return response()->json($error, $statusCode);
    }
}
