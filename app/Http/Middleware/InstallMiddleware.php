<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class InstallMiddleware
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
        if (file_exists(storage_path('installed'))) {
            return $next($request);
        } else {
            return redirect(route('install'));
        }


    }
}