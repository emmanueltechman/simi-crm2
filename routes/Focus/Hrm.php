<?php
/**
 * hrm
 *
 */


    Route::group( ['namespace' => 'hrm'], function () {
        Route::post('hrms/set_permission', 'HrmsController@set_permission')->name('hrms.set_permission');
        Route::get('hrms/payroll', 'HrmsController@payroll')->name('hrms.payroll');
        Route::get('hrms/attendance_new', 'HrmsController@attendance')->name('hrms.attendance');
        Route::get('hrms/attendance_destroy', 'HrmsController@attendance_destroy')->name('hrms.attendance_destroy');
        Route::post('hrms/attendance_destroy', 'HrmsController@attendance_destroy')->name('hrms.attendance_destroy_post');
        Route::post('hrms/attendance_load', 'HrmsController@attendance_load')->name('hrms.attendance_load');
        Route::get('hrms/attendance', 'HrmsController@attendance_list')->name('hrms.attendance_list');
        Route::post('hrms/attendance', 'HrmsController@attendance_store')->name('hrms.attendance_store');
        Route::get('hrms/payroll', 'HrmsController@payroll')->name('hrms.payroll');

        Route::post('hrms/related_permission', 'HrmsController@related_permission')->name('hrms.related_permission');
         Route::post('hrms/role_permission', 'HrmsController@role_permission')->name('hrms.role_permission');
          Route::post('hrms/active', 'HrmsController@active')->name('hrms.active');
             Route::post('hrms/admin_permissions', 'HrmsController@admin_permissions')->name('hrms.admin_role_permission');


        Route::resource('hrms', 'HrmsController');
        //For Datatable
        Route::post('hrms/get', 'HrmsTableController')->name('hrms.get');
    });


        Route::group(['namespace' => 'role'], function () {
            Route::resource('role', 'RoleController', ['except' => ['show']]);

            //For DataTables
            Route::post('role/get', 'RoleTableController')->name('role.get');
        });







