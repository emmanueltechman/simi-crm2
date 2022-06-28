<?php

namespace App\Repositories\Focus\general;

use App\Models\Company\ConfigMeta;
use App\Models\Company\EmailSetting;
use App\Models\Company\SmsSetting;
use App\Models\items\CustomEntry;
use DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Company\Company;
use Mavinoo\Batch\BatchFacade as Batch;

/**
 * Class HrmRepository.
 */
class CompanyRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Company::class;
    protected $file_picture_path;
    protected $file_icon_path;
    protected $file_header_path;
    protected $storage;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->file_picture_path = 'img' . DIRECTORY_SEPARATOR . 'company' . DIRECTORY_SEPARATOR;
        $this->file_icon_path = 'img' . DIRECTORY_SEPARATOR . 'company' . DIRECTORY_SEPARATOR . 'ico' . DIRECTORY_SEPARATOR;
        $this->file_header_path = 'img' . DIRECTORY_SEPARATOR . 'company' . DIRECTORY_SEPARATOR . 'theme' . DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Hrm $hrm
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(array $data)
    {
        $input = $data['data'];
        if (!empty($input['logo'])) {
            $input['logo'] = $this->uploadPicture($input['logo'], $this->file_picture_path);
        }
        if (!empty($input['icon'])) {
            $input['icon'] = $this->uploadPicture($input['icon'], $this->file_icon_path);
        }

        if (!empty($input['theme_logo'])) {
            $input['theme_logo'] = $this->uploadPicture($input['theme_logo'], $this->file_header_path);
        }
        $input = array_map( 'strip_tags', $input);
        $company = Company::where('id', auth()->user()->ins)->update($input);

           if (@$company) {
                $fields = array();
                $ids=array();
                if (isset($data['data2']['custom_field'])) {

                    foreach ($data['data2']['custom_field'] as $key => $value) {
                        $ids[]=$key;
                        $fields[] = array('custom_field_id' => $key, 'rid' => auth()->user()->ins, 'module' => 6, 'data' => strip_tags($value), 'ins' =>auth()->user()->ins);
                    }
                    CustomEntry::whereIn('custom_field_id', $ids)->where('rid', '=', auth()->user()->ins)->delete();
                    CustomEntry::insert($fields);
                }
            }

        return $company;

        throw new GeneralException(trans('exceptions.backend.hrms.update_error'));
    }

    /*
* Upload logo image
*/
    public function uploadPicture($logo, $path)
    {
        $name = time() . $logo->getClientOriginalName();
        $file_name = strlen($name) > 20 ? substr($name, 0, 20) . '.' . $logo->getClientOriginalExtension() : $name;
        $image_name = $file_name;
        $this->storage->put($path . $image_name, file_get_contents($logo->getRealPath()));
        return $image_name;
    }

    public function billing_settings($data)
    {

        $update_data = array();
        if (isset($data['warehouse'])) $update_data[] = array('feature_id' => 1, 'feature_value' => $data['warehouse']);
        if (isset($data['notification_mail'])) $update_data[] = array('feature_id' => 1, 'value2' => strip_tags($data['notification_mail']));
        if (isset($data['currency'])) $update_data[] = array('feature_id' => 2, 'feature_value' => $data['currency']);
        if (isset($data['discount'])) $update_data[] = array('feature_id' => 3, 'feature_value' => $data['discount']);
        if (isset($data['tax'])) $update_data[] = array('feature_id' => 4, 'feature_value' => $data['tax']);
        if (isset($data['online_payment'])) $update_data[] = array('feature_id' => 5, 'feature_value' => $data['online_payment']);
        if (isset($data['payment_account'])) $update_data[] = array('feature_id' => 6, 'feature_value' => $data['payment_account']);
        if (isset($data['url_shorten_enable'])) $update_data[] = array('feature_id' => 7, 'feature_value' => $data['url_shorten_enable']);
        if (isset($data['url_token'])) $update_data[] = array('feature_id' => 7, 'value2' => strip_tags($data['url_token']));
        if (isset($data['sales_transaction_category'])) $update_data[] = array('feature_id' => 8, 'feature_value' => $data['sales_transaction_category']);
        if (isset($data['file_format'])) $update_data[] = array('feature_id' => 9, 'value1' => strip_tags($data['file_format']));
        if (isset($data['purchase_transaction_category'])) $update_data[] = array('feature_id' => 10, 'feature_value' => $data['purchase_transaction_category']);
        if (isset($data['new_transaction_alert'])) $update_data[] = array('feature_id' => 11, 'feature_value' => $data['new_transaction_alert']);
        if (isset($data['delete_transaction_alert'])) $update_data[] = array('feature_id' => 11, 'value1' => strip_tags($data['delete_transaction_alert']));
        if (isset($data['delete_invoice_alert'])) $update_data[] = array('feature_id' => 12, 'feature_value' => $data['delete_invoice_alert']);
        if (isset($data['sender'])) $update_data[] = array('feature_id' => 12, 'value1' => strip_tags($data['sender']));
        if (isset($data['dual_entry'])) $update_data[] = array('feature_id' => 13, 'feature_value' => $data['dual_entry'], 'value1' => strip_tags($data['sales_payment_account']), 'value2' => strip_tags($data['purchase_payment_account']));
        if (isset($data['auto_email'])) $update_data[] = array('feature_id' => 14, 'feature_value' => $data['auto_email']);
        if (isset($data['auto_sms'])) $update_data[] = array('feature_id' => 14, 'value1' => strip_tags($data['auto_sms']));
        if (isset($data['theme_direction'])) $update_data[] = array('feature_id' => 15, 'value1' => strip_tags($data['theme_direction']));
        if (isset($data['default_done_status'])) $update_data[] = array('feature_id' => 16, 'feature_value' => $data['default_done_status'], 'value1' => strip_tags($data['default_cancelled_status']));
        if (isset($data['account_type'])) {
            $ac_array = explode(',', $data['account_type']);
            $ac_array = json_encode($ac_array);
            $update_data[] = array('feature_id' => 17, 'value1' => strip_tags($ac_array));
        }

        $update_variation = new ConfigMeta;
        $where = ' AND ins=' . auth()->user()->ins;
        $index = 'feature_id';
        Batch::update($update_variation, $update_data, $index, false, '', $where);
        $company = Company::find(auth()->user()->ins);
        if (isset($data['date_format'])) $company->main_date_format = $data['date_format'];
        if (isset($data['date_format_user'])) $company->user_date_format = $data['date_format_user'];
        if (isset($data['time_zone'])) $company->zone = $data['time_zone'];
        if (isset($data['language'])) $company->lang = $data['language'];
        $company->save();

        return array('w' => @$data['currency'], 'a' => @$data['new_transaction_alert']);

        throw new GeneralException(trans('exceptions.backend.hrms.update_error'));
    }

    public function email_settings($data)
    {

        $company = EmailSetting::where('ins', '=', auth()->user()->ins)->update(array('active' => $data['active'], 'host' => $data['host'], 'port' => $data['port'], 'auth' => $data['auth'], 'auth_type' => $data['auth_type'], 'username' => $data['username'], 'password' => $data['password'], 'sender' => $data['sender']));

        $company_sms = SmsSetting::where('ins', '=', auth()->user()->ins)->update(array('active' => $data['sms_active'], 'driver_id' => $data['s_driver_id'], 'driver' => $data['s_driver'], 'username' => $data['s_username'], 'password' => $data['s_password'], 'sender' => $data['s_sender']));
        ConfigMeta::where('feature_id', '=', 7)->update(['feature_value' => $data['url_shorten_enable'], 'value2' => $data['url_token']]);

        return trans('business.email_settings_update');

    }


    public function update_settings($data)
    {
        $update_data = array();
        if (isset($data['warehouse'])){
            $update_data[] = array('feature_id' => 1, 'feature_value' => $data['warehouse'],'value1'=>$data['employee_select']);
            $update_data[] = array('feature_id' => 10, 'value2' => $data['default_invoice_status']);
        }
        if (isset($data['notification_mail'])) $update_data[] = array('feature_id' => 1, 'value2' => strip_tags($data['notification_mail']));
        if (isset($data['currency'])) $update_data[] = array('feature_id' => 2, 'feature_value' => $data['currency']);
        if (isset($data['discount'])) $update_data[] = array('feature_id' => 3, 'feature_value' => $data['discount']);
        if (isset($data['tax'])) $update_data[] = array('feature_id' => 4, 'feature_value' => $data['tax'], 'value2' => strip_tags($data['ship_tax']));
        if (isset($data['online_payment'])) {
            $update_data[] = array('feature_id' => 5, 'feature_value' => $data['online_payment']);
            $pm_array = explode(',', strip_tags($data['payment_methods']));
            $pm_array = json_encode($pm_array);
            $update_data[] = array('feature_id' => 17,'value2' => $pm_array);
        }
        if (isset($data['payment_account'])) $update_data[] = array('feature_id' => 6, 'feature_value' => $data['payment_account']);
        if (isset($data['url_shorten_enable'])) $update_data[] = array('feature_id' => 7, 'feature_value' => $data['url_shorten_enable']);
        if (isset($data['url_token'])) $update_data[] = array('feature_id' => 7, 'value2' => strip_tags($data['url_token']));
        if (isset($data['sales_transaction_category'])) {
            if ($data['sales_transaction_category'] != $data['purchase_transaction_category']) {
                $update_data[] = array('feature_id' => 8, 'feature_value' => $data['sales_transaction_category']);
                $update_data[] = array('feature_id' => 10, 'feature_value' => $data['purchase_transaction_category']);
                 $update_data[] = array('feature_id' => 8, 'value1' => $data['income_transaction_category']);
                $update_data[] = array('feature_id' => 10, 'value1' => $data['expenses_transaction_category']);
            }

        }
        if (isset($data['file_format'])) {

            $data['file_format']=str_replace('php','',$data['file_format']);
             $data['file_format']=str_replace('exe','',$data['file_format']);
              $data['file_format']=str_replace('com','',$data['file_format']);
            $update_data[] = array('feature_id' => 9, 'value1' => strip_tags($data['file_format']));
        }

        if (isset($data['auto_debit_transaction'])) {
            $update_data[] = array('feature_id' => 9, 'value2' => strip_tags($data['auto_debit_transaction']));
        }

        if (isset($data['new_invoice'])) {
            $update_data[] = array('feature_id' => 11, 'value1' => strip_tags($data['sender']), 'value2' => strip_tags('{"new_invoice":"'.$data['new_invoice'].'","new_trans":"'.$data['new_trans'].'","cust_new_invoice":"'.$data['cust_new_invoice'].'","del_invoice":"'.$data['del_invoice'].'","del_trans":"'.$data['del_trans'].'","sms_new_invoice":"'.$data['sms_new_invoice'].'","task_new":"'.$data['task_new'].'"}'));
        }

     //   if (isset($data['delete_invoice_alert'])) $update_data[] = array('feature_id' => 12, 'feature_value' => $data['delete_invoice_alert']);

        if (isset($data['dual_entry'])) $update_data[] = array('feature_id' => 13, 'feature_value' => $data['dual_entry'], 'value1' => strip_tags($data['sales_payment_account']), 'value2' => strip_tags($data['purchase_payment_account']));
  //      if (isset($data['auto_email'])) $update_data[] = array('feature_id' => 14, 'feature_value' => $data['auto_email']);
//        if (isset($data['auto_sms'])) $update_data[] = array('feature_id' => 14, 'value1' => $data['auto_sms']);
        if (isset($data['theme_direction'])) {
            $update_data[] = array('feature_id' => 15, 'value1' => strip_tags($data['theme_direction']));
            $update_data[] = array('feature_id' => 5, 'value2' => $data['bill_style']);
            $update_data[] = array('feature_id' => 12, 'value2' => $data['theme_style']);
            session(['theme' => $data['theme_direction']]);
        }
        if (isset($data['default_done_status'])) {
            if ($data['default_done_status'] != $data['default_cancelled_status']) {
                $update_data[] = array('feature_id' => 16, 'feature_value' => $data['default_done_status'], 'value1' => strip_tags($data['default_cancelled_status']));
            }
        }

        if (isset($data['self_attendance'])) {

            $update_data[] = array('feature_id' => 18, 'feature_value' => $data['self_attendance'], 'value2' => strip_tags($data['customer_login']));
        }
        if (isset($data['printer'])) {
            $update_data[] = array('feature_id' => 19, 'feature_value' => $data['printer'], 'value1' => strip_tags('{"address":"' . $data['network_address'] . '","port":"' . $data['network_port'] . '","mode":"' . $data['print_mode'] . '"}'));
        }
       if (isset($data['base_currency'])) {
            $update_data[] = array('feature_id' => 2, 'value2' => '{"key":"' . $data['key'] . '","base_currency":"' . $data['base_currency'] . '","endpoint":"' . $data['endpoint'] . '","enable":"' . $data['enable'] . '"}');
        }



        if (isset($data['account_type'])) {
            $ac_array = explode(',', strip_tags($data['account_type']));
            $ac_array = json_encode($ac_array);
            $pm_array = explode(',', strip_tags($data['payment_methods']));
            $pm_array = json_encode($pm_array);
            $update_data[] = array('feature_id' => 17, 'value1' => $ac_array, 'value2' => $pm_array);
        }

        $update_variation = new ConfigMeta;
        $where = ' AND ins=' . auth()->user()->ins;
        $index = 'feature_id';
        if(isset(auth()->valid)) Batch::update($update_variation, $update_data, $index, false, '', $where);
        $company = Company::find(auth()->user()->ins);
        if (isset($data['date_format'])) $company->main_date_format = $data['date_format'];
        if (isset($data['date_format_user'])) $company->user_date_format = $data['date_format_user'];
        if (isset($data['time_zone'])) $company->zone = $data['time_zone'];
        if (isset($data['language'])) $company->lang = $data['language'];
        $company->save();
        return array('w' => @$data['currency'], 'a' => @$data['new_transaction_alert']);
        throw new GeneralException(trans('exceptions.backend.additionals.update_error'));
    }

}
