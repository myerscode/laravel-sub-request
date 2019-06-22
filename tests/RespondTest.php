<?php

namespace Tests;

class RespondTest extends TestCase
{

    public function testMiddlewareIsStillApplied()
    {

        $response = $this->get('test');

        $this->assertEquals($response->getStatusCode(), 403);

        $this->assertEquals(
            json_encode(json_decode($response->getContent())),
            json_encode(['message' => 'Access denied'])
        );
    }

}
