<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

//web service restaurant - hotel 

Route::group(['prefix' => 'hotel/restaurant',  'namespace' => 'Control'], function () {
    Route::get('huespedes', 'RestaurantController@index');
    Route::post('consumo/{id}', 'RestaurantController@store');
});

/* Route::apiResource('hotel/restaurant', 'Control\\RestaurantController'); */
