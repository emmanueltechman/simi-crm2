<?php

/**
 * products
 *
 */
    Route::group(['namespace' => 'product'], function () {
        Route::get('products/label', 'ProductsController@product_label')->name('products.product_label');
        Route::get('products/standard', 'ProductsController@standard')->name('products.standard');
        Route::post('products/standard', 'ProductsController@standard')->name('products.standard_post');
        Route::post('products/label', 'ProductsController@product_label')->name('products.product_label_post');
        Route::get('products/stock_transfer', 'ProductsController@stock_transfer')->name('products.stock_transfer');
        Route::post('products/stock_transfer', 'ProductsController@stock_transfer')->name('products.stock_transfer_post');
        //For Datatable
        Route::post('products/get', 'ProductsTableController')->name('products.get');
        Route::post('products/search/{bill_type}', 'ProductsController@product_search')->name('products.product_search_post');
        Route::post('products/product_sub_load', 'ProductsController@product_sub_load')->name('products.product_sub_load');
        Route::post('products/pos/{bill_type}', 'ProductsController@pos')->name('products.product_search_pos');
        Route::resource('products', 'ProductsController');


    });
