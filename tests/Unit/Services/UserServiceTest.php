<?php

namespace Tests\Unit\Services;

use App\DataValueObjects\Requests\Auth\RegisterRequestData;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Mockery\MockInterface;
use Tests\Unit\TestCase;

class UserServiceTest extends TestCase
{
    use WithFaker;

    protected UserService $testedClass;

    protected MockInterface|UserRepository $userRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepositoryMock = Mockery::mock(UserRepository::class);

        $this->testedClass = new UserService(
            userRepository: $this->userRepositoryMock,
        );
    }

    public function test_service_can_get_user_count_from_cache()
    {
        $userCount = $this->faker->numberBetween(2);

        Cache::shouldReceive('has')->with('user-count')
            ->once()->andReturn(true);

        Cache::shouldReceive('get')->with('user-count')
            ->once()->andReturn($userCount);

        $result = $this->testedClass->getUserCount();

        $this->assertEquals($userCount, $result);
    }

    public function test_service_can_get_user_count_from_database()
    {
        $userCount = $this->faker->numberBetween(2);

        Cache::shouldReceive('has')
            ->with('user-count')
            ->once()
            ->andReturn(false);

        $this->userRepositoryMock->shouldReceive('count')
            ->once()->andReturn($userCount);

        Cache::shouldReceive('put')
            ->with('user-count', $userCount)
            ->once();

        $result = $this->testedClass->getUserCount();

        $this->assertEquals($userCount, $result);
    }

    public function test_service_can_create_user()
    {
        $data = new RegisterRequestData(
            name: $this->faker->name,
            email: $this->faker->email,
            password: $this->faker->password,
        );
        $user = User::factory()->make([
            'name' => $data->name,
            'email' => $data->email,
            'password' => $data->password,
        ]);

        $this->userRepositoryMock->shouldReceive('create')
            ->with($data->name, $data->email, $data->password)
            ->once()
            ->andReturn($user);

        Cache::shouldReceive('forget')
            ->with('user-count')
            ->once();

        $result = $this->testedClass->createUser($data);

        Storage::disk('records')->assertExists($user->id);

        $this->assertSame($user, $result);
    }
}
