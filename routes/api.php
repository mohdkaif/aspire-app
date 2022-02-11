<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['prefix' => '', 'namespace' => 'App\Http\Controllers\API'], function () {
    Route::group(['prefix' => 'user/auth', 'namespace' => 'Auth'], function () {
        Route::post('/register', 'AuthController@register');
        Route::post('/login', 'AuthController@login');
    });

    Route::group(['prefix' => 'admin/auth', 'namespace' => 'Auth'], function () {
        Route::post('/register', 'AuthController@register');
        Route::post('/login', 'AuthController@login');
    });

    ///After Auth URL
    Route::group(['prefix' => 'user', 'middleware' => ['auth:api']], function () {
        Route::post('/loan_rerquest', 'LoanController@loan_request');
        Route::get('/loan_list', 'LoanController@loan_list');
        Route::get('/loan_details/{loan_id}', 'LoanController@loan_details');
        Route::put('/make_payment/{loan_id}', 'LoanController@make_payment');
    });

    Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth:api']], function () {
        Route::post('change_loan_request_status/{loan_id}', 'LoanController@change_loan_request_status');
        Route::get('loan_list', 'LoanController@loan_list');
        Route::get('/loan_details/{loan_id}', 'LoanController@loan_details');
    });
});
