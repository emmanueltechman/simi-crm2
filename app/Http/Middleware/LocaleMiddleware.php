<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Class LocaleMiddleware.
 */
class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
         * Locale is enabled and allowed to be changed
         */
        if (config('locale.status')) {
            if (session()->has('locale') && in_array(session()->get('locale'), array_keys(config('locale.languages')))) {
                /*
                 * Set the Laravel locale
                 */
                app()->setLocale(session()->get('locale'));

                /*
                 * setLocale for php. Enables ->formatLocalized() with localized values for dates
                 */
                setlocale(LC_TIME, config('locale.languages')[session()->get('locale')][1]);

                /*
                 * setLocale to use Carbon source locales. Enables diffForHumans() localized
                 */
                Carbon::setLocale(config('locale.languages')[session()->get('locale')][0]);

                /*
                 * Set the session variable for whether or not the app is using RTL support
                 * for the current language being selected
                 * For use in the blade directive in BladeServiceProvider
                 */
                if (config('locale.languages')[session()->get('locale')][2]) {
                    session(['lang-rtl' => true]);
                  //  session(['theme' => 'rtl']);
                } else {
                 //   session(['theme' => 'ltr']);
                   session()->forget('lang-rtl');
                }
            } elseif(@Auth::user()->lang) {
                app()->setLocale(Auth::user()->lang);
                session()->put('locale', Auth::user()->lang);
            }
        }


        return $next($request);
    }
}
