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
                new Config(), // vars to be passed into config here
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
