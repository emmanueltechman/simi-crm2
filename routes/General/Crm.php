<?php


Route::group(['namespace' => '\App\Http\Controllers\Crm', 'prefix' => 'crm', 'as' => 'crm.'], function () {
    Route::get('', 'CustomerLogin@showLoginForm')->name('login');
    Route::post('login', 'CustomerLogin@login')->name('login.post');
    Route::get('logout', 'CustomerLogin@logout')->name('logout');
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.enter_email');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.form');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.reset');
    /*
     _  crm profile routes
     */
    Route::group(['middleware' => 'crm'], function () {
        Route::post('invoices/get', 'InvoicesTableController')->name('invoices.get');
        Route::resource('invoices', 'InvoicesController');
        Route::post('quotes/get', 'QuotesTableController')->name('quotes.get');
        Route::get('quotes/approve/{id?}', 'QuotesController@approve')->name('quotes.approve');
        Route::resource('quotes', 'QuotesController');
         Route::get('projects/explore/{id}', 'ProjectsController@show')->name('projects.show');
         Route::post('tasks', 'ProjectsController@tasks')->name('projects.tasks');
        Route::get('projects', 'ProjectsController@index')->name('projects.index');

         Route::post('projects/get', 'ProjectsTableController')->name('projects.get');
        Route::get('user/profile', 'CustomerHome@profile')->name('user.update');
        Route::post('user/profile', 'CustomerHome@update_profile')->name('user.update+post');
        Route::get('user/wallet', 'CustomerHome@wallet')->name('user.wallet');
    });


});
