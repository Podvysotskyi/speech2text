<?php

namespace Tests\Unit\Domain\Users\Services;

use App\Domain\Users\Repositories\UserRepository;
use App\Domain\Users\Services\AuthService;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Mockery\MockInterface;
use Tests\Unit\TestCase;

class AuthServiceTest extends TestCase
{
    protected AuthService $testedClass;

    protected MockInterface|UserRepository $userRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepositoryMock = Mockery::mock(UserRepository::class);

        $this->testedClass = new AuthService(
            userRepository: $this->userRepositoryMock,
        );
    }

    public function test_service_can_authenticate_user()
    {
        /** @var Request $request */
        $request = $this->mock(Request::class, function (MockInterface $mock) {
            $mock->shouldReceive('session')->once()->andReturn(
                $this->mock(Session::class, function (MockInterface $mock) {
                    $mock->shouldReceive('regenerate')->once();
                })
            );
        });

        $user = User::factory()->make([
            'id' => 1,
        ]);

        Auth::shouldReceive('loginUsingId')
            ->once()->with(1);

        $this->testedClass->authenticateUser($user, $request);
    }
}
