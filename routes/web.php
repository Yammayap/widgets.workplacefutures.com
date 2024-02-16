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

    Route::group(
        [
        'prefix' => 'results/{spaceCalculatorInput}/summary',
        'middleware' => 'guard_space_calculator_output'],
        function (): void {
            Route::get('/', [Web\SpaceCalculator\OutputsController::class, 'getIndex'])
                ->name('space-calculator.outputs.index');
            Route::post('/', [Web\SpaceCalculator\OutputsController::class, 'postIndex'])
                ->name('space-calculator.outputs.index.post');
        }
    );
});

/*---------------------------------------------------------------------*
 *--------------------------- GUEST ROUTES ----------------------------*
 *---------------------------------------------------------------------*/
Route::group([
    'middleware'    => [
        'guest:web'
    ]
], function (): void {

    Route::group(['prefix' => 'auth'], function (): void {
        Route::get('{magicLink}', [Web\AuthController::class, 'getMagicLink'])
            ->middleware('signed')
            ->name('auth.magic-link');
    });
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
