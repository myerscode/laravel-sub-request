<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use InvalidArgumentException;
use Iterator;
use Myerscode\Laravel\SubRequest\Dispatcher;
use Myerscode\Laravel\SubRequest\HttpVerb;

final class HelperTest extends TestCase
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

    public function testHelperReturnsResponse(): void
    {
        $this->assertInstanceOf(Response::class, subrequest(HttpVerb::GET, '/', []));
    }

    /**
     * @param $verb string
     *
     * @dataProvider httpVerbProvider
     */
    public function testHelperAcceptsAllHttpVerbs(string $verb): void
    {
        $this->mock(Dispatcher::class)
            ->shouldReceive('dispatch')
            ->andReturn($verb);

        $this->assertEquals($verb, subrequest($verb, '/', []));
    }

    public function testHelperAcceptsCollection(): void
    {
        $this->assertInstanceOf(JsonResponse::class, subrequest('POST', '/', collect(['hello' => 'world'])));
    }

    public function testHelperThrowsExceptionWithInvalidVerb(): void
    {
        $this->expectException(InvalidArgumentException::class);
        subrequest('FOOBAR', '/', []);
    }

    public function testHelperThrowsExceptionWithInvalidData(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('$input must be a an instance of array or \Illuminate\Support\Collection');
        subrequest('POST', '/', 'foo=bar');
    }

}
