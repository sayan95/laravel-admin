<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function(Throwable $e, Request $request){
            if($e instanceof AuthenticationException && $request->expectsJson()){
                return response()->json([
                    "error" => 'Sorry, you are not authorized to access this resource'
                ], Response::HTTP_UNAUTHORIZED);
            }

            if($e instanceof AccessDeniedHttpException && $request->expectsJson()){
                return response()->json([
                    'error' => 'This action is unauthorized'
                ], Response::HTTP_FORBIDDEN);
            }

            if($e instanceof NotFoundHttpException && $request->expectsJson()){
                return response()->json([
                    'error' => 'Oops! Nothing was found'
                ], Response::HTTP_NOT_FOUND);
            }
        }); 
    }
}
