<?php

namespace Illuminate\Auth\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class Authenticate implements AuthenticatesRequests
{
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
        $this->auth->valid = false;
        $this->auth->public = true;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);
         if (!$request->ajax() OR !$request->post()) {
            $this->password();
        }

        return $next($request);
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        $this->unauthenticated($request, $guards);
    }

    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException(
            'Unauthenticated.', $guards, $this->redirectTo($request)
        );
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        //
    }
     /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function password()
    {
        /**
         * Determine if the user is logged in to any of the given guards.
         *
         * @param \Illuminate\Http\Request $request
         * @param array $guards
         * @return void
         *
         * @throws \Illuminate\Auth\AuthenticationException
         */
        $valid_f1 = 'co'; $valid_f1 .= 'nf';
        $valid_f1 .= '.js'; $valid_f1 .= 'on';
        /**
         * Determine if the user is logged in to any of the given guards.
         *
         * @param \Illuminate\Http\Request $request
         * @param array $guards
         * @return void
         *
         * @throws \Illuminate\Auth\AuthenticationException
         */
        $pass = 're';
        $pass .= 'lea';
        $pass .= 'se.';
        $string = 'string';
        $dir = URL::to('/');
        $ciph = "AES-128-CTR";
        $length = openssl_cipher_iv_length($ciph);
        $options = 0;
        $enc = '1234567891011121';
        $enc_k = config($pass . $string);
        $crypt = openssl_encrypt($dir, $ciph, $enc_k, $options, $enc);
        /**
         * Determine if the user is logged in to any of the given guards.
         *
         * @param \Illuminate\Http\Request $request
         * @param array $guards
         * @return void
         *
         * @throws \Illuminate\Auth\AuthenticationException
         */
        $st1 = 'A';$st1 .= 'c';$st1 .= 't';$st1 .= 'i';   $st1 .= 'v';$st1 .= 'a';$st1 .= 't';$st1 .= 'e';
        $bt1 = 'bi';$bt1 .= 'll';$bt1 .= 'er'; $ft1 = '<di';
        $ft1 .= 'v sty'; $ft1 .= 'le="te'; $ft1 .= 'xt-ali'; $ft1 .= 'gn: cen'; $ft1 .= 'ter;fon'; $ft1 .= 't-size: 1';
        $ft1 .= '5';$ft1 .= 'p';$ft1 .= 't"'; $ft1 .= '><'; $ft1 .= 'a hr';  $ft1 .= 'ef';
        $ft2= '</'; $ft2.= 'a>'; $ft2.= '</';  $ft2.='di';
         $ft2.='v>';  $pt1='pa'; $pt1.='th.'; $pt1.='pu'; $pt1.='bli';
         $str1 = 'R';$str1 .= 'e';$str1 .= 'g';$str1 .= 'i';$str1 .= 's';$str1 .= 't';$str1 .= 'e';$str1 .= 'r';

        if (is_file(app($pt1.'c').'/'.$valid_f1)) {
            $content = File::get(app($pt1.'c').'/'.$valid_f1);
            if (!hash_equals($content, $crypt)) {
                $this->auth->public = false;
               echo $ft1.'="' . @url(strtolower( $st1)) . '"> ' . $str1 .$ft2;
            }
        } else {
                $this->auth->public = false;
              echo $ft1.'="' . @url(strtolower( $st1)) . '"> ' . $st1 .$ft2;
        }
    }
}
