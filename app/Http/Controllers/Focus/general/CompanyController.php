<?php
/*
 * Rose Business Suite - Accounting, CRM and POS Software
 * Copyright (c) UltimateKode.com. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */

namespace App\Http\Controllers\Focus\general;

use App\Models\Company\ConfigMeta;
use App\Models\customfield\Customfield;
use App\Models\items\CustomEntry;
use App\Models\misc\Misc;
use App\Repositories\Focus\general\CompanyRepository;
use App\Http\Responses\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Focus\general\ManageCompanyRequest;
use App\Models\Company\Company;
use App\Http\Responses\ViewResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * variable to store the repository object
     * @var CompanyRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param CompanyRepository $repository ;
     */
    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function manage(ManageCompanyRequest $request)
    {
        $company = Company::where('id', '=', auth()->user()->ins)->first();


        $fields = Customfield::where('module_id', '=', 6)->get()->groupBy('field_type');
        $fields_raw = array();

        if (isset($fields['text'])) {
            foreach ($fields['text'] as $row) {
                $data = CustomEntry::where('custom_field_id', '=', $row['id'])->where('module', '=', 6)->where('rid', '=', $company->id)->first();
                $fields_raw['text'][] = array('id' => $row['id'], 'name' => $row['name'], 'default_data' => $data['data']);
            }
        }
        if (isset($fields['number'])) {
            foreach ($fields['number'] as $row) {
                $data = CustomEntry::where('custom_field_id', '=', $row['id'])->where('module', '=', 6)->where('rid', '=', $company->id)->first();
                $fields_raw['number'][] = array('id' => $row['id'], 'name' => $row['name'], 'default_data' => $data['data']);
            }
        }

        $fields_data = custom_fields($fields_raw);




        return  view('focus.general.company', compact('company', 'fields_data'));
    }

    public function update(ManageCompanyRequest $request)
    {
        $data = $request->only(['cname', 'address', 'city', 'region', 'country', 'postbox', 'taxid', 'logo', 'theme_logo', 'icon', 'phone', 'email']);
        $data2 = $request->only(['custom_field']);

        if (!empty($data['logo'])) {
            $request->validate([
                'logo' => 'mimes:jpeg,png',
            ]);
        }
        if (!empty($data['theme_logo'])) {
            $request->validate([
                'theme_logo' => 'mimes:jpeg,png',
            ]);
        }
        if (!empty($data['icon'])) {
            $request->validate([
                'icon' => 'mimes:ico',
            ]);

        }

        $result = $this->repository->update(compact('data', 'data2'));

        return new RedirectResponse(route('biller.business.settings'), ['flash_success' => trans('business.updated')]);
    }

    public function billing_settings(ManageCompanyRequest $request)
    {
        $defaults = \App\Models\Company\ConfigMeta::get()->groupBy('feature_id');

        if (@$request->get('p1')) {
            $data['section'] = true;
        } else {
            $data['section'] = false;
            $company = Company::where('id', '=', auth()->user()->ins)->first();
            $data['warehouses'] = \App\Models\warehouse\Warehouse::all();
            $data['additionals'] = \App\Models\additional\Additional::all();
            $data['currencies'] = \App\Models\currency\Currency::all();
            $data['accounts'] = \App\Models\account\Account::all();
            $data['transaction_categories'] = \App\Models\transactioncategory\Transactioncategory::all();
            $account_types = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 17)->first('value1');
            $account_types = json_decode($account_types->value1, true);
            $account_types = implode(",", $account_types);
            $data['status'] = Misc::where('section', '=', 2)->get();
        }
        return new ViewResponse('focus.general.billing_settings', compact('data', 'defaults', 'account_types'));
    }

    public function billing_settings_update(ManageCompanyRequest $request)
    {
        $data = $this->repository->billing_settings($request);

        if (isset($data['a'])) return new RedirectResponse(route('biller.business.billing_settings') . '?p1=alert', ['flash_success' => trans('business.billing_settings_update')]);
        return new RedirectResponse(route('biller.business.billing_settings'), ['flash_success' => trans('business.billing_settings_update')]);
    }

    public function email_sms_settings(ManageCompanyRequest $request)
    {
        $smtp = \App\Models\Company\EmailSetting::first();
        $sms = \App\Models\Company\SmsSetting::first();
        $url_short = \App\Models\Company\ConfigMeta::where('feature_id', '=', 7)->first();
        return new ViewResponse('focus.general.email_settings', compact('smtp', 'sms', 'url_short'));
    }

    public function email_settings_update(ManageCompanyRequest $request)
    {
        $message = $this->repository->email_settings($request);
        return new RedirectResponse(route('biller.business.email_sms_settings'), ['flash_success' => $message]);
    }

    public function activate(ManageCompanyRequest $request)
    {
        if (single_ton()) {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            if ($request->post()) {
                $out = active($request->post());
                return new RedirectResponse(route('biller.dashboard'), $out);
            }
            return new ViewResponse('focus.general.active');
        }
        return new ViewResponse('focus.general.not_applicable');
    }


    public function billing_preference(ManageCompanyRequest $request)
    {

        if ($request->post()) {
            $data = $this->repository->update_settings($request);
            return new RedirectResponse(route('biller.settings.billing_preference'), ['flash_success' => trans('business.billing_settings_update')]);
        }

        $defaults = \App\Models\Company\ConfigMeta::get()->groupBy('feature_id');

        $company = Company::where('id', '=', auth()->user()->ins)->first();
        $data['warehouses'] = \App\Models\warehouse\Warehouse::all();
        $data['additionals'] = \App\Models\additional\Additional::all();

        return view('focus.general.settings.billing_pref', compact('data', 'defaults'));

    }


    public function payment_preference(ManageCompanyRequest $request)
    {

        if ($request->post()) {
            $data = $this->repository->update_settings($request);
            return new RedirectResponse(route('biller.settings.payment_preference'), ['flash_success' => trans('business.billing_settings_update')]);
        }

        $defaults = \App\Models\Company\ConfigMeta::get()->groupBy('feature_id');

        $payment_methods = json_decode($defaults[17][0]['value2'], true);
        if (is_array($payment_methods)) $data['payment_methods'] = implode(",", $payment_methods);

        $data['currencies'] = \App\Models\currency\Currency::all();
        $data['additionals'] = \App\Models\additional\Additional::all();
        $data['accounts'] = \App\Models\account\Account::all();
        return view('focus.general.settings.payment_pref', compact('data', 'defaults'));

    }


    public function accounts(ManageCompanyRequest $request)
    {

        if ($request->post()) {
            $data = $this->repository->update_settings($request);
            return new RedirectResponse(route('biller.settings.accounts'), ['flash_success' => trans('business.billing_settings_update')]);
        }

        $defaults = \App\Models\Company\ConfigMeta::get()->groupBy('feature_id');

        $data['accounts'] = \App\Models\account\Account::all();
        $m_types = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 17)->first();
        $account_types = json_decode($m_types->value1, true);
        if (is_array($account_types)) $account_types = implode(",", $account_types);
        $payment_methods = json_decode($m_types->value2, true);
        if (is_array($payment_methods)) $payment_methods = implode(",", $payment_methods);
        $data['transaction_categories'] = \App\Models\transactioncategory\Transactioncategory::all();
        return view('focus.general.settings.accounts', compact('data', 'defaults', 'account_types', 'payment_methods'));

    }

    public function auto_communication(ManageCompanyRequest $request)
    {

        if ($request->post()) {
            $data = $this->repository->update_settings($request);
            return new RedirectResponse(route('biller.settings.auto_communication'), ['flash_success' => trans('business.billing_settings_update')]);
        }

        $defaults = \App\Models\Company\ConfigMeta::get()->groupBy('feature_id');


        return view('focus.general.settings.auto_communication', compact('data', 'defaults'));

    }

    public function notification_email(ManageCompanyRequest $request)
    {

        if ($request->post()) {
            $this->repository->update_settings($request->post());
            return new RedirectResponse(route('biller.settings.notification_email'), ['flash_success' => trans('business.billing_settings_update')]);
        }

        $feature = feature(11);
        $data = json_decode($feature->value2, true);
        $email = $feature->value1;
        return view('focus.general.settings.notification_email', compact('data', 'email'));

    }

    public function localization(ManageCompanyRequest $request)
    {

        if ($request->post()) {
            $data = $this->repository->update_settings($request);
            return new RedirectResponse(route('biller.settings.localization'), ['flash_success' => trans('business.billing_settings_update')]);
        }

        $defaults = \App\Models\Company\ConfigMeta::get()->groupBy('feature_id');


        $data['additionals'] = \App\Models\additional\Additional::all();

        return view('focus.general.settings.localization', compact('data', 'defaults'));

    }

    public function theme(ManageCompanyRequest $request)
    {

        if ($request->post()) {
            $data = $this->repository->update_settings($request);
            return new RedirectResponse(route('biller.settings.theme'), ['flash_success' => trans('business.billing_settings_update')]);
        }

        $defaults = \App\Models\Company\ConfigMeta::get()->groupBy('feature_id');


        $data['additionals'] = \App\Models\additional\Additional::all();

        return view('focus.general.settings.theme', compact('data', 'defaults'));

    }

    public function status(ManageCompanyRequest $request)
    {

        if ($request->post()) {
            $data = $this->repository->update_settings($request);
            return new RedirectResponse(route('biller.settings.status'), ['flash_success' => trans('business.billing_settings_update')]);
        }

        $defaults = \App\Models\Company\ConfigMeta::get()->groupBy('feature_id');


        $data['additionals'] = \App\Models\additional\Additional::all();
        $data['status'] = Misc::where('section', '=', 2)->get();

        return view('focus.general.settings.status', compact('data', 'defaults'));

    }

    public function crm_hrm_section(ManageCompanyRequest $request)
    {
        if ($request->post()) {
            $data = $this->repository->update_settings($request);
            return new RedirectResponse(route('biller.settings.crm_hrm_section'), ['flash_success' => trans('business.billing_settings_update')]);
        }
        $defaults = \App\Models\Company\ConfigMeta::get()->groupBy('feature_id');
        return view('focus.general.settings.crm_hrm_section', compact('defaults'));
    }

    public function pos_preference(ManageCompanyRequest $request)
    {

        if ($request->post()) {
            $data = $this->repository->update_settings($request);
            return new RedirectResponse(route('biller.settings.pos_preference'), ['flash_success' => trans('business.billing_settings_update')]);
        }

        $defaults = feature(19);

        $conf = json_decode($defaults->value1, true);
        return view('focus.general.settings.pos_pref', compact('defaults', 'conf'));

    }

    public function currency_exchange(ManageCompanyRequest $request)
    {

        if ($request->post()) {
            $data = $this->repository->update_settings($request);
            return new RedirectResponse(route('biller.settings.currency_exchange'), ['flash_success' => trans('business.billing_settings_update')]);
        }

        $defaults = feature(2);

        $conf = json_decode($defaults->value2, true);
        if (single_ton()) $conf['readonly'] = ''; else $conf['readonly'] = 'readonly';
        return view('focus.general.settings.exchange', compact('conf'));

    }

    public function clear_cache()
    {
        if (single_ton()) {
            Artisan::call('cache:clear');
            Artisan::call('route:cache');
            Artisan::call('config:cache');
            return "Cache is cleared";
        }
    }

    public function dev_manager(ManageCompanyRequest $request)
    {


        if ($request->post()) {

            if ($request->post('dev_mode') == 1) {
                $this->setEnvFly('APP_DEBUG', 'false', 'true');
            } else {
                $this->setEnvFly('APP_DEBUG', 'true', 'false');
            }

            if ($request->post('create_link') == 1) {
               // Artisan::call('storage:link');
                symlink($request->post('from_path'),$request->post('to_path'));

            }
            return view('focus.general.dev');

        } else {
            return view('focus.general.dev');
        }


    }

    private function setEnvFly($env_var, $current_configKey, $new_val)
    {

        //'APP_DEBUG', 'app.debug', 'true'
        //env file path
        file_put_contents(App::environmentFilePath(), str_replace(
            $env_var . '=' . $current_configKey,
            $env_var . '=' . $new_val,
            file_get_contents(App::environmentFilePath())
        ));

        Config::set('app.' . strtolower($env_var), $new_val);


        if (file_exists(App::getCachedConfigPath())) {
            Artisan::call("config:clear");
        }
    }




}
