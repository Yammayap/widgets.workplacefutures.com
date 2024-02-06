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

    Route::group(['prefix' => 'inputs'], function (): void {
        Route::get('/', [Web\SpaceCalculator\InputsController::class, 'getIndex'])
            ->name('space-calculator.inputs.index');
        Route::post('/', [Web\SpaceCalculator\InputsController::class, 'postIndex'])
            ->name('space-calculator.inputs.post');
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
