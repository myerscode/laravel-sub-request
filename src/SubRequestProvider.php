<?php

namespace Myerscode\Laravel\SubRequest;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Override;

class SubRequestProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register the application services.
     */
    #[Override]
    public function register(): void
    {
        $this->app->bind(Dispatcher::class, fn($app) => new Dispatcher($app->make(Router::class), $app->make(Request::class)));

        $this->app->alias(Dispatcher::class, 'SubRequest');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    #[Override]
    public function provides()
    {
        return [
            Dispatcher::class,
        ];
    }
}
