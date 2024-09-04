<?php

namespace Api\Auth;

use App\Http\Controllers\Auth\LogoutController;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Tests\Api\TestCase;

class LogoutTest extends TestCase
{
    public function test_guest_can_not_logout(): void
    {
        $response = $this->get('/logout');

        $response->assertStatus(HttpResponse::HTTP_METHOD_NOT_ALLOWED);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirectToRoute(LogoutController::redirect_route);
    }
}
