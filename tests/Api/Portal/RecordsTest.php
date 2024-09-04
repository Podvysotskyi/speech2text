<?php

namespace Tests\Api\Portal;

use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Tests\Api\TestCase;

class RecordsTest extends TestCase
{
    public function test_guest_get_redirected_to_login_page(): void
    {
        $response = $this->get('/records');

        $response->assertRedirectToRoute('login');
    }

    public function test_user_can_view_records_page(): void
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get('/records');

        $response->assertStatus(HttpResponse::HTTP_OK);

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Portal/Records');
        });
    }
}
