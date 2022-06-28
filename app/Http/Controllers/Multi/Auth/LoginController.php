<?php

namespace App\Http\Controllers\Multi\Auth;

use App\Events\Frontend\Auth\UserLoggedOut;
use App\Exceptions\GeneralException;
use App\Helpers\Auth\Auth;
use App\Http\Controllers\Controller;
use App\Http\Utilities\NotificationIos;
use App\Http\Utilities\PushNotification;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

/**
 * Class LoginController.
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * @var \App\Http\Utilities\PushNotification
     */
    protected $notification;

    /**
     * @param NotificationIos $notification
     */
    public function __construct(PushNotification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectPath()
    {

        return route('biller.dashboard');

    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        //return view('frontend.auth.login');
    }

    /**
     * @param Request $request
     * @param $user
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws GeneralException
     *
     */

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required_if:captcha_status,true|captcha',
        ], ['g-recaptcha-response.required_if' => 'Captcha Error']);
    }

    protected function authenticated(Request $request, $user)
    {
        /*
         * Check to see if the users account is confirmed and active
         */
        if (!$user->isConfirmed()) {
            access()->logout();

            throw new GeneralException(trans('exceptions.frontend.auth.confirmation.resend', ['user_id' => $user->id]), true);
        } elseif (!$user->isActive()) {
            access()->logout();

            throw new GeneralException(trans('exceptions.frontend.auth.deactivated'));
        }

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        if (app('session')->has(config('access.socialite_session_name'))) {
            app('session')->forget(config('access.socialite_session_name'));
        }
        app()->make(Auth::class)->flushTempSession();
        /*
         * Fire event, Log out user, Redirect
         */
        event(new UserLoggedOut($this->guard()->user()));
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/');
    }


}
