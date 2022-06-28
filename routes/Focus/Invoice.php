<?php
/**
 * invoices
 *
 */
    Route::group(['namespace' => 'invoice'], function () {
        Route::post('bill_status', 'InvoicesController@update_status')->name('bill_status');
        Route::get('pos', 'InvoicesController@pos')->name('invoices.pos');
        Route::post('pos_create', 'InvoicesController@pos_store')->name('invoices.pos_store');
        Route::post('draft_store', 'InvoicesController@draft_store')->name('invoices.draft_store');
        Route::post('drafts_load', 'InvoicesController@drafts_load')->name('invoices.drafts_load');
        Route::get('draft_view/{id}', 'InvoicesController@draft_view')->name('invoices.draft_view');
        Route::post('pos_update', 'InvoicesController@pos_update')->name('invoices.pos_update');
        Route::resource('invoices', 'InvoicesController');
        //For Datatable
        Route::post('invoices/get', 'InvoicesTableController')->name('invoices.get');
        Route::get('invoices/print_document/{id}/{type}', 'InvoicesController@print_document')->name('invoices.print_document');
    });

    Route::group(['namespace' => 'printer'], function () {
        Route::get('browser_print', 'PrinterController@browser_print')->name('pos.browser_print');
        Route::post('register/open', 'RegistersController@open')->name('register.open');
        Route::get('register/close', 'RegistersController@close')->name('register.close');
        Route::get('register/load', 'RegistersController@load')->name('register.load');
    });

