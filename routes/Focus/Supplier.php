<?php
/**
 * supplier
 *
 */
    Route::group(['namespace' => 'supplier'], function () {
        Route::post('suppliers/search', 'SuppliersController@search')->name('suppliers.search');
         Route::post('suppliers/select', 'SuppliersController@select')->name('suppliers.select');
           Route::post('suppliers/active', 'SuppliersController@active')->name('suppliers.active');
        Route::resource('suppliers', 'SuppliersController');
        //For Datatable
        Route::post('suppliers/get', 'SuppliersTableController')->name('suppliers.get');

    });
