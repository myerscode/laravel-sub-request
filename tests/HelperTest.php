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

    #[DataProvider('httpVerbProvider')]
    public function test_helper_accepts_all_http_verbs(string $verb): void
    {
        $response = new Response($verb);

        $this->mock(Dispatcher::class)
            ->shouldReceive('dispatch')
            ->andReturn($response);

        $this->assertSame($verb, subrequest($verb, '/', [])->getContent());
    }

    public function test_helper_accepts_collection(): void
    {
        $this->assertInstanceOf(JsonResponse::class, subrequest('POST', '/', collect(['hello' => 'world'])));
    }

    public function test_helper_returns_response(): void
    {
        $this->assertInstanceOf(Response::class, subrequest(HttpVerb::GET, '/', []));
    }

    public function test_helper_throws_exception_with_invalid_data(): void
    {
        $this->expectException(TypeError::class);
        subrequest('POST', '/', 'foo=bar');
    }

    public function test_helper_throws_exception_with_invalid_verb(): void
    {
        $this->expectException(InvalidArgumentException::class);
        subrequest('FOOBAR', '/', []);
    }
}
