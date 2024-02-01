<?php

use App\Http\Controllers\Web;
use Illuminate\Support\Facades\Route;

/*---------------------------------------------------------------------*
 *------------------- GUEST & AUTHENTICATED ROUTES --------------------*
 *---------------------------------------------------------------------*/

Route::get('/', [Web\HomeController::class, 'getIndex'])
    ->name('home.index');

Route::group(['prefix' => 'space-calculator'], function (): void {
    Route::get('/', [Web\SpaceCalculator\LandingController::class, 'getIndex'])
        ->name('space-calculator.index');
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
