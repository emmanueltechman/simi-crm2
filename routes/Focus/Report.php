<?php

    Route::group(['namespace' => 'report'], function () {
        Route::get('reports/statement/{section}', 'StatementController@statement')->name('reports.statements');
        Route::post('reports/statement/generate/{section}', 'StatementController@generate_statement')->name('reports.generate_statement');
        Route::post('reports/statement/tax/{section}', 'StatementController@generate_tax_statement')->name('reports.generate_tax_statement');
        Route::post('reports/statement/stock/{section}', 'StatementController@generate_stock_statement')->name('reports.generate_stock_statement');
        Route::get('reports/chart/{section}', 'ChartController@chart')->name('reports.charts');
        Route::post('reports/chart/{section}', 'ChartController@chart')->name('reports.charts_post');
         Route::get('reports/summary/{section}', 'SummaryController@summary')->name('reports.summary');
        Route::post('reports/summary/{section}', 'SummaryController@summary')->name('reports.summary_post');
           Route::post('reports/pos/register', 'StatementController@pos_statement')->name('reports.pos');

                   Route::post('reports/statement/generate_market/{section}', 'StatementController@generate_market_statement')->name('reports.generate_market_statement');
    });
