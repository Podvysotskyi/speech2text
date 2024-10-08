<?php

namespace Tests\Unit\Http\Auth;

use App\Domain\Users\DataValueObjects\Auth\LoginRequestData;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\RateLimiter;
use Tests\Unit\TestCase;

class LoginRequestTest extends TestCase
{
    use WithFaker;

    protected string $ip;

    protected LoginRequest $testedClass;

    public function setUp(): void
    {
        parent::setUp();

        $this->ip = $this->faker->ipv4;

        $this->testedClass = new LoginRequest();
        $this->testedClass->server->set('REMOTE_ADDR', $this->ip);
    }

    public function test_request_can_authorize_request()
    {
        $rateLimiterResult = $this->faker->boolean;

        RateLimiter::shouldReceive('tooManyAttempts')
            ->with('login-attempts:'.$this->ip, LoginRequest::RATE_LIMITER_MAX_ATTEMPTS)
            ->once()
            ->andReturn($rateLimiterResult);

        $result = $this->testedClass->authorize();

        $this->assertEquals(! $rateLimiterResult, $result);
    }

    public function test_request_can_return_request_data()
    {
        $data = [
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ];

        $this->testedClass->merge($data);

        $result = $this->testedClass->data();

        $this->assertInstanceOf(LoginRequestData::class, $result);
        $this->assertEquals($data['email'], $result->email);
        $this->assertEquals($data['password'], $result->password);
    }
}
