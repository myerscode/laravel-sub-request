<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Laravel\SubRequest\Dispatcher;
use Myerscode\Laravel\SubRequest\SubRequestProvider;

final class SubRequestProviderTest extends TestCase
{
    public function testProvidesReturnsDispatcherClass(): void
    {
        $provider = new SubRequestProvider($this->app);

        $this->assertSame([Dispatcher::class], $provider->provides());
    }

    public function testDispatcherIsBoundInContainer(): void
    {
        $this->assertInstanceOf(Dispatcher::class, $this->app->make(Dispatcher::class));
    }

    public function testDispatcherIsAliasedAsSubRequest(): void
    {
        $this->assertInstanceOf(Dispatcher::class, $this->app->make('SubRequest'));
    }
}
