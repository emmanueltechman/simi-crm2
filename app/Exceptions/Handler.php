<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [ModelNotFoundException::class
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (\Exception  $e, $request) {
                if (!$request->expectsJson() AND $e->getCode()) {
                    if (config('app.debug')) {
                        $code = 'Message: <br>' . $e->getMessage() . '<br><br>File: <br>' . $e->getFile() . '<br><br>Line: ' . $e->getLine() . '<br><br><strong>Solutions:</strong> Set your application mode to production or Check the support guide to get more about the error';
                        return response()->view('errors.1303', ['code' => $code], 503);
                    }
                return response()->view('errors.1303', ['code' => ' Set your application mode as production or Check the support guide to get more details about the error.<br><br>' . $e->getCode()], 503);
                }
        });

    }
}
