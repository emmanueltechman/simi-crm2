<?php
/**
 * FocusRoutes
 *
 */

    Route::group(['namespace' => 'account'], function () {
        Route::get('accounts/balancesheet/{type}', 'AccountsController@balance_sheet')->name('accounts.balance_sheet');
        Route::resource('accounts', 'AccountsController');
        //For Datatable
        Route::post('accounts/get', 'AccountsTableController')->name('accounts.get');
    });

    Route::group(['namespace' => 'additional'], function () {
        Route::resource('additionals', 'AdditionalsController');
        //For Datatable
        Route::post('additionals/get', 'AdditionalsTableController')->name('additionals.get');
    });

       Route::group(['namespace' => 'market'], function () {
        Route::resource('markets', 'MarketController');

        //For Datatable
        Route::post('market/get', 'MarketTableController')->name('markets.get');
        Route::get('markets/{id}/edits', 'MarketController@edit2')->name('markets.edit2');
    });

    Route::group(['namespace' => 'bank'], function () {
        Route::resource('banks', 'BanksController');
        //For Datatable
        Route::post('banks/get', 'BanksTableController')->name('banks.get');
    });

    Route::group(['namespace' => 'currency'], function () {
        Route::resource('currencies', 'CurrenciesController');
        //For Datatable
        Route::post('currencies/get', 'CurrenciesTableController')->name('currencies.get');
    });
    Route::group(['namespace' => 'customergroup'], function () {
        Route::resource('customergroups', 'CustomergroupsController');
        //For Datatable
        Route::post('customergroups/get', 'CustomergroupsTableController')->name('customergroups.get');
    });

    Route::group(['namespace' => 'customfield'], function () {
        Route::resource('customfields', 'CustomfieldsController');
        //For Datatable
        Route::post('customfields/get', 'CustomfieldsTableController')->name('customfields.get');
    });
    Route::group(['namespace' => 'department'], function () {
        Route::resource('departments', 'DepartmentsController');
        //For Datatable
        Route::post('departments/get', 'DepartmentsTableController')->name('departments.get');
    });
    Route::group(['namespace' => 'event'], function () {
        Route::get('events/load_events', 'EventsController@load_events')->name('events.load_events');
        Route::post('events/update_event', 'EventsController@update_event')->name('events.update_event');
        Route::post('events/delete_event', 'EventsController@delete_event')->name('events.delete_event');

        //For Datatable
        Route::post('events/get', 'EventsTableController')->name('events.get');
        Route::resource('events', 'EventsController');
    });

    Route::group(['namespace' => 'misc'], function () {
        Route::resource('miscs', 'MiscsController');
        //For Datatable
        Route::post('miscs/get', 'MiscsTableController')->name('miscs.get');
    });
    Route::group(['namespace' => 'note'], function () {
        Route::resource('notes', 'NotesController');
        //For Datatable
        Route::post('notes/get', 'NotesTableController')->name('notes.get');
    });

    Route::group(['namespace' => 'order'], function () {
        Route::resource('orders', 'OrdersController');
        //For Datatable
        Route::post('orders/get', 'OrdersTableController')->name('orders.get');
    });
    Route::group(['namespace' => 'prefix'], function () {
        Route::resource('prefixes', 'PrefixesController');
        //For Datatable
        Route::post('prefixes/get', 'PrefixesTableController')->name('prefixes.get');
    });

    Route::group(['namespace' => 'productcategory'], function () {
        Route::resource('productcategories', 'ProductcategoriesController');
        //For Datatable
        Route::post('productcategories/get', 'ProductcategoriesTableController')->name('productcategories.get');
    });
    Route::group(['namespace' => 'productvariable'], function () {
        Route::resource('productvariables', 'ProductvariablesController');
        //For Datatable
        Route::post('productvariables/get', 'ProductvariablesTableController')->name('productvariables.get');
    });
    Route::group(['namespace' => 'purchaseorder'], function () {
        Route::resource('purchaseorders', 'PurchaseordersController');
        //For Datatable
        Route::post('purchaseorders/get', 'PurchaseordersTableController')->name('purchaseorders.get');
    });
    Route::group(['namespace' => 'quote'], function () {
        Route::post('quotes/convert', 'QuotesController@convert')->name('quotes.convert');
        Route::post('quotes/quotes_status', 'QuotesController@update_status')->name('quotes.bill_status');
        Route::resource('quotes', 'QuotesController');
        //For Datatable
        Route::post('quotes/get', 'QuotesTableController')->name('quotes.get');

    });
    Route::group(['namespace' => 'template'], function () {
        Route::resource('templates', 'TemplatesController');
        //For Datatable
        Route::post('templates/get', 'TemplatesTableController')->name('templates.get');
    });
    Route::group(['namespace' => 'term'], function () {
        Route::resource('terms', 'TermsController');
        //For Datatable
        Route::post('terms/get', 'TermsTableController')->name('terms.get');
    });

    Route::group(['namespace' => 'transactioncategory'], function () {
        Route::resource('transactioncategories', 'TransactioncategoriesController');
        //For Datatable
        Route::post('transactioncategories/get', 'TransactioncategoriesTableController')->name('transactioncategories.get');
    });

    Route::group(['namespace' => 'gateway'], function () {
        Route::resource('usergatewayentries', 'UsergatewayentriesController');
        //For Datatable
        Route::post('usergatewayentries/get', 'UsergatewayentriesTableController')->name('usergatewayentries.get');
    });
    Route::group(['namespace' => 'warehouse'], function () {
        Route::resource('warehouses', 'WarehousesController');
        //For Datatable
        Route::post('warehouses/get', 'WarehousesTableController')->name('warehouses.get');
    });
