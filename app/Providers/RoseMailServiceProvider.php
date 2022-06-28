<?php

namespace App\Providers;


use App\Models\Company\EmailSetting;
use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;


class RoseMailServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('views', function () {
            if (Auth::check()) {
                $mail = EmailSetting::first();
                dd($mail);
            }
        });
        /*
                \Illuminate\Support\Facades\View::composer('biller', function($view) {
                    if (Auth::check()) {


                        $mail = EmailSetting::first();
        dd($mail);
                        if (@$mail->active) {
                            $config = array(
                                'driver' => $mail->driver,
                                'host' => $mail->host,
                                'port' => $mail->port,
                                'from' => array('address' => $mail->sender),
                                'encryption' => $mail->auth_type,
                                'username' => $mail->username,
                                'password' => $mail->password,
                                'sendmail' => '/usr/sbin/sendmail -bs',
                                'pretend' => false,
                            );
                            Config::set('mail', $config);
                        }
                    }
                            });
        */
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {


    }
}