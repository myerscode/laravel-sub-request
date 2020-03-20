<?php

namespace Tests;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Myerscode\Laravel\SubRequest\Dispatcher;
use Myerscode\Laravel\SubRequest\HttpVerb;

class HelperTest extends TestCase
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

    public function testHelperAcceptsCollection()
    {
        $this->assertInstanceOf(JsonResponse::class, subrequest('POST', '/', collect(['hello' => 'world'])));
    }

    public function testHelperThrowsExceptionWithInvalidVerb()
    {
        $this->expectException(\InvalidArgumentException::class);
        subrequest('FOOBAR', '/', []);
    }

    public function testHelperThrowsExceptionWithInvalidData()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$input must be a an instance of array or \Illuminate\Support\Collection');
        subrequest('POST', '/', 'foo=bar');
    }

}
