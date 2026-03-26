<?php

declare(strict_types=1);

namespace Tests;

final class RespondTest extends TestCase
{
    public function test_middleware_is_still_applied(): void
    {

        $testResponse = $this->get('test');

        $this->assertEquals(403, $testResponse->getStatusCode());

        $this->assertEquals(
            json_encode(json_decode($testResponse->getContent())),
            json_encode(['message' => 'Access denied']),
        );
    }
}
