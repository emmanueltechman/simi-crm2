<?php

namespace App\Http\Controllers\Multi\Auth;

use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use App\Repositories\Frontend\Access\User\UserRepository;

/**
 * Class ConfirmAccountController.
 */
class ConfirmAccountController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * ConfirmAccountController constructor.
     *
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * @param $token
     *
     * @return mixed
     */
    public function confirm($token)
    {
        $this->user->confirmAccount($token);

        return redirect()->route('biller.index')->withFlashSuccess(trans('exceptions.frontend.auth.confirmation.success'))->withErrorSuccess(trans('exceptions.frontend.auth.confirmation.success'));
    }

    /**
     * @param $user
     *
     * @return mixed
     */
    public function sendConfirmationEmail(User $user)
    {
        $user->notify(new UserNeedsConfirmation($user->confirmation_code));

        return redirect()->route('biller.index')->withFlashSuccess(trans('exceptions.frontend.auth.confirmation.resent'));
    }
}
