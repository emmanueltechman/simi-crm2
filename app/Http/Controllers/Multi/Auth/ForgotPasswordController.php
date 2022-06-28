<?php

namespace App\Http\Controllers\Multi\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

/**
 * Class ForgotPasswordController.
 */
class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        $form = array('route' => 'frontend.auth.password.email_post', 'class' => 'form-horizontal');
        $login = 'biller.index';
        return view('core.auth.passwords.email', compact('form', 'login'));
    }
}
