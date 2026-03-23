<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use InvalidArgumentException;
use Iterator;
use Myerscode\Laravel\SubRequest\Dispatcher;
use Myerscode\Laravel\SubRequest\HttpVerb;
use PHPUnit\Framework\Attributes\DataProvider;
use TypeError;

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

    #[DataProvider('httpVerbProvider')]
    public function testHelperAcceptsAllHttpVerbs(string $verb): void
    {
        $response = new Response($verb);

        $this->mock(Dispatcher::class)
            ->shouldReceive('dispatch')
            ->andReturn($response);

        $this->assertEquals($verb, subrequest($verb, '/', [])->getContent());
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
        $this->expectException(TypeError::class);
        subrequest('POST', '/', 'foo=bar');
    }

}
