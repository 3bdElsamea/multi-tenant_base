<?php
// Super Admin Routes

use Illuminate\Support\Facades\Route;

//    Auth Routes
Route::namespace('Auth')->prefix('auth')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::middleware(['auth:api', 'superAdmin'])->group(function () {
        Route::post('logout', 'AuthController@logout');
    });
});
//  With Auth
Route::group([
    'middleware' => [
        'auth:api',
        'superAdmin'
    ]
], function () {
//        Admins Routes
    Route::namespace('Admin')->group(function () {
        /**
         *Check the RouteServiceProvider for the apiWithSoftDelete methods and routes
         */
        Route::apiWithSoftDelete('admin', 'AdminController');
    });
});

