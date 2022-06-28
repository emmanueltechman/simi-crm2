<?php

/**
 * customers
 *
 */

    Route::group(['namespace' => 'customer'], function () {
        Route::post('customer_send_email', 'CustomersController@send_bill')->name('customer_send_email');
        Route::post('customers/selected', 'CustomersController@selected_action')->name('customers.selected_action');
        Route::get('customers/wallet', 'CustomersController@wallet')->name('customers.wallet');
        Route::post('customers/wallet', 'CustomersController@wallet')->name('customers.wallet_post');
        Route::post('customers/wallet_load', 'CustomersController@wallet_transactions')->name('customers.wallet_load');
        Route::post('customers/search', 'CustomersController@search')->name('customers.search');
        Route::post('customers/select', 'CustomersController@select')->name('customers.select');
        Route::post('customers/active', 'CustomersController@select')->name('customers.active');
        Route::resource('customers', 'CustomersController');
        //For Datatable
        Route::post('customers/get', 'CustomersTableController')->name('customers.get');
    });
