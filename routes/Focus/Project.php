<?php
/**
 * project
 *
 */

    Route::group(['namespace' => 'project', 'middleware' => 'project'], function () {
                Route::post('projects/load', 'ProjectsController@load')->name('projects.load');
        Route::post('projects/update_status', 'ProjectsController@update_status')->name('projects.update_status');
        Route::post('projects/store_meta', 'ProjectsController@store_meta')->name('projects.store_meta');
        Route::post('projects/delete_meta', 'ProjectsController@delete_meta')->name('projects.delete_meta');
        Route::post('projects/log_history', 'ProjectsController@log_history')->name('projects.log_history');
        Route::post('projects/notes', 'ProjectsController@notes')->name('projects.notes');
        Route::post('projects/invoices', 'ProjectsController@invoices')->name('projects.invoices');
    });

    Route::group(['namespace' => 'project'], function () {

        Route::resource('projects', 'ProjectsController');
        //For Datatable
        Route::post('projects/get', 'ProjectsTableController')->name('projects.get');
    });

