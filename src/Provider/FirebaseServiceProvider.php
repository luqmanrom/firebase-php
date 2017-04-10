<?php

namespace Geckob\Firebase\Provider;

use Illuminate\Support\ServiceProvider;


class FirebaseServiceProvider extends ServiceProvider
{

    public function boot() {

        $this->publishes([
            __DIR__.'/../config/laravel-firebase.php' => config_path('laravel-firebase.php'),
        ], 'config');

    }

    public function register() {

    }

}