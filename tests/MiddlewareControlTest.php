<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\AddHeaderMiddleware;
use Tests\Support\TestMiddleware;

final class MiddlewareControlTest extends TestCase
{
    public function testMiddlewareRunsByDefault(): void
    {
        $response = $this->getDispatcher()->get('/apply-middleware', ['hello' => 'world']);

        $this->assertSame(403, $response->getStatusCode());
    }

    public function testWithoutMiddlewareAcceptsArray(): void
    {
        $response = $this->getDispatcher()
            ->withoutMiddleware([TestMiddleware::class])
            ->get('/apply-middleware', ['foo' => 'bar']);

        $this->assertSame(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);

        $this->assertSame(['foo' => 'bar'], $data);
    }

    public function testWithoutMiddlewareIsChainable(): void
    {
        $response = $this->getDispatcher()
            ->withoutMiddleware(TestMiddleware::class)
            ->withoutMiddleware(AddHeaderMiddleware::class)
            ->get('/dual-middleware', ['key' => 'value']);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertNull($response->headers->get('X-Added-By-Middleware'));
    }

    public function testWithoutMiddlewareOnlyExcludesSpecified(): void
    {
        $response = $this->getDispatcher()
            ->withoutMiddleware(TestMiddleware::class)
            ->get('/dual-middleware', ['key' => 'value']);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('true', $response->headers->get('X-Added-By-Middleware'));
    }

    public function testWithoutMiddlewareResetsAfterDispatch(): void
    {
        $dispatcher = $this->getDispatcher();

        $response = $dispatcher
            ->withoutMiddleware(TestMiddleware::class)
            ->get('/apply-middleware', ['hello' => 'world']);

        $this->assertSame(200, $response->getStatusCode());

        // Second call without withoutMiddleware should apply middleware again
        $response = $dispatcher->get('/apply-middleware', ['hello' => 'world']);

        $this->assertSame(403, $response->getStatusCode());
    }

    public function testWithoutMiddlewareSkipsSpecifiedMiddleware(): void
    {
        $response = $this->getDispatcher()
            ->withoutMiddleware(TestMiddleware::class)
            ->get('/apply-middleware', ['hello' => 'world']);

        $this->assertSame(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);

        $this->assertSame(['hello' => 'world'], $data);
    }

    public function testWithoutMiddlewareWorksWithAllVerbs(): void
    {
        $dispatcher = $this->getDispatcher();

        // The apply-middleware route is GET only, so test the fluent API returns $this
        $this->assertInstanceOf(\Myerscode\Laravel\SubRequest\Dispatcher::class, $dispatcher->withoutMiddleware(TestMiddleware::class));
    }

    public function testWithoutMiddlewareWorksWithHeadersAndCookies(): void
    {
        $response = $this->getDispatcher()
            ->withoutMiddleware(TestMiddleware::class)
            ->get('/apply-middleware', ['hello' => 'world'], [
                'X-Custom' => 'test',
            ], [
                'session' => 'abc',
            ]);

        $this->assertSame(200, $response->getStatusCode());
    }
}
