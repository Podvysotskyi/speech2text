<?php

namespace Tests\Unit\Http\Auth;

use App\DataValueObjects\Requests\Auth\RegisterRequestData;
use App\Http\Requests\Auth\RegisterRequest;
use Exception;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Mockery\MockInterface;
use Tests\Unit\TestCase;

class RegisterRequestTest extends TestCase
{
    use WithFaker;

    protected string $ip;

    protected RegisterRequest $testedClass;

    public function setUp(): void
    {
        parent::setUp();

        $this->ip = $this->faker->ipv4;

        $this->testedClass = new RegisterRequest();
        $this->testedClass->server->set('REMOTE_ADDR', $this->ip);
    }

    public function test_request_can_authorize_request()
    {
        $rateLimiterResult = $this->faker->boolean;

        RateLimiter::shouldReceive('tooManyAttempts')
            ->with('register-attempts:'.$this->ip, RegisterRequest::RATE_LIMITER_MAX_ATTEMPTS)
            ->once()
            ->andReturn($rateLimiterResult);

        $result = $this->testedClass->authorize();

        $this->assertEquals(! $rateLimiterResult, $result);
    }

    public function test_request_can_return_request_data()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ];

        $this->testedClass->merge($data);

        $result = $this->testedClass->data();

        $this->assertInstanceOf(RegisterRequestData::class, $result);
        $this->assertEquals($data['name'], $result->name);
        $this->assertEquals($data['email'], $result->email);
        $this->assertEquals($data['password'], $result->password);
    }

    public function test_request_increment_rate_limiter_if_validation_fails()
    {
        /** @var Redirector $redirector */
        $redirector = $this->mock(Redirector::class, function (MockInterface $mock) {
            $mock->shouldReceive('getUrlGenerator')
                ->once()
                ->andReturn($this->mock(UrlGenerator::class, function (MockInterface $mock) {
                    $mock->shouldReceive('previous')->once();
                }));
        });
        $this->testedClass->setRedirector($redirector);

        RateLimiter::shouldReceive('increment')
            ->once()
            ->with('register-attempts:'.$this->ip);

        $validator = Validator::make([], $this->testedClass->rules());

        try {
            $this->testedClass->failedValidation($validator);
        } catch (Exception $e) {
            $this->assertInstanceOf(ValidationException::class, $e);
        }
    }
}
