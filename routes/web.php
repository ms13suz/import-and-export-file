<?php

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

Auth::routes();


Route::group(['middleware' => ['auth']], function () {
    Route::get('home', 'HomeController@index')->name('home');
    Route::post('import', 'EmployeeController@import')->name('import');
    Route::get('list', 'EmployeeController@list')->name('list');
    Route::get('edit/{id}', 'EmployeeController@edit')->name('edit');
    Route::get('save', 'EmployeeController@save')->name('save');
    Route::post('store', 'EmployeeController@store')->name('store');
    Route::post('update', 'EmployeeController@update')->name('update');
    Route::get('employee', 'EmployeeController@index')->name('employee');
});