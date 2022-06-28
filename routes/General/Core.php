<?php
/**
 * core
 *
 */

//General Application
Route::get('login', '\App\Http\Controllers\Focus\general\CoreController@showLoginForm')->middleware('install')->name('login');
Route::group(['namespace' => '\App\Http\Controllers\Focus', 'as' => 'biller.'], function () {
    //publicUserLoggedOut
    Route::get('', 'general\CoreController@showLoginForm')->name('index');
    Route::post('login', 'general\CoreController@login')->name('login');

    Route::get('logout', 'general\CoreController@logout')->name('logout');
    Route::get('stripe_token', 'communication\BillsController@stripe_api_request')->name('stripe_api_request');
    Route::get('cron/{method}', 'general\JobController@index')->name('cron.jobs');
    //paypal
  Route::group(['namespace' => 'communication'], function () {
      Route::get('paypal_process', 'BillsController@paypal_process');
      Route::post('paypal_process', 'BillsController@paypal_process')->name('paypal_process');
      Route::get('paypal_response', 'BillsController@paypal_response')->name('paypal_response');
      Route::get('paypal_error', 'BillsController@paypal_error')->name('paypal_error');
      Route::post('paypal_capture/{orderId?}/capture', 'BillsController@capturePaymentWithpaypal')->name('paypal_capture');
  });

    Route::group(['namespace' => 'communication', 'middleware' => 'valid_token'], function () {
        Route::get('view_bill/{id}/{type}/{token}/{pdf}', 'BillsController@index')->name('view_bill');
        Route::get('print_bill/{id}/{type}/{token}/{pdf}', 'BillsController@print_pdf')->name('print_bill');
        Route::get('print_compact/{id}/{type}/{token}/{pdf}', 'BillsController@print_compact')->name('print_compact');
        Route::get('view_bank/{id}/{type}/{token}', 'BillsController@view_bank')->name('view_bank');
        Route::get('pay_card/{id}/{type}/{token}', 'BillsController@pay_card')->name('pay_card');
        Route::post('process_card/{id}/{type}/{token}/{gateway}/{cid}', 'BillsController@process_payment')->name('process_card');
    });


    //private

    Route::group(['namespace' => 'communication', 'middleware' => 'biller'], function () {
        Route::post('load_template', 'CommunicationsController@load')->name('load_template');
        Route::post('send_bill', 'CommunicationsController@send_bill')->name('send_bill');
        Route::post('group_send_email', 'CommunicationsController@group_send_email')->name('group_send_email');
        Route::post('send_bill_sms', 'CommunicationsController@send_bill_sms')->name('send_bill_sms');
        Route::get('message', ['as' => 'messages', 'uses' => 'MessagesController@index']);
        Route::get('message/create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
        Route::post('message', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
        Route::get('message/{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
        Route::put('message/{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
        Route::post('message/destroy', ['as' => 'messages.destroy', 'uses' => 'MessagesController@destroy']);
    });
    Route::group(['namespace' => 'payment', 'middleware' => 'biller'], function () {
        Route::post('bill_payment', 'PaymentsController@payment')->name('bill_payment');
        Route::post('bulk_payment', 'PaymentsController@bill_bulk_payment')->name('bill_bulk_payment');
    });

    //public
    Route::group(['namespace' => 'general', 'middleware' => 'biller'], function () {
        Route::get('dashboard', 'CoreDashboard@index')->name('dashboard');
        Route::post('dashboard/load', 'CoreDashboard@mini_dash')->name('mini_dash');
        Route::post('bill_attachment', 'FileController@bill_attachment')->name('bill_attachment');
        Route::get('print_payslip/{id}/{type}/{pdf}', 'GeneralController@print_receipt')->name('print_payslip');
        Route::post('project_attachment', 'FileController@project_attachment')->name('project_attachment');
        Route::post('bill_cancel', 'GeneralController@bill_cancel')->name('bill_cancel');
        Route::get('business/settings', 'CompanyController@manage')->name('business.settings');
        Route::post('business/update_settings', 'CompanyController@update')->name('business.update_settings');
        Route::get('business/billing_settings', 'CompanyController@billing_settings')->name('business.billing_settings');
        Route::post('business/billing_settings_update', 'CompanyController@billing_settings_update')->name('business.billing_settings_update');
        Route::get('activate', 'CompanyController@activate')->name('activate');
        Route::post('activate', 'CompanyController@activate')->name('activate_post');
        Route::get('business/email_sms_settings', 'CompanyController@email_sms_settings')->name('business.email_sms_settings');
        Route::post('business/email_settings_update', 'CompanyController@email_settings_update')->name('business.email_settings_update');
        Route::get('cron', 'CronController@index')->name('cron');
        Route::post('cron', 'CronController@index')->name('cron_post');
        Route::get('business/settings/billing_preference', 'CompanyController@billing_preference')->name('settings.billing_preference');
        Route::post('business/settings/billing_preference', 'CompanyController@billing_preference')->name('settings.billing_preference_post');
        Route::get('business/settings/payment_preference', 'CompanyController@payment_preference')->name('settings.payment_preference');
        Route::post('business/settings/payment_preference', 'CompanyController@payment_preference')->name('settings.payment_preference_post');
        Route::get('business/settings/accounts', 'CompanyController@accounts')->name('settings.accounts');
        Route::post('business/settings/accounts', 'CompanyController@accounts')->name('settings.accounts_post');
        Route::get('business/settings/notification_email', 'CompanyController@notification_email')->name('settings.notification_email');
        Route::post('business/settings/notification_email', 'CompanyController@notification_email')->name('settings.notification_email_post');
        Route::get('business/settings/localization', 'CompanyController@localization')->name('settings.localization');
        Route::post('business/settings/localization', 'CompanyController@localization')->name('settings.localization_post');
        Route::get('business/settings/theme', 'CompanyController@theme')->name('settings.theme');
        Route::post('business/settings/theme', 'CompanyController@theme')->name('settings.theme_post');
        Route::get('business/settings/status', 'CompanyController@status')->name('settings.status');
        Route::post('business/settings/status', 'CompanyController@status')->name('settings.status_post');
        Route::get('business/settings/crm_hrm_section', 'CompanyController@crm_hrm_section')->name('settings.crm_hrm_section');
        Route::post('business/settings/crm_hrm_section', 'CompanyController@crm_hrm_section')->name('settings.crm_hrm_section_post');
        Route::get('business/settings/pos_preference', 'CompanyController@pos_preference')->name('settings.pos_preference');
        Route::post('business/settings/pos_preference', 'CompanyController@pos_preference')->name('settings.pos_preference_post');
        Route::get('business/settings/currency_exchange', 'CompanyController@currency_exchange')->name('settings.currency_exchange');
        Route::post('business/settings/currency_exchange', 'CompanyController@currency_exchange')->name('settings.currency_exchange_post');
        Route::get('u/todo', 'UserController@todo')->name('todo');
        Route::get('u/profile', 'UserController@profile')->name('profile');
        Route::get('u/edit_profile', 'UserController@edit_profile')->name('edit_profile');
        Route::post('u/edit_profile', 'UserController@edit_profile')->name('edit_profile_post');
        Route::get('u/change_profile_password', 'UserController@change_profile_password')->name('change_profile_password');
        Route::post('u/change_profile_password', 'UserController@change_profile_password')->name('change_profile_password_post');
        Route::get('u/attendance', 'UserController@attendance')->name('attendance');
        Route::get('clock', 'UserController@clock')->name('clock');
        Route::get('u/attendance', 'UserController@attendance')->name('attendance');
        Route::get('u/load_attendance', 'UserController@load_attendance')->name('load_attendance');
        Route::get('u/notification', 'UserController@notifications')->name('notification');
        Route::get('u/read_notification', 'UserController@read_notifications')->name('read_notification');
        Route::get('/clear-cache', 'CompanyController@clear_cache')->name('clear_cache');

         Route::get('business/dev', 'CompanyController@dev_manager')->name('business.dev_manager');
          Route::post('business/dev','CompanyController@dev_manager')->name('business.dev_manager_post');
    });
});

Route::group(['namespace' => '\App\Http\Controllers\Multi\Auth', 'as' => 'frontend.auth.', 'prefix' => 'app'], function () {
       Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.email');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email_post');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.form');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.reset');
});


