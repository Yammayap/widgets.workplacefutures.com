<?php

use App\Http\Controllers\Web;
use Illuminate\Support\Facades\Route;

/*---------------------------------------------------------------------*
 *------------------- GUEST & AUTHENTICATED ROUTES --------------------*
 *---------------------------------------------------------------------*/

Route::group([
    'middleware'    => [
        'web'
    ]
], function (): void {

    Route::group(['prefix' => 'space-calculator'], function (): void {
        Route::get('/', [Web\SpaceCalculator\LandingController::class, 'getLanding'])
            ->name('space_calculator.landing');
    });
});

/*---------------------------------------------------------------------*
 *--------------------------- GUEST ROUTES ----------------------------*
 *---------------------------------------------------------------------*/
Route::group([
    'middleware'    => [
        'guest:web'
    ]
], function (): void {

    // Routes....
});

/*---------------------------------------------------------------------*
 *----------------------- AUTHENTICATED ROUTES ------------------------*
 *---------------------------------------------------------------------*/
Route::group([
    'middleware'    => [
        'auth:web'
    ]
], function (): void {

    // Routes....
});
