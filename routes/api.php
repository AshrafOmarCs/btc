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
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', "AuthController@login");

    

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', "AuthController@userProfile");    
});
Route::group([
    'middleware' => 'api'
], function ($router) {
    Route::get('/testtest',"AuthController@testtest");
});
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
/*
Route::get('country', 'Country\CountryController@country');
Route::get('country/{id}', 'Country\CountryController@countryByID');
Route::POST('country', 'Country\CountryController@countrySave');
Route::PUT('country/{id}', 'Country\CountryController@countryUpdate');
//Route::PUT('country/{country}', 'Country\CountryController@countryUpdate');
Route::delete('country/{id}', 'Country\CountryController@countryDelete');
*/
//Route::apiResource('country', 'Country\Country');

