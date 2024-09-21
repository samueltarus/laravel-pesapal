<?php

namespace samueltarus\LaravelPesaPal;

use Illuminate\Support\ServiceProvider;
use samueltarus\LaravelPesaPal\Services\PesaPalService;

class PesaPalServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/pesapal.php', 'pesapal');

        $this->app->singleton('pesapal', function ($app) {
            return new PesaPalService();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/pesapal.php' => config_path('pesapal.php'),
        ], 'config');

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
    }
}