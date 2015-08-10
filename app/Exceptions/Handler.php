<?php

namespace GottaShit\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException as MethodNotAllowedHttpException;
use Illuminate\Session\TokenMismatchException as TokenMismatchException;
use BadMethodCallException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $capture = true;

        if($capture){
            if ($e instanceof TokenMismatchException )
            {
                return response()->view('errors.token');
            }
            if ($e instanceof BadMethodCallException )
            {
                return response()->view('errors.404');
            }
            if ($e instanceof ModelNotFoundException)
            {
                return response()->view('errors.404');
            }

            if ($e instanceof MethodNotAllowedHttpException)
            {
                return response()->view('errors.404');
            }

        }

        return parent::render($request, $e);
    }
}
