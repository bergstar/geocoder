<?php

namespace Bergstar\Geocoder;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class GeocoderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/geocoder.php' => $this->config_path('geocoder.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/geocoder.php', 'geocoder');

        $this->app->bind('geocoder', function ($app) {
            return (new Geocoder(new Client))
                ->setApiKey(config('geocoder.key'))
                ->setLanguage(config('geocoder.language'))
                ->setRegion(config('geocoder.region'))
                ->setBounds(config('geocoder.bounds'));
        });
    }

    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}
