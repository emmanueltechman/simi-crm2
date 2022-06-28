<?php
/*
 * Rose Business Suite - Accounting, CRM and POS Software
 * Copyright (c) UltimateKode.com. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */
namespace App\Http\Controllers\Crm;

use App\Http\Responses\RedirectResponse;
use App\Models\Company\ConfigMeta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class CustomerLogin extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/crm/home';

    /**
     **_ Create a new controller instance.
     * _**
     **_ @return void
     * _**/
    public function __construct()
    {
        if (!session()->has('theme')) {
            session(['theme' => 'ltr']);
        }

        $this->middleware('guest')->except('logout');
        Auth::logout();

    }

    /**
     * _
     * _ @return property guard use for login
     * _
     * _&*/
    public function guard()
    {

        return Auth::guard('crm');
    }

    protected function authenticated(Request $request, $user)
    {


    }

    // login from for customer
    public function showLoginForm()
    {

        if (Auth::guard('crm')->check()) {

            return new RedirectResponse(route('crm.invoices.index'), ['']);

        }
        return view('crm.login');
    }


    public function login(Request $request)
    {

        $this->validateLogin($request);


        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $u = ConfigMeta::withoutGlobalScopes()->where('ins', '=', auth('crm')->user()->ins)->where('feature_id', '=', 15)->first('value1')->value1;
            $login = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 18)->first('value2')->value2;
            session(['theme' => $u]);
            if (!$login) return $this->disabled($request);

            return $this->sendLoginResponse($request);


        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    protected function sendLoginResponse(Request $request)
    {

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return new RedirectResponse(route('crm.invoices.index'), ['']);
    }


    public function logout(Request $request)
    {
        Auth::guard('crm')->logout();
        return new RedirectResponse(route('crm.login'), ['flash_success' => trans('customers.logout_success')]);
    }

    public function disabled(Request $request)
    {
        Auth::guard('crm')->logout();
        return new RedirectResponse(route('crm.login'), ['flash_error' => trans('customers.login_is_suspended')]);
    }


}
