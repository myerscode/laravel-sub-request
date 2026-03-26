<?php

declare(strict_types=1);

namespace Myerscode\Laravel\SubRequest;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Override;

class SubRequestProvider extends ServiceProvider
{
    /**
     * @return array<int, string>
     */
    #[Override]
    public function provides(): array
    {
        return [
            Dispatcher::class,
        ];
    }

    #[Override]
    public function register(): void
    {
        $this->app->bind(Dispatcher::class, fn ($app): Dispatcher => new Dispatcher($app->make(Router::class), $app->make(Request::class)));

        $this->app->alias(Dispatcher::class, 'SubRequest');
    }
}
