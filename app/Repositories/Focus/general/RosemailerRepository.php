<?php

namespace App\Repositories\Focus\general;

use App\Models\Company\ConfigMeta;
use App\Models\Company\EmailSetting;
use DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

/**
 * Class HrmRepository.
 */
class RosemailerRepository extends BaseRepository
{


    public function __construct()
    {
        $mail_server = EmailSetting::first();
        if ($mail_server->active) {
            $config = array(
                'driver' => $mail_server->driver,
                'host' => $mail_server->host,
                'port' => $mail_server->port,
                'from' => array('address' => $mail_server->sender, 'name' => ''),
                'encryption' => $mail_server->auth_type,
                'username' => $mail_server->username,
                'password' => $mail_server->password,
                'sendmail' => '/usr/sbin/sendmail -bs',
                'pretend' => false,
            );
            Config::set('mail', $config);
        }
    }


    public function send($data, $input, $view='focus.mailable.bill',$output = '')
    {
        try {
            Mail::send($view, array('title'=>config('core.cname'),'body' => $data), function ($message) use ($input) {
                $str_mailer = explode ("+", $input['mail_to']);
                if(isset($str_mailer[1])){
                    $message->to($str_mailer[0]);
                    array_shift($str_mailer);
                    $message->bcc($str_mailer);

                } else {
                    $message->to($input['mail_to']);
                }

                $message->subject($input['subject']);
            });
        } catch (\Exception $e) {
            return json_encode(array('status' => 'Error', 'message' => trans('general.email_error')));
        }
        if (!$output) $output = array('status' => 'Success', 'message' => trans('general.email_sent'));
        return json_encode($output);
    }

    public function send_group($data, $input,$view='focus.mailable.bill', $output = '')
    {
        try {
            Mail::send($view, array('title'=>config('core.cname'),'body' => $data), function ($message) use ($input) {
                $message->to(config('core.email'));
                $message->bcc($input['email']);
                $message->subject($input['subject']);
            });
        } catch (\Exception $e) {
            return json_encode(array('status' => 'Error', 'message' => trans('general.email_error')));
        }

        if (!$output) $output = array('status' => 'Success', 'message' => trans('general.email_sent'));
        return json_encode($output);
    }



}
