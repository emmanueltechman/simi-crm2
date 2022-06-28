<?php

namespace RachidLaasri\LaravelInstaller\Controllers;

use App\Models\Access\User\User;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use RachidLaasri\LaravelInstaller\Events\EnvironmentSaved;
use RachidLaasri\LaravelInstaller\Helpers\EnvironmentManager;
use Validator;
use Illuminate\Support\Facades\URL;

class EnvironmentController extends Controller
{
    /**
     * @var EnvironmentManager
     */
    protected $EnvironmentManager;

    /**
     * @param EnvironmentManager $environmentManager
     */
    public function __construct(EnvironmentManager $environmentManager)
    {
        $this->EnvironmentManager = $environmentManager;
    }

    /**
     * Display the Environment menu page.
     *
     * @return \Illuminate\View\View
     */
    public function environmentMenu()
    {
        return view('vendor.installer.environment');
    }

    /**
     * Display the Environment page.
     *
     * @return \Illuminate\View\View
     */
    public function environmentWizard()
    {

        $envConfig = $this->EnvironmentManager->getEnvContent();

        if ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') or !empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            URL::forceScheme('https');
        }

        return view('vendor.installer.environment-wizard', compact('envConfig'));
    }

    /**
     * Display the Environment page.
     *
     * @return \Illuminate\View\View
     */
    public function environmentClassic()
    {

        return null;
    }

    /**
     * Processes the newly saved environment configuration (Classic).
     *
     * @param Request $input
     * @param Redirector $redirect
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveClassic(Request $input, Redirector $redirect)
    {
        return false;
    }

    /**
     * Processes the newly saved environment configuration (Form Wizard).
     *
     * @param Request $request
     * @param Redirector $redirect
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveWizard(Request $request, Redirector $redirect)
    {
           try {

               $flag = true;
               $code = '';
               $status = 'Success';
               $rules = config('installer.environment.form.rules');
               $messages = [
                   'environment_custom.required_if' => trans('installer_messages.environment.wizard.form.name_required'),
               ];
               $m = '<ul>';

               $validator = Validator::make($request->all(), $rules, $messages);

               if ($validator->fails()) {
                   $status = 'Error';
                   $flag = false;
                   foreach ($validator->errors()->all() as $error) {
                       $m .= '<li>' . $error . '</li>';
                   }
                   $code = 'F3';
               }

               if (!$this->checkDatabaseConnection($request)) {
                   $status = 'Error';
                   $flag = false;
                   $m .= '<li>' . trans('installer_messages.environment.wizard.form.db_connection_failed') . '</li>';
                   $code = 'D6';
               }
               $valid = $this->checkValid($request);

               $valid = json_decode($valid, true);

               if (@$valid['valid']) {
                   $this->confirmValid($request);
               } else {
                   $status = 'Error';
                   $flag = false;
                   $m .= '<li>' . trans('installer_messages.environment.wizard.form.verification_failed') . '</li>';
                   $code = 'C5';
               }
               if (@$valid['status'] == 'Error') {
                   $status = 'Error';
                   $flag = false;
                   $m .= $valid['message'];
               }
               $m .= '</ul>';


               if ($flag) {
                   $m .= '<li>Installation Success, Installer locked to prevent re-installation</li>';
                   $results = $this->EnvironmentManager->saveFileWizard($request);
                   event(new EnvironmentSaved($request));
                   return json_encode(array('status' => $status, 'message' => $m));
               } else {
                   return json_encode(array('status' => $status, 'message' => $m));
               }
           } catch (Exception $e){
                   return json_encode(array('status' => 'Error', 'message' => 'Indicating Unsupported PHP Version & '.$e->getMessage()));
           }

    }

    /**
     * TODO: We can remove this code if PR will be merged: https://github.com/RachidLaasri/LaravelInstaller/pull/162
     * Validate database connection with user credentials (Form Wizard).
     *
     * @param Request $request
     * @return bool
     */
    private function checkDatabaseConnection(Request $request)
    {
        $connection = $request->input('database_connection');
        DB::purge('mysql');
        Config::set('database.connections.mysql', [
            'driver' => $connection,
            'host' => $request->input('database_hostname'),
            'port' => $request->input('database_port'),
            'database' => $request->input('database_name'),
            'username' => $request->input('database_username'),
            'password' => $request->input('database_password'),
        ]);
        try {
            DB::connection('mysql')->getPdo();
            if (DB::connection('mysql')->getDatabaseName()) {
                return true;

            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    private function checkValid(Request $request)
    {
        $config = Config::get('version');
        $build = $config['build'];
        $zone = $config['zone'];

        try {
            $client = new Client(["base_uri" => $zone]);
            $options = [
                'form_params' => [
                    "c" => $request->input('purchase_code'),
                    "mail" => $request->input('user_email'),
                    "u" => url('/'),
                ]
            ];
            $response = $client->post('confirm/' . $build . '/', $options);
            $stream = $response->getBody();
            $contents = $stream->getContents();

            return $contents;
        } catch (GuzzleException $e) {
            return json_encode(array('status' => 'Error', 'message' => trans('installer_messages.environment.wizard.form.db_communication_failed')));
        }

    }

    private function confirmValid(Request $request)
    {
        //File Fetch Section Open
        $config = Config::get('version');
        $build = $config['build'];
        $zone = $config['zone'];

        try {
            $client = new Client(["base_uri" => $zone]);
            $options = [
                'form_params' => [
                    "c" => $request->input('purchase_code'),
                    "mail" => $request->input('user_email'),
                      "u"=>url('/'),
                ]
            ];
            $response = $client->post('confirm/' . $build . '/valid.php', $options);
            $stream = $response->getBody();
            $contents = $stream->getContents();
        } catch (GuzzleException $e){
           return array('status' => 'Error', 'message' => trans('installer_messages.environment.wizard.form.db_communication_failed').$e->getMessage());

        }



        if (isset($contents)) {
            $connection = $request->input('database_connection');
            DB::purge('mysql');
            Config::set('database.connections.mysql', [
                'driver' => $connection,
                'host' => $request->input('database_hostname'),
                'port' => $request->input('database_port'),
                'database' => $request->input('database_name'),
                'username' => $request->input('database_username'),
                'password' => $request->input('database_password'),
            ]);
            try {
                $conn = DB::connection('mysql');
                if ($conn->getDatabaseName()) {
                    ini_set('memory_limit', '-1');
                    $conn->unprepared($contents);
                    $conn->commit();
                    return true;

                } else {
                    return array('status' => 'Error', 'message' => trans('installer_messages.environment.wizard.form.db_connection_failed'));

                }
            } catch (\Exception $e) {
                return array('status' => 'Error', 'message' => trans('installer_messages.environment.wizard.form.db_connection_failed'));

            }
        } else {
            return false;
        }

    }

}
