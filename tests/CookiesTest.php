<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Laravel\SubRequest\HttpVerb;

final class CookiesTest extends TestCase
{
    public function testCookiesAndHeadersCanBeCombined(): void
    {
        $response = $this->getDispatcher()->get('/echo-cookies', [], [
            'X-Custom' => 'header-value',
        ], [
            'session_id' => 'combined-session',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('combined-session', $data['session_id']);
    }

    public function testDeleteShortcutSendsCookies(): void
    {
        $response = $this->getDispatcher()->delete('/echo-cookies', [], [], [
            'token' => 'delete-token',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('delete-token', $data['token']);
    }
    public function testDispatchSendsCookies(): void
    {
        $response = $this->getDispatcher()->dispatch(HttpVerb::GET, '/echo-cookies', [], [], [
            'session_id' => 'abc123',
            'token' => 'my-token',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('abc123', $data['session_id']);
        $this->assertSame('my-token', $data['token']);
    }

    public function testDispatchWithoutCookiesStillWorks(): void
    {
        $response = $this->getDispatcher()->get('/echo-cookies');

        $this->assertSame(200, $response->getStatusCode());
    }

    public function testFacadeSendsCookies(): void
    {
        $response = \Myerscode\Laravel\SubRequest\SubRequest::dispatch('GET', '/echo-cookies', [], [], [
            'preference' => 'light-mode',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('light-mode', $data['preference']);
    }

    public function testGetShortcutSendsCookies(): void
    {
        $response = $this->getDispatcher()->get('/echo-cookies', [], [], [
            'session_id' => 'get-session',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('get-session', $data['session_id']);
    }

    public function testHelperSendsCookies(): void
    {
        $response = subrequest('GET', '/echo-cookies', [], [], [
            'preference' => 'dark-mode',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('dark-mode', $data['preference']);
    }

    public function testOptionsShortcutSendsCookies(): void
    {
        $response = $this->getDispatcher()->options('/echo-cookies', [], [], [
            'token' => 'options-token',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('options-token', $data['token']);
    }

    public function testPatchShortcutSendsCookies(): void
    {
        $response = $this->getDispatcher()->patch('/echo-cookies', [], [], [
            'token' => 'patch-token',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('patch-token', $data['token']);
    }

    public function testPostShortcutSendsCookies(): void
    {
        $response = $this->getDispatcher()->post('/echo-cookies', ['foo' => 'bar'], [], [
            'token' => 'post-token',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('post-token', $data['token']);
    }

    public function testPutShortcutSendsCookies(): void
    {
        $response = $this->getDispatcher()->put('/echo-cookies', [], [], [
            'token' => 'put-token',
        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertSame('put-token', $data['token']);
    }
}
