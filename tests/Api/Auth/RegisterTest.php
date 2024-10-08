<?php

namespace Tests\Api\Auth;

use App\Domain\Users\Services\AuthService;
use App\Domain\Users\Services\UserService;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\RateLimiter;
use Inertia\Testing\AssertableInertia;
use Mockery;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Tests\Api\TestCase;

class RegisterTest extends TestCase
{
    use WithFaker;

    public function test_guest_can_view_register_page(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(HttpResponse::HTTP_OK);

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Auth/Register');
        });
    }

    public function test_user_can_not_view_register_page(): void
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get('/register');

        $response->assertStatus(HttpResponse::HTTP_FOUND);
    }

    public function test_guest_can_register_user(): void
    {
        RateLimiter::shouldReceive('tooManyAttempts')
            ->once()
            ->andReturn(false);

        RateLimiter::shouldReceive('clear')
            ->once()
            ->andReturn(true);

        $this->instance(UserService::class, Mockery::mock(UserService::class, function (MockInterface $mock) {
            $mock->shouldReceive('createUser')
                ->once()
                ->andReturn(User::factory()->make());
        }));

        $this->instance(AuthService::class, Mockery::mock(AuthService::class, function (MockInterface $mock) {
            $mock->shouldReceive('authenticateUser')
                ->once();
        }));

        $password = $this->faker->password;
        $response = $this->post('/register', [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);
        $response->assertRedirectToRoute('home');
    }
}
