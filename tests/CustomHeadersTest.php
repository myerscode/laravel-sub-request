<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Laravel\SubRequest\HttpVerb;

final class CustomHeadersTest extends TestCase
{
    public function testDeleteShortcutSendsCustomHeaders(): void
    {
        $response = $this->getDispatcher()->delete('/echo-headers', [], [
            'X-Custom' => 'delete-header',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('delete-header', $data['x-custom']);
    }
    public function testDispatchSendsCustomHeaders(): void
    {
        $response = $this->getDispatcher()->dispatch(HttpVerb::GET, '/echo-headers', [], [
            'X-Custom' => 'hello-world',
            'Accept' => 'application/xml',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('hello-world', $data['x-custom']);
        $this->assertSame('application/xml', $data['accept']);
    }

    public function testDispatchWithoutHeadersStillWorks(): void
    {
        $response = $this->getDispatcher()->get('/echo-headers');

        $this->assertSame(200, $response->getStatusCode());
    }

    public function testFacadeSendsCustomHeaders(): void
    {
        $response = \Myerscode\Laravel\SubRequest\SubRequest::dispatch('GET', '/echo-headers', [], [
            'X-Custom' => 'from-facade',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('from-facade', $data['x-custom']);
    }

    public function testGetShortcutSendsCustomHeaders(): void
    {
        $response = $this->getDispatcher()->get('/echo-headers', [], [
            'Authorization' => 'Bearer test-token',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('Bearer test-token', $data['authorization']);
    }

    public function testHelperSendsCustomHeaders(): void
    {
        $response = subrequest('GET', '/echo-headers', [], [
            'X-Custom' => 'from-helper',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('from-helper', $data['x-custom']);
    }

    public function testOptionsShortcutSendsCustomHeaders(): void
    {
        $response = $this->getDispatcher()->options('/echo-headers', [], [
            'X-Custom' => 'options-header',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('options-header', $data['x-custom']);
    }

    public function testPatchShortcutSendsCustomHeaders(): void
    {
        $response = $this->getDispatcher()->patch('/echo-headers', [], [
            'X-Custom' => 'patch-header',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('patch-header', $data['x-custom']);
    }

    public function testPostShortcutSendsCustomHeaders(): void
    {
        $response = $this->getDispatcher()->post('/echo-headers', ['foo' => 'bar'], [
            'X-Custom' => 'post-header',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('post-header', $data['x-custom']);
    }

    public function testPutShortcutSendsCustomHeaders(): void
    {
        $response = $this->getDispatcher()->put('/echo-headers', [], [
            'X-Custom' => 'put-header',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('put-header', $data['x-custom']);
    }
}
