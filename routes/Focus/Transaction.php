<?php
/**
 * transactions
 *
 */
    Route::group(['namespace' => 'transaction'], function () {
          Route::post('transactions/payer_search','TransactionsController@payer_search' )->name('transactions.payer_search');
        Route::resource('transactions', 'TransactionsController');
        //For Datatable
        Route::post('transactions/get', 'TransactionsTableController')->name('transactions.get');
    });


