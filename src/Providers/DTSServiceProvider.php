<?php

namespace TNM\DTS\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use TNM\DTS\Services\BundleSubscription\BundleSubscriptionService;
use TNM\DTS\Services\BundleSubscription\IBundleSubscriptionService;
use TNM\DTS\Services\QueryBundles\IQueryBundlesService;
use TNM\DTS\Services\QueryBundles\QueryBundleService;

class DTSServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config.php' => config_path('dts.php')], 'config');
        }

        Route::group([
            'prefix' => config('dts.callback.prefix'),
            'middleware' => config('dts.callback.middleware')
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });
    }

    public function register()
    {
        $this->app->bind(IQueryBundlesService::class, QueryBundleService::class);
        $this->app->bind(IBundleSubscriptionService::class, BundleSubscriptionService::class);

        $this->app->register(DTSEventServiceProvider::class);
    }
}
