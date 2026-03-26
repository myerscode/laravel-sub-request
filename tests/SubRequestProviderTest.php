<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Laravel\SubRequest\Dispatcher;
use Myerscode\Laravel\SubRequest\SubRequestProvider;

final class SubRequestProviderTest extends TestCase
{
    public function test_provides_returns_dispatcher_class(): void
    {
        $subRequestProvider = new SubRequestProvider($this->app);

        $this->assertSame([Dispatcher::class], $subRequestProvider->provides());
    }

    public function test_dispatcher_is_bound_in_container(): void
    {
        $this->assertInstanceOf(Dispatcher::class, $this->app->make(Dispatcher::class));
    }

    public function test_dispatcher_is_aliased_as_sub_request(): void
    {
        $this->assertInstanceOf(Dispatcher::class, $this->app->make('SubRequest'));
    }
}
