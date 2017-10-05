<?php

namespace Myerscode\Laravel\SubRequest;

use Illuminate\Support\ServiceProvider;

class SubRequestProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Dispatcher::class, function ($app) {
            return new Dispatcher($app->make('Illuminate\Routing\Router'), $app->make('Illuminate\Http\Request'));
        });

        $this->app->alias(Dispatcher::class, 'SubRequest');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Dispatcher::class,
            'SubRequest'
        ];
    }
}
