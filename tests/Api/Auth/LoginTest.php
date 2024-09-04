<?php

namespace Tests\Api\Auth;

use App\Models\User;
use App\Services\UserService;
use Inertia\Testing\AssertableInertia;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Tests\Api\TestCase;

class LoginTest extends TestCase
{
    public function test_guest_can_view_login_page_if_any_user_exists(): void
    {
        $this->mock(UserService::class, function (MockInterface $mock) {
            $mock->shouldReceive('getUserCount')->once()->andReturn(1);
        });

        $response = $this->get('/login');

        $response->assertStatus(HttpResponse::HTTP_OK);

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Auth/Login');
        });
    }

    public function test_guest_get_redirected_to_register_page_if_no_users_exists(): void
    {
        $this->mock(UserService::class, function (MockInterface $mock) {
            $mock->shouldReceive('getUserCount')->once()->andReturn(0);
        });

        $response = $this->get('/login');

        $response->assertRedirectToRoute('register');
    }

    public function test_user_can_not_view_login_page(): void
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertStatus(HttpResponse::HTTP_FOUND);
    }
}
