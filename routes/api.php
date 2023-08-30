<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */
    // if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    //     header('Access-Control-Allow-Origin: *');
    //     header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    //     header('Access-Control-Allow-Headers: token, Content-Type');
    //     header('Access-Control-Max-Age: 1728000');
    //     header('Content-Length: 0');
    //     header('Content-Type: text/plain');
    //     die();
    // }

    // header('Access-Control-Allow-Origin: *');
    // header('Content-Type: application/json');

    // $ret = [
    //     'result' => 'OK',
    // ]; 
    
 Route::group(['prefix' => 'App/Version/0.1/'], function() {
     
      Route::post('Webhook-reciver','webhookController@webhookHandler');
     Route::post('Login','ApiController@login');
     Route::get('getRejectedAccessories/{checkup_id}','ApiController@getRejectedAccessory');
     Route::get('getRejectedImages/{checkup_id}','ApiController@getRejectedImages');
     Route::post('update-DA','ApiController@update_DA');
     Route::post('UpdateRejectedAccessories','ApiController@UpdateRejectedAccessories');
     Route::post('new-delegation-request','ApiController@delegation_request');
     Route::get('driver-vehicles/{driver_id}','ApiController@getDriverVehicles');
     Route::post('re-upload/checkUp-images','ApiController@reuploadCheckUpImages'); 
 });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/*
Route::get('country', 'Country\CountryController@country');
Route::get('country/{id}', 'Country\CountryController@countryByID');
Route::POST('country', 'Country\CountryController@countrySave');
Route::PUT('country/{id}', 'Country\CountryController@countryUpdate');
//Route::PUT('country/{country}', 'Country\CountryController@countryUpdate');
Route::delete('country/{id}', 'Country\CountryController@countryDelete');
*/
//Route::apiResource('country', 'Country\Country');

