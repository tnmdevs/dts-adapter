<?php

namespace TNM\DTS\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DTSServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/config.php' => config_path('dts.php')], 'config');
        }

        Route::group([
            'prefix' => config('dts.route_prefix'),
            'middleware' => config('dts.middleware')
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        });
    }

    public function register()
    {

    }
}