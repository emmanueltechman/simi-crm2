<?php

namespace App\Http\Middleware;

use Closure;


class PublicBillMiddleware
{
    /*
     _ Handle an incoming request.
     _
     _ @param  \Illuminate\Http\Request  $request
     _ @param  \Closure  $next
     _ @return mixed
     */
    public function handle($request, Closure $next, $guard = "crm")
    {


        return $next($request);

    }
}