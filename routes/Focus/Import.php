<?php
/**
 * event
 *
 */
    Route::group( ['namespace' => 'import'], function () {
          Route::get('import/{type?}', 'ImportController@index')->name('import.general');
          Route::post('import/{type?}', 'ImportController@index')->name('import.general_post');
          Route::post('import_process/{type?}', 'ImportController@import_process')->name('import.import_process');
          Route::get('sample/{name}', 'ImportController@samples')->name('import.sample');

    });
