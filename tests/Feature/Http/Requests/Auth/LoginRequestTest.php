<?php

namespace Feature\Http\Requests\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Tests\Feature\TestCase;

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

    public function test_request_can_validate_unique_data()
    {
        $data = [];

        $validator = Validator::make($data, $this->testedClass->rules());
        $this->assertTrue($validator->fails());

        $errors = $validator->errors()->messages();
        $this->assertArrayHasKey('email', $errors);
        $this->assertEquals([__('validation.required', ['attribute' => 'email'])], $errors['email']);
        $this->assertArrayHasKey('password', $errors);
        $this->assertEquals([__('validation.required', ['attribute' => 'password'])], $errors['password']);
    }
}
