<?php

namespace Tests\Feature\Domain\Users\Repositories;

use App\Domain\Users\DataValueObjects\Auth\RegisterRequestData;
use App\Domain\Users\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\Feature\TestCase;

class UserRepositoryTest extends TestCase
{
    use WithFaker;

    protected UserRepository $testedClass;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testedClass = new UserRepository();
    }

    public function test_repository_can_count_users()
    {
        $userCount = $this->faker->numberBetween(2, 5);

        User::factory()->count($userCount)->create();

        $result = $this->testedClass->count();

        $this->assertEquals($userCount, $result);
    }

    public function test_repository_can_create_user()
    {
        $data = new RegisterRequestData(
            name: $this->faker->name,
            email: $this->faker->email,
            password: $this->faker->password
        );

        $result = $this->testedClass->create($data->name, $data->email, $data->password);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($data->name, $result->name);
        $this->assertEquals($data->email, $result->email);
        $this->assertTrue(Hash::check($data->password, $result->password));

        $this->assertDatabaseHas(User::class, [
            'name' => $data->name,
            'email' => $data->email,
        ]);
    }
}
