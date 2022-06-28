<?php
/**
 * update
 *
 */
Route::group(['namespace' => 'general'], function () {
    Route::get('update', 'UpdateController@index')->name('web_update_wizard');
    Route::get('about', 'UpdateController@about')->name('about');
    Route::post('download_update', 'UpdateController@download_update')->name('download_update');
    Route::post('install_update', 'UpdateController@install_update')->name('install_update');
    Route::post('update_db', 'UpdateController@update_db')->name('update_db');
    Route::get('server_info', 'UpdateController@server_info')->name('server_info');
     Route::post('optimize', 'UpdateController@optimize')->name('optimize');
});
