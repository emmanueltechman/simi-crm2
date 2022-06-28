<?php

namespace App\Http\Middleware;

use App\Models\Company\Company;
use App\Models\Company\ConfigMeta;
use Closure;
use Illuminate\Support\Facades\App;

class FocusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (App::environment('production')) {
            error_reporting(0);
        }
        //current user fetch
        $user_d = auth();

        if (isset($user_d->valid)) {
            $company = Company::where('id', '=', $user_d->user()->ins)->where('valid', '=', 1)->first();
            config([
                'core' => $company
            ]);
            config([
                'currency' => ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 2)->where('ins', '=', $company->id)->first()->currency
            ]);

            config(['app.timezone' => $company->zone]);
            date_default_timezone_set($company->zone);

            return $next($request);
        }
    }
}
