<?php

namespace App\Services\SpaceCalculator;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->scoped(Calculator::class, function (Application $app) {
            return new Calculator(
                new Config(
                    config('widgets.space-calculator.raw-space-standards'),
                    config('widgets.space-calculator.workstyle-parameters'),
                    config('widgets.space-calculator.circulation_allowances'),
                    config('widgets.space-calculator.asset-parameters'),
                    config('widgets.space-calculator.mobility-adjusters'),
                    config('widgets.space-calculator.collaboration-adjusters'),
                ),
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
