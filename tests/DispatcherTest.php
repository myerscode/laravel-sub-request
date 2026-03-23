<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Http\Response;
use Iterator;
use Myerscode\Laravel\SubRequest\Dispatcher;
use Myerscode\Laravel\SubRequest\HttpVerb;
use PHPUnit\Framework\Attributes\DataProvider;

final class DispatcherTest extends TestCase
{

    public static function httpVerbProvider(): Iterator
    {
        yield HttpVerb::GET => [HttpVerb::GET];
        yield HttpVerb::POST => [HttpVerb::POST];
        yield HttpVerb::PUT => [HttpVerb::PUT];
        yield HttpVerb::DELETE => [HttpVerb::DELETE];
        yield HttpVerb::OPTIONS => [HttpVerb::OPTIONS];
        yield HttpVerb::PATCH => [HttpVerb::PATCH];
    }

    #[DataProvider('httpVerbProvider')]
    public function testShortcutCallsOnlyAcceptValidVerbs(string $verb): void
    {
        $this->mock(Dispatcher::class)
            ->shouldReceive('dispatch')
            ->andReturn($verb);

        $this->assertInstanceOf(Response::class, $this->getDispatcher()->$verb('/verb/' . $verb, []));
    }
}
