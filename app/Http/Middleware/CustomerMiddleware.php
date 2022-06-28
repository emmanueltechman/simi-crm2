<?php

namespace App\Http\Middleware;

use App\Models\Company\Company;
use App\Models\Company\ConfigMeta;
use Illuminate\Support\Facades\Auth;
use Closure;

class CustomerMiddleware
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
        if (!session()->has('theme')) {
            session(['theme' => 'ltr']);
        }
        if (auth()->guard($guard)->check()) {
            $company = Company::where('id', '=', auth()->guard($guard)->user()->ins)->where('valid', '=', 1)->first();
            config([
                'core' => $company
            ]);
            config([
                'currency' => ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 2)->where('ins', '=', $company->id)->first()->currency
            ]);

        } else {

            return redirect(route('crm.login'));

        }
        return $next($request);
    }
}