<?php

namespace Tests;

use Illuminate\Http\Response;
use Myerscode\Laravel\SubRequest\Dispatcher;
use Myerscode\Laravel\SubRequest\HttpVerb;

class HelperTest extends TestCase
{

    public function httpVerbProvider()
    {
        return [
            HttpVerb::GET => [HttpVerb::GET],
            HttpVerb::HEAD => [HttpVerb::HEAD],
            HttpVerb::POST => [HttpVerb::POST],
            HttpVerb::PUT => [HttpVerb::PUT],
            HttpVerb::DELETE => [HttpVerb::DELETE],
            HttpVerb::CONNECT => [HttpVerb::CONNECT],
            HttpVerb::OPTIONS => [HttpVerb::OPTIONS],
            HttpVerb::TRACE => [HttpVerb::TRACE],
            HttpVerb::PATCH => [HttpVerb::PATCH],
        ];
    }

    public function testHelperReturnsResponse()
    {
        $this->assertInstanceOf(Response::class, subrequest(HttpVerb::GET, '/', []));
    }

    /**
     * @param $verb string
     *
     * @dataProvider httpVerbProvider
     */
    public function testHelperAcceptsAllHttpVerbs(string $verb)
    {
        $this->mock(Dispatcher::class)
            ->shouldReceive('dispatch')
            ->andReturn($verb);

        $this->assertEquals($verb, subrequest($verb, '/', []));
    }
}
