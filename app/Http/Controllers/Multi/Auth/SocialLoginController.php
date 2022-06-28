<?php

namespace App\Http\Controllers\Multi\Auth;

use App\Events\Frontend\Auth\UserLoggedIn;
use App\Exceptions\GeneralException;
use App\Helpers\Frontend\Auth\Socialite as SocialiteHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Access\User\UserRepository;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class SocialLoginController.
 */
class SocialLoginController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * @var SocialiteHelper
     */
    protected $helper;

    /**
     * SocialLoginController constructor.
     *
     * @param UserRepository $user
     * @param SocialiteHelper $helper
     */
    public function __construct(UserRepository $user, SocialiteHelper $helper)
    {
        $this->user = $user;
        $this->helper = $helper;
    }

    /**
     * @param Request $request
     * @param $provider
     *
     * @return \Illuminate\Http\RedirectResponse|mixed
     * @throws GeneralException
     *
     */
    public function login(Request $request, $provider)
    {

    }


}
