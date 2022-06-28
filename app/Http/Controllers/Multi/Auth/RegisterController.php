<?php

namespace App\Http\Controllers\Multi\Auth;

use App\Events\Frontend\Auth\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\RegisterRequest;
use App\Repositories\Frontend\Access\User\UserRepository;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\Settings\Setting;
use Illuminate\Support\Facades\Auth;

/**
 * Class RegisterController.
 */
class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        // Where to redirect users after registering
        $this->redirectTo = route('frontend.index');

        $this->user = $user;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('biller.dashboard');
        } else {
            $settingData = Setting::first();
            return view('frontend.auth.register', array('setting' => $settingData));
        }


    }

    /**
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(RegisterRequest $request)
    {

        /*if (config('access.users.confirm_email')) {
            $user = $this->user->create($request->all());
            event(new UserRegistered($user));

            return redirect($this->redirectPath())->withFlashSuccess(trans('exceptions.frontend.auth.confirmation.created_confirm'));
        } else {
            access()->login($this->user->create($request->all()));
            event(new UserRegistered(access()->user()));

            return redirect($this->redirectPath());
        }*/


        if (config('access.users.confirm_email') || config('access.users.requires_approval')) {

            $data = $request->only('first_name', 'email', 'password', 'is_term_accept');

            $name_split = explode(" ", $data['first_name']);

            if (isset($name_split[2])) {
                $data['first_name'] = $name_split[0] . ' ' . $name_split[1];
                $data['last_name'] = $name_split[2];

            } elseif (isset($name_split[1])) {

                $data['first_name'] = $name_split[0];
                $data['last_name'] = $name_split[1];
            } else {
                $data['first_name'] = $name_split[0];
                $data['last_name'] = ' ';
            }

            $user = $this->user->create($data);

            event(new UserRegistered($user));


            $m = config('access.users.requires_approval') ?
                trans('exceptions.frontend.auth.confirmation.created_pending') :
                trans('exceptions.frontend.auth.confirmation.created_confirm');


            return json_encode(array('status' => 'Success', 'message' => $m));
        } else {
            $new_user = $this->user->create($request->only('first_name', 'last_name', 'email', 'password', 'is_term_accept'));

            $this->user->confirmAccount($new_user->confirmation_code, false);

            access()->login($new_user);
            event(new UserRegistered(access()->user()));
            $m = trans('exceptions.frontend.auth.confirmation.success');

            return json_encode(array('status' => 'Success', 'message' => $m));


        }
    }
}
