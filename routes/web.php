<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('lang/{lang}', [\App\Http\Controllers\LanguageController::class,'swap'])->name('lang');
Route::get('dir/{lang}', [\App\Http\Controllers\LanguageController::class,'direction'])->name('direction');

Route::group(['namespace' => '\App\Http\Controllers\Focus', 'as' => 'biller.', 'middleware' => 'biller'], function () {
includeRouteFiles(__DIR__.'/Focus/');
});
includeRouteFiles(__DIR__.'/General/');




