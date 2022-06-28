<?php

namespace App\Repositories\Frontend\Access\User;

use App\Events\Frontend\Auth\UserConfirmed;
use App\Exceptions\GeneralException;
use App\Models\Access\User\SocialLogin;
use App\Models\Access\User\User;
use App\Models\Access\User\UserProfile;
use App\Models\account\Account;
use App\Models\additional\Additional;
use App\Models\Company\Company;
use App\Models\Company\ConfigMeta;
use App\Models\Company\EmailSetting;
use App\Models\currency\Currency;
use App\Models\customer\Customer;
use App\Models\customergroup\Customergroup;
use App\Models\hrm\HrmMeta;
use App\Models\items\Prefix;
use App\Models\misc\Misc;
use App\Models\productcategory\Productcategory;
use App\Models\template\Template;
use App\Models\term\Term;
use App\Models\transactioncategory\Transactioncategory;
use App\Models\warehouse\Warehouse;
use App\Notifications\Frontend\Auth\UserChangedPassword;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use  App\Repositories\Focus\role\RoleRepository;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = User::class;

    /**
     * @var RoleRepository
     */
    protected $role;
    protected $user_picture_path;

    /**
     * @param RoleRepository $role
     */
    public function __construct(RoleRepository $role)
    {
        $this->role = $role;
        $this->user_picture_path = 'img' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR;
        $this->user_sign_path = 'img' . DIRECTORY_SEPARATOR . 'signs' . DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }

    /**
     * @param $email
     *
     * @return bool
     */
    public function findByEmail($email)
    {
        return $this->query()->where('email', $email)->first();
    }

    /**
     * @param $token
     *
     * @return mixed
     * @throws GeneralException
     *
     */
    public function findByToken($token)
    {
        return $this->query()->where('confirmation_code', $token)->first();
    }

    /**
     * @param $token
     *
     * @return mixed
     * @throws GeneralException
     *
     */
    public function getEmailForPasswordToken($token)
    {
        $rows = DB::table(config('auth.passwords.users.table'))->get();

        foreach ($rows as $row) {
            if (password_verify($token, $row->token)) {
                return $row->email;
            }
        }

        throw new GeneralException(trans('auth.unknown'));
    }

    /**
     * Create User.
     *
     * @param array $data
     * @param bool $provider
     *
     * @return static
     */
    public function create(array $data, $provider = false)
    {
        $user = self::MODEL;
        $user = new $user();
        $user->first_name = strip_tags($data['first_name']);
        $user->last_name =  strip_tags($data['last_name']);
        $user->email =  strip_tags($data['email']);
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->status = 1;
        $user->password = $data['password'];
        $user->is_term_accept = $data['is_term_accept'];
        $user->picture = 'user.png';
        $user->signature = 'sign.png';
        $user->ins = NULL;


        // If users require approval, confirmed is false regardless of account type
        if (config('access.users.requires_approval')) {
            $user->confirmed = 0; // No confirm e-mail sent, that defeats the purpose of manual approval
        } elseif (config('access.users.confirm_email')) { // If user must confirm email
            // If user is from social, already confirmed
            if ($provider) {
                $user->confirmed = 1; // E-mails are validated through the social platform
            } else {
                // Otherwise needs confirmation
                $user->confirmed = 0;
                $confirm = true;
            }
        } else {
            // Otherwise both are off and confirmed is default
            $user->confirmed = 1;
        }

        DB::transaction(function () use ($user, $provider) {
            if ($user->save()) {

                /*
                 * Add the default site role to the new user
                 */
                $user->attachRole(2);

                /*
                 * Fetch the permissions of role attached to this user
                */
                $permissions = @$user->roles->first()->permissions->pluck('id');
                /*
                 * Assigned permissions to user
                */
                if ($permissions) $user->permissions()->sync($permissions);


                /*
                 * If users have to confirm their email and this is not a social account,
                 * send the confirmation email
                 *
                 * If this is a social account they are confirmed through the social provider by default
                 */
                if (config('access.users.confirm_email') && $provider === false) {
                    $user->notify(new UserNeedsConfirmation($user->confirmation_code));
                }
            }
            return true;
        });


        /*
         * Return the user object
         */
        return $user;
    }

    /**
     * @param $data
     * @param $provider
     *
     * @return UserRepository|bool
     * @throws GeneralException
     *
     */
    public function findOrCreateSocial($data, $provider)
    {
        // User email may not provided.
        $user_email = $data->email ?: "{$data->id}@{$provider}.com";

        // Check to see if there is a user with this email first.
        $user = $this->findByEmail($user_email);

        /*
         * If the user does not exist create them
         * The true flag indicate that it is a social account
         * Which triggers the script to use some default values in the create method
         */
        if (!$user) {
            // Registration is not enabled
            if (!config('access.users.registration')) {
                throw new GeneralException(trans('exceptions.frontend.auth.registration_disabled'));
            }

            $user = $this->create([
                'name' => $data->name,
                'email' => $user_email,
            ], true);
        }

        // See if the user has logged in with this social account before
        if (!$user->hasProvider($provider)) {
            // Gather the provider data for saving and associate it with the user
            $user->providers()->save(new SocialLogin([
                'provider' => $provider,
                'provider_id' => $data->id,
                'token' => $data->token,
                'avatar' => $data->avatar,
            ]));
        } else {
            // Update the users information, token and avatar can be updated.
            $user->providers()->update([
                'token' => $data->token,
                'avatar' => $data->avatar,
            ]);
        }

        // Return the user object
        return $user;
    }

    /**
     * @param $token
     *
     * @return bool
     * @throws GeneralException
     *
     */
    public function confirmAccount($token, $flag=true)
    {
        $user = $this->findByToken($token);

        if ($user->confirmed == 1 AND $flag) {
            throw new GeneralException(trans('exceptions.frontend.auth.confirmation.already_confirmed'));
        }

        if ($user->confirmation_code == $token) {
            $user->confirmed = 1;

            event(new UserConfirmed($user));

            $user->save();

            $profile = new UserProfile;
            $profile->user_id = $user->id;
            $profile->save();

            $profile_hrm = new HrmMeta;
            $profile_hrm->user_id = $user->id;
            $profile_hrm->save();
            $company = new Company();
            $company->cname = 'ABC Company';
            $company->address = '412 Example South Street';
            $company->city = 'Los Angeles';
            $company->region = 'FL';
            $company->country = 'USA';
            $company->postbox = '1D23A';
            $company->phone = '410-987-89-60';
            $company->email = 'abc@example.com';
            $company->taxid = 'TAX12345';
            $company->tax = '0';
            $company->currency = '1';
            $company->main_date_format = 'd-m-Y';
            $company->user_date_format = 'DD-MM-YYYY';
            $company->zone = 'UTC';
            $company->logo = null;
            $company->theme_logo =null;
            $company->lang = 'english';
            $company->valid = '1';
            $company->save();

            $warehouses = array('title' => 'Main Warehouse', 'extra' => 'Main Warehouse', 'ins' => $company->id);
            $warehouse = Warehouse::withoutGlobalScopes()->create($warehouses);

            $currency = array('code' => 'USD', 'symbol' => '$', 'rate' => 1, 'thousand_sep' => ',', 'decimal_sep' => '.', 'precision_point' => 2, 'symbol_position' => 1, 'ins' => $company->id);
            $currency_i = Currency::withoutGlobalScopes()->create($currency);



            $default_discount = array('name' => 'Discount % (after Tax) ', 'value' => 0, 'class' => 2, 'type1' => '%', 'type2' => 'exclusive', 'type3' => 'exclusive', 'default_a' => 1, 'ins' => $company->id);
            $default_discount_c = Additional::withoutGlobalScopes()->create($default_discount);

            $default_tax = array('name' => 'Tax Exclusive', 'value' => 0, 'class' => 1, 'type1' => '%', 'type2' => 'exclusive', 'type3' => 'exclusive', 'default_a' => 1, 'ins' => $company->id);
            $default_tax_c = Additional::withoutGlobalScopes()->create($default_tax);


            $account = array('number' => '1234567890', 'holder' => 'General Account', 'balance' => 0, 'code' => 'ABC123', 'account_type' => 'Basic', 'note' => 'Default Account', 'ins' => $company->id);

            $account_c = Account::withoutGlobalScopes()->create($account);

             $account = array('number' => '123456', 'holder' => 'Purchase Account', 'balance' => 0, 'code' => 'P123', 'account_type' => 'Basic', 'note' => 'Default Account', 'ins' => $company->id);

            $account_d = Account::withoutGlobalScopes()->create($account);

            $additionals = array();
            $additionals[] = array('name' => 'Tax Inclusive', 'value' => 0, 'class' => 1, 'type1' => '%', 'type2' => 'inclusive', 'type3' => 'inclusive', 'default_a' => 1, 'ins' => $company->id);
            $additionals[] = array('name' => 'Discount flat (after Tax) ', 'value' => 0, 'class' => 2, 'type1' => 'flat', 'type2' => 'exclusive', 'type3' => 'exclusive', 'default_a' => 1, 'ins' => $company->id);
            $additionals[] = array('name' => 'Ship Tax', 'value' => 0, 'class' => 3, 'type1' => '%', 'type2' => 'exclusive', 'type3' => 'exclusive', 'default_a' => 0, 'ins' => $company->id);
            $additionals[] = array('name' => 'Discount flat (before Tax) ', 'value' => 0, 'class' => 3, 'type1' => 'b_flat', 'type2' => 'exclusive', 'type3' => 'exclusive', 'default_a' => 0, 'ins' => $company->id);
            $additionals[] = array('name' => 'Discount % (before Tax) ', 'value' => 0, 'class' => 2, 'type1' => 'b_per', 'type2' => 'exclusive', 'type3' => 'exclusive', 'default_a' => 0, 'ins' => $company->id);
            Additional::withoutGlobalScopes()->insert($additionals);


            $transaction_category = array('name' => 'Default Sales and Income Category', 'note' => 'Default Sales and Income Category', 'sub_category' => 0, 'sub_category_id' => 0, 'ins' => $company->id);
            $transaction_category1 = array('name' => 'Default Purchase and Expenses Category', 'note' => 'Default Purchase and Expenses Category', 'sub_category' => 0, 'sub_category_id' => 0, 'ins' => $company->id);
            $trans_category = Transactioncategory::withoutGlobalScopes()->create($transaction_category);
            $trans_category1 = Transactioncategory::withoutGlobalScopes()->create($transaction_category1);



              $status_cancelled = array('ins' => $company->id,'name' => 'Cancelled', 'color' => '#FF3434', 'section' => 2);
              $status_done = array('ins' => $company->id,'name' => 'Done', 'color' => '#00FF1E', 'section' => 2);
           $status_cancelled_id = Misc::withoutGlobalScopes()->create($status_cancelled);
            $status_done_id = Misc::withoutGlobalScopes()->create($status_done);
            $rand=rand(10000,9999999);

            $features = array();
            $features[] = array('feature_id' => 1, 'feature_value' => $warehouse->id, 'value1' => 'default_warehouse', 'value2' => $company->email, 'ins' => $company->id);
            $features[] = array('feature_id' => 2, 'feature_value' => $currency_i->id, 'value1' => 'default_currency', 'value2' => '{"key":"api_key","base_currency":"USD","endpoint":"live",""enable":"0"}', 'ins' => $company->id);
            $features[] = array('feature_id' => 3, 'feature_value' => $default_discount_c->id, 'value1' => 'default_discount', 'value2' => null, 'ins' => $company->id);
            $features[] = array('feature_id' => 4, 'feature_value' => $default_tax_c->id, 'value1' => 'default_tax', 'value2' => null, 'ins' => $company->id);
            $features[] = array('feature_id' => 5, 'feature_value' => 0, 'value1' => 'online_payment', 'value2' => null, 'ins' => $company->id);
            $features[] = array('feature_id' => 6, 'feature_value' => $account_c->id, 'value1' => 'online_payment_account', 'value2' => $rand, 'ins' => $company->id);
            $features[] = array('feature_id' => 7, 'feature_value' => 0, 'value1' => 'url_shorten_service', 'value2' => null, 'ins' => $company->id);
            $features[] = array('feature_id' => 8, 'feature_value' => $trans_category->id, 'value1' => 'default_sales_transaction_category', 'value2' => null, 'ins' => $company->id);
            $features[] = array('feature_id' => 9, 'feature_value' => 1, 'value1' => 'jpeg,gif,png,pdf,xls', 'value2' => 'file_format', 'ins' => $company->id);
            $features[] = array('feature_id' => 10, 'feature_value' => $trans_category1->id, 'value1' => 'default_purchase_transaction_category', 'value2' => null, 'ins' => $company->id);
            $features[] = array('feature_id' => 11, 'feature_value' => 0, 'value1' => $company->email, 'value2' => '{"new_invoice":"0","new_trans":"0","cust_new_invoice":"0","del_invoice":"0","del_trans":"0","sms_new_invoice":"0"}', 'ins' => $company->id);
           // $features[] = array('feature_id' => 12, 'feature_value' => 0, 'value1' => 'sample@email.com', 'value2' => 'Invoice_delete_and_email', 'ins' => $company->id);
            $features[] = array('feature_id' => 13, 'feature_value' => 0, 'value1' => 0, 'value2' => 0, 'ins' => $company->id);
           // $features[] = array('feature_id' => 14, 'feature_value' => 0, 'value1' => 0, 'value2' => 'auto_sms_email', 'ins' => $company->id);
            $features[] = array('feature_id' => 15, 'feature_value' => 0, 'value1' => 'ltr', 'value2' => 'ltr_rtl', 'ins' => $company->id);
              $features[] = array('feature_id' => 16, 'feature_value' => $status_done_id->id, 'value1' =>$status_cancelled_id->id, 'value2' => 'default_task_status', 'ins' => $company->id);
                $features[] = array('feature_id' => 17, 'feature_value' => 0, 'value1' =>'["Assets","Basic","Equity","Expenses","Income","Liabilities"]', 'value2' => '["Cash","Bank Transfer","Cheque","Prepaid Card","Other"]', 'ins' => $company->id);
                $features[] = array('feature_id' => 18, 'feature_value' => 1, 'value1' =>'crm_hrm', 'value2' => '1', 'ins' => $company->id);
                   $features[] = array('feature_id' => 19, 'feature_value' => 0, 'value1' =>'{"address":"10.10.10.11","port":"9100","mode":"0"}', 'value2' => '9100', 'ins' => $company->id);

            ConfigMeta::withoutGlobalScopes()->insert($features);


            $group = array('title' => 'Default Group', 'summary' => 'Default Group', 'disc_rate' => 0, 'ins' => $company->id);
            $group_c = Customergroup::withoutGlobalScopes()->create($group);
            $customer = array('name' => 'Walk In Customer', 'phone' => 0, 'email' => 'customer@example.com', 'picture' => 'example.png', 'ins' => $company->id, 'role_id' => 0);
            Customer::withoutGlobalScopes()->create($customer);

            $template = array();
            $template[] = array('ins' => $company->id, 'title' => '[{Company}] Invoice #{BillNumber} Generated', 'body' => '
Dear {Name},
We are contacting you in regard to an invoice # {BillNumber} that has been created on your account. You may find the invoice with below link.
View Invoice
{URL}

We look forward to conducting future business with you.
Kind Regards,
Team
{CompanyDetails}', 'category' => 1, 'other' => 1, 'info' => 'invoice_generated');

            $template[] = array('ins' => $company->id, 'title' => '[{Company}] Invoice #{BillNumber} Payment Reminder', 'body' => '
Dear {Name},
We are contacting you in regard to a payment reminder of invoice # {BillNumber} that has been created on your account. You may find the invoice with below link. Please pay the balance of {Amount} due by {DueDate}.

View Invoice
{URL}

We look forward to conducting future business with you.

Kind Regards,
Team
{CompanyDetails}', 'category' => 1, 'other' => 2, 'info' => 'invoice_payment_reminder');

            $template[] = array('ins' => $company->id, 'title' => '[{Company}] Invoice #{BillNumber} Payment Received', 'body' => '
Dear {Name},
We are contacting you in regard to a payment received for invoice  # {BillNumber} that has been created on your account. You can find the invoice with below link.

View Invoice
{URL}

We look forward to conducting future business with you.
Kind Regards,

Team
{CompanyDetails}', 'category' => 1, 'other' => 3, 'info' => 'invoice_payment_received');

            $template[] = array('ins' => $company->id, 'title' => '{Company} Invoice #{BillNumber} OverDue', 'body' => '

Dear {Name},
We are contacting you in regard to an Overdue Notice for invoice # {BillNumber} that has been created on your account. You may find the invoice with below link.
Please pay the balance of {Amount} due by {DueDate}.

View Invoice
{URL}

We look forward to conducting future business with you.
Kind Regards,
Team

{CompanyDetails}', 'category' => 1, 'other' => 4, 'info' => 'invoice_payment_overdue');

            $template[] = array('ins' => $company->id, 'title' => '{Company} Invoice #{BillNumber} Refund Proceeded', 'body' => '
Dear {Name},
We are contacting you in regard to a refund request processed for invoice # {BillNumber} that has been created on your account. You may find the invoice with below link. Please pay the balance of {Amount}  by {DueDate}.

View Invoice
{URL}


We look forward to conducting future business with you.
Kind Regards,
Team
{CompanyDetails}', 'category' => 1, 'other' => 5, 'info' => 'invoice_payment_refund');

            $template[] = array('ins' => $company->id, 'title' => '[{Company}] Quote #{BillNumber} Generated', 'body' => '
Dear {Name},
We are contacting you in regard to a Quote # {BillNumber} that has been created on your account. You may find the Quote with below link.
View Quote
{URL}

We look forward to conducting future business with you.
Kind Regards,
Team
{CompanyDetails}', 'category' => 4, 'other' => 6, 'info' => 'quote_proposal');


            $template[] = array('ins' => $company->id, 'title' => '[{Company}] {BillType} #{BillNumber} Generated', 'body' => '
Dear {Name},
We are contacting you in regard to a {BillType} # {BillNumber} that has been created on your account. You may find the {BillType} with below link.
View {BillType}
{URL}

We look forward to conducting future business with you.
Kind Regards,
Team
{CompanyDetails}', 'category' => 5, 'other' => 7, 'info' => 'BillType_notification');

            $template[] = array('ins' => $company->id, 'title' => '[{Company}] {BillType} #{BillNumber} Generated', 'body' => '
Dear {Name},
We are contacting you in regard to a {BillType} # {BillNumber} that has been created on your account. You may find the {BillType} with below link.
View {BillType}
{URL}

We look forward to conducting future business with you.
Kind Regards,
Team
{CompanyDetails}', 'category' => 9, 'other' => 8, 'info' => 'purchase_orders');


            $template[] = array('ins' => $company->id, 'title' => 'SMS - New Invoice Notification', 'body' => 'Dear Customer, new invoice  # {BillNumber} generated. {URL} Regards', 'category' => 2, 'other' => 11, 'info' => 's_invoice_generated');
            $template[] = array('ins' => $company->id, 'title' => 'SMS - Invoice Payment Reminder', 'body' => 'Dear Customer, Please make payment of invoice  # {BillNumber}. {URL} Regards', 'category' => 2, 'other' => 12, 'info' => 's_invoice_payment_reminder');
            $template[] = array('ins' => $company->id, 'title' => 'SMS - Invoice payment Received', 'body' => 'Dear Customer, Payment received of invoice # {BillNumber}. {URL} Regards', 'category' => 2, 'other' => 13, 'info' => 's_invoice_payment_received');
            $template[] = array('ins' => $company->id, 'title' => 'SMS-Invoice Overdue Notice', 'body' => 'Dear Customer, Dear Customer,Payment is overdue of invoice # {BillNumber}. {URL} Regards', 'category' => 1, 'other' => 14, 'info' => 's_invoice_payment_overdue');
            $template[] = array('ins' => $company->id, 'title' => 'SMS - Invoice Refund Proceeded', 'body' => 'Dear Customer, Refund generated of invoice # {BillNumber}. {URL} Regards', 'category' => 2, 'other' => 15, 'info' => 's_invoice_payment_refund');

            $template[] = array('ins' => $company->id, 'title' => 'SMS - New Quote Notification', 'body' => 'Dear Customer, new Quote  # {BillNumber} generated. {URL} Regards', 'category' => 4, 'other' => 16, 'info' => 's_quote_proposal');
            $template[] = array('ins' => $company->id, 'title' => 'SMS - New {BillType} Notification', 'body' => 'Dear Customer, new {BillType} # {BillNumber} generated. {URL} Regards', 'category' => 5, 'other' => 17, 'info' => 's_BillType_notification');
            $template[] = array('ins' => $company->id, 'title' => 'SMS - New {BillType} Notification', 'body' => 'Dear Customer, new {BillType} # {BillNumber} generated. {URL} Regards', 'category' => 9, 'other' => 18, 'info' => 's_BillType_notification');

            Template::withoutGlobalScopes()->insert($template);


            $term = array('title' => 'Sample Term', 'type' => 1, 'terms' => 'Sample Text', 'ins' => $company->id);
            Term::withoutGlobalScopes()->create($term);

            $prefix = array();
            $prefix[] = array('ins' => $company->id, 'class' => 1, 'value' => 'INV', 'note' => 'invoice');
            $prefix[] = array('ins' => $company->id, 'class' => 2, 'value' => 'DO', 'note' => 'delivery_note');
            $prefix[] = array('ins' => $company->id, 'class' => 3, 'value' => 'PRO', 'note' => 'proforma_ invoice');
            $prefix[] = array('ins' => $company->id, 'class' => 4, 'value' => 'REC', 'note' => 'payment_receipt');
            $prefix[] = array('ins' => $company->id, 'class' => 5, 'value' => 'QT', 'note' => 'quote');
            $prefix[] = array('ins' => $company->id, 'class' => 6, 'value' => 'SUB', 'note' => 'subscriptions');
            $prefix[] = array('ins' => $company->id, 'class' => 7, 'value' => 'SUB', 'note' => 'credit_note');
            $prefix[] = array('ins' => $company->id, 'class' => 8, 'value' => 'SR', 'note' => 'stock_return');
            $prefix[] = array('ins' => $company->id, 'class' => 9, 'value' => 'PO', 'note' => 'purchase_order');
                $prefix[] = array('ins' => $company->id, 'class' =>10, 'value' => 'POS', 'note' => 'POS');
            Prefix::withoutGlobalScopes()->insert($prefix);

            $product_category = array('title' => 'General', 'extra' => 'General Products', 'c_type' => 0, 'rel_id' => 0, 'ins' => $company->id);
            Productcategory::withoutGlobalScopes()->create($product_category);
            $email_default = array('active' => 0, 'driver' => 'smtp', 'host' => 'smtp.example.com', 'port' => 587,'auth' => true,'auth_type' => 'tls','username' => 'user@example.com','password' => 123456,'sender' => 'sender@example.com', 'ins' => $company->id);
            EmailSetting::withoutGlobalScopes()->create($email_default);


            $user->ins = $company->id;

            $user->save();

            return $user;


        }

        throw new GeneralException(trans('exceptions.frontend.auth.confirmation.mismatch'));
    }

    /**
     * @param $id
     * @param $input
     *
     * @return mixed
     * @throws GeneralException
     *
     */
    public function updateProfile($id, $input)
    {
        $user = $this->find($id);
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->updated_by = access()->user()->id;

        if (!empty($input['picture'])) {

            $user->picture = $this->uploadPicture($input['picture']);
        }
        if (!empty($input['signature'])) {

            $user->signature = $this->uploadPicture($input['signature'], true);
        }
        if ($user->canChangeEmail()) {
            //Address is not current address
            if ($user->email != $input['email']) {
                //Emails have to be unique
                if ($this->findByEmail($input['email'])) {
                    throw new GeneralException(trans('exceptions.frontend.auth.email_taken'));
                }

                // Force the user to re-verify his email address
                $user->confirmation_code = md5(uniqid(mt_rand(), true));
                $user->confirmed = 0;
                $user->email = $input['email'];
                $updated = $user->save();

                // Send the new confirmation e-mail
                $user->notify(new UserNeedsConfirmation($user->confirmation_code));

                return [
                    'success' => $updated,
                    'email_changed' => true,
                ];
            }
        }

        return $user->save();
    }

    /**
     * @param $input
     *
     * @return mixed
     * @throws GeneralException
     *
     */
    public function changePassword($input)
    {
        $user = $this->find(access()->id());

        if (Hash::check($input['old_password'], $user->password)) {
            $user->password = bcrypt($input['password']);

            if ($user->save()) {
                $user->notify(new UserChangedPassword($input['password']));

                return true;
            }
        }

        throw new GeneralException(trans('exceptions.frontend.auth.password.change_mismatch'));
    }

    /**
     * Create a new token for the user.
     *
     * @return string
     */
    public function saveToken()
    {
        $token = hash_hmac('sha256', Str::random(40), 'hashKey');

        \DB::table('password_resets')->insert([
            'email' => request('email'),
            'token' => $token,
        ]);

        return $token;
    }

    /**
     * @param $token
     *
     * @return mixed
     */
    public function findByPasswordResetToken($token)
    {
        foreach (DB::table(config('auth.passwords.users.table'))->get() as $row) {
            if (password_verify($token, $row->token)) {
                return $this->findByEmail($row->email);
            }
        }

        return false;
    }

    /*
  * Upload logo image
  */
    public function uploadPicture($logo, $sign = false)
    {
        $path = $this->user_picture_path;
        if ($sign) $path = $this->user_sign_path;

        $image_name = time() . $logo->getClientOriginalName();

        $this->storage->put($path . $image_name, file_get_contents($logo->getRealPath()));

        return $image_name;
    }

    /*
    * remove logo or favicon icon
    */
    public function removePicture(User $customer, $type)
    {
        $path = $this->user_picture_path;

        if ($customer->$type && $this->storage->exists($path . $customer->$type)) {
            $this->storage->delete($path . $customer->$type);
        }

        $result = $customer->update([$type => null]);

        if ($result) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.settings.update_error'));
    }
}
