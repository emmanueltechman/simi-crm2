<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Access\User\UserRepository;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\customer\CustomerLogin;
use App\Models\Access\User\Traits\UserSendPasswordReset;
use Illuminate\Support\Facades\Password;

/**
 * Class ResetPasswordController.
 */
class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * ChangePasswordController constructor.
     *
     * @param UserRepository $user
     */
    public function __construct(CustomerLogin $user)
    {
        $this->user = new CustomerLogin;
    }

    protected function guard()
    {
        return Auth::guard('crm');
    }

    /**
     * Where to redirect users after resetting password.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route('crm.login');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param string|null $token
     *
     * @return \Illuminate\Http\Response
     */
    public function showResetForm(Request $request)
    {
        $token = $request->token;

        if (!$token) {
            return redirect()->route('crm.password.email');
        }

        $user = $this->user->findByPasswordResetToken($token);

        if ($user && app()->make('auth.password.broker')->tokenExists($user, $token)) {
            return view('core.auth.passwords.reset')
                ->withToken($token)->withForm(['route' => 'crm.password.reset', 'class' => 'form-horizontal'])
                ->withEmail($user->email);
        }

        //       return redirect()->route('frontend.auth.password.email')
        //        ->withFlashDanger(trans('exceptions.frontend.auth.password.reset_problem'));
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed|regex:"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$"',
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [
            'password.regex' => 'Password must contain at least 1 uppercase letter and 1 number.',
        ];
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $response
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetResponse($request, $response)
    {
        return redirect()->route('crm.login')->withFlashSuccess(trans($response));
    }

    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.

        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }

    public function broker()
    {
        return Password::broker('crm');
    }

    protected function setUserPassword($user, $password)
    {
        $user->password = $password;
    }
}
