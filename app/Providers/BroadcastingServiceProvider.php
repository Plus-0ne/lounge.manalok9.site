<?php
namespace App\Providers;

use App\ExtendPusherSettings;

class BroadcastingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(BroadcastManager::class, function ($app) {
            return new ExtendPusherSettings($app);
        });
    }
}
