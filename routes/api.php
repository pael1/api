<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Authcontroller;
use App\Http\Controllers\Api\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [Authcontroller::class, 'register']);

// Route::post('login', 'API\UserController@login');
// Route::post('register', 'API\UserController@register');

Route::group(['namespace' => 'Api'], function() {
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);

    Route::group(['middleware' => 'auth:api'], function()
    {
        Route::post('order', [UserController::class, 'placeOrder']);
    });


    // Route::group(['middleware' => 'auth:api'], function(){
    //     Route::post('details', [UserController::class, 'details']);
    // });

});


