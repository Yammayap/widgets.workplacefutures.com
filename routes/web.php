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

    Route::group(['prefix' => 'results/{spaceCalculatorInput}'], function (): void {

        Route::group([
            'prefix' => '/summary',
            'middleware' => 'guard_space_calculator_output'
        ], function (): void {

            Route::get('/', [Web\SpaceCalculator\OutputsController::class, 'getIndex'])
                ->name('space-calculator.outputs.index');

            Route::post('/', [Web\SpaceCalculator\OutputsController::class, 'postIndex'])
                ->name('space-calculator.outputs.index.post');
        });

        Route::group(['prefix' => 'detailed'], function (): void {

            Route::get('/', [Web\SpaceCalculator\OutputsController::class, 'getDetailed'])
                ->name('space-calculator.outputs.detailed');
        });
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

    Route::group(['prefix' => 'auth'], function (): void {

        Route::get('sent', [Web\AuthController::class, 'getSent'])
            ->name('auth.sent');
    });
});

// both guests and users - here to avoid clash with auth/sent
Route::get('auth/{magicLink}', [Web\AuthController::class, 'getMagicLink'])
    ->middleware(['signed', 'verify_magic_link'])
    ->name('auth.magic-link');

/*---------------------------------------------------------------------*
 *----------------------- AUTHENTICATED ROUTES ------------------------*
 *---------------------------------------------------------------------*/
Route::group([
    'middleware'    => [
        'auth:web'
    ]
], function (): void {

    Route::get('portal', [Web\PortalController::class, 'getIndex'])
        ->name('portal.index');
});
