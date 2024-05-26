<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ADMIN Routes
|--------------------------------------------------------------------------
*/

//    Auth Routes
Route::namespace('Auth')->prefix('auth')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::post('logout', 'AuthController@logout');
    });
});

//  With Auth
Route::group([
    'middleware' => [
        'auth:api',
        'admin'
    ]
], function () {
//        Profile Routes
    Route::namespace('Profile')->prefix('profile')->group(function () {
        Route::get('/', 'AdminProfileController@profile');
        Route::patch('/', 'AdminProfileController@updateProfile');
        Route::patch('change-password', 'AdminProfileController@updateProfilePassword');
    });
//    Business Routes
    Route::namespace('Business')->group(function () {
        /**
         *Check the RouteServiceProvider for the apiWithSoftDelete methods and routes
         */
        Route::apiWithSoftDelete('business', 'BusinessController');
    });
});
