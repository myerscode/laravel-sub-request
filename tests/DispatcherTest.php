<?php

namespace Tests;

use Illuminate\Http\Response;
use Myerscode\Laravel\SubRequest\Dispatcher;
use Myerscode\Laravel\SubRequest\HttpVerb;

class DispatcherTest extends TestCase
{

    public function httpVerbProvider()
    {
        return [
            HttpVerb::GET => [HttpVerb::GET],
            HttpVerb::POST => [HttpVerb::POST],
            HttpVerb::PUT => [HttpVerb::PUT],
            HttpVerb::DELETE => [HttpVerb::DELETE],
            HttpVerb::OPTIONS => [HttpVerb::OPTIONS],
            HttpVerb::PATCH => [HttpVerb::PATCH],
        ];
    }

    /**
     * @param $verb string
     *
     * @dataProvider httpVerbProvider
     */
    public function testShortcutCallsOnlyAcceptValidVerbs(string $verb)
    {
        $this->mock(Dispatcher::class)
            ->shouldReceive('dispatch')
            ->andReturn($verb);

        $this->assertInstanceOf(Response::class, $this->getDispatcher()->$verb("/verb/$verb", []));
    }
}
