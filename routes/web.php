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
            'middleware' => 'guard_space_calculator_summary_output'
        ], function (): void {

            Route::get('/', [Web\SpaceCalculator\OutputsController::class, 'getSummary'])
                ->name('space-calculator.outputs.summary');

            Route::post('/', [Web\SpaceCalculator\OutputsController::class, 'postSummary'])
                ->name('space-calculator.outputs.summary.post');

            Route::post('/profile', [Web\SpaceCalculator\OutputsController::class, 'postProfile'])
                ->name('space-calculator.outputs.profile.post');
        });

        Route::group([
            'prefix' => 'detailed',
            'middleware' => 'guard_space_calculator_detailed_output'
        ], function (): void {

            Route::get('/', [Web\SpaceCalculator\OutputsController::class, 'getDetailed'])
                ->name('space-calculator.outputs.detailed');

            Route::post('/', [Web\SpaceCalculator\OutputsController::class, 'postDetailed'])
                ->name('space-calculator.outputs.detailed.post');
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

        Route::get('/sign-in', [Web\AuthController::class, 'getSignIn'])
            ->name('auth.sign-in');

        Route::post('sign-in', [Web\AuthController::class, 'postSignIn'])
            ->name('auth.sign-in.post');

        Route::get('sent', [Web\AuthController::class, 'getSent'])
            ->name('auth.sent');
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

    Route::group(['prefix' => 'auth/sign-out'], function (): void {

        Route::get('/', [Web\AuthController::class, 'getSignOut'])
            ->name('auth.sign-out');

        Route::post('/', [Web\AuthController::class, 'postSignOut'])
            ->name('auth.sign-out.post');
    });

    Route::get('portal', [Web\PortalController::class, 'getIndex'])
        ->name('portal.index');

    Route::group(['prefix' => 'profile'], function (): void {

        Route::get('/', [Web\ProfileController::class, 'getIndex'])
            ->name('profile.index');

        Route::post('/', [Web\ProfileController::class, 'postIndex'])
            ->name('profile.index.post');
    });
});

// both guests and users - here to avoid clash with auth routes
Route::get('auth/{magicLink}', [Web\AuthController::class, 'getMagicLink'])
    ->middleware(['signed', 'verify_magic_link'])
    ->name('auth.magic-link');
