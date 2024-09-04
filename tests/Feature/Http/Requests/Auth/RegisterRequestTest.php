<?php

namespace Tests\Feature\Http\Requests\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Tests\Feature\TestCase;

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

    public function test_request_can_validate_unique_data()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
        ];

        User::factory()->create($data);

        $validator = Validator::make($data, $this->testedClass->rules());
        $this->assertTrue($validator->fails());

        $errors = $validator->errors()->messages();
        $this->assertArrayHasKey('name', $errors);
        $this->assertEquals([__('validation.unique', ['attribute' => 'name'])], $errors['name']);
        $this->assertArrayHasKey('email', $errors);
        $this->assertEquals([__('validation.unique', ['attribute' => 'email'])], $errors['email']);
    }
}
