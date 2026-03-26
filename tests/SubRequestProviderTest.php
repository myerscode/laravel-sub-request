<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Laravel\SubRequest\Dispatcher;
use Myerscode\Laravel\SubRequest\SubRequestProvider;

final class SubRequestProviderTest extends TestCase
{
    public function testDispatcherIsAliasedAsSubRequest(): void
    {
        $this->assertInstanceOf(Dispatcher::class, $this->app->make('SubRequest'));
    }

    public function testDispatcherIsBoundInContainer(): void
    {
        $this->assertInstanceOf(Dispatcher::class, $this->app->make(Dispatcher::class));
    }

    public function testProvidesReturnsDispatcherClass(): void
    {
        $subRequestProvider = new SubRequestProvider($this->app);

        $this->assertSame([Dispatcher::class], $subRequestProvider->provides());
    }
}
