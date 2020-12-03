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

use Illuminate\Support\Facades\Route;


Route::get('/', 'InicioController@index');


Route::group(['prefix' => 'admin', 'namespace'], function () {
    Route::get('grupomenu', 'Admin\GrupoMenuController@index')->name('grupomenu');
    Route::get('grupomenu/create', 'Admin\GrupoMenuController@create')->name('create_grupomenu');
    Route::get('grupomenu', 'Admin\GrupoMenuController@index')->name('grupomenu');
    Route::get('grupomenu/{id}', 'Admin\GrupoMenuController@show')->name('show_grupomenu');
    Route::post('grupomenu', 'Admin\GrupoMenuController@store')->name('store_grupomenu');
    Route::get('grupomenu/{id}/edit', 'Admin\GrupoMenuController@edit')->name('edit_grupomenu');
    Route::put('grupomenu/{id}', 'Admin\GrupoMenuController@update')->name('update_grupomenu');
    Route::delete('grupomenu/{id}/destroy', 'Admin\GrupoMenuController@destroy')->name('destroy_grupomenu');
});
