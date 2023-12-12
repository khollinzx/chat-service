<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


/**
 * The Version 1 route declarations
 */
Route::group([ 'prefix' => 'v1'], function () {

    Route::group(['middleware' => ['set-header']], function () {

        /**
         * Onboard section
         */
        Route::group(['prefix' => 'onboard'], function () {
            Route::get('welcome', [AuthController::class, 'welcome']);

            Route::post('signin', [AuthController::class,  'login']);

        });
        /**
         * Authenticated section
         */
        Route::group(['middleware' => ['access.control']], function () {

            Route::group(['middleware' => ['auth:api']], function () {

                /**
                 * Auth User Sections
                 */
                require __DIR__ .'/protected/user-auth-route.php';

            });
        });

    });

    /**
     * External section
     */
    Route::group(['prefix' => 'external'], function () {
        Route::post('payment/webhook', [WebhookController::class, 'resolvePaymentWebhookEvents']);

    });

});
