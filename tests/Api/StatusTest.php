<?php

namespace Tests\Api;

class StatusTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/status');

        $response->assertStatus(200);
    }
}
