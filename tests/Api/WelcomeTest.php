<?php

namespace Tests\Api;

use Inertia\Testing\AssertableInertia;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class WelcomeTest extends TestCase
{
    public function test_guest_can_view_welcome_page(): void
    {
        $response = $this->get('/');

        $response->assertStatus(HttpResponse::HTTP_OK);

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Welcome');
        });
    }
}
