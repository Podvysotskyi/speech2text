<?php

namespace App\Domain\Users\Services;

use App\Domain\Users\DataValueObjects\Auth\RegisterRequestData;
use App\Domain\Users\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {
    }

    public function getUserCount(): int
    {
        if (Cache::has('user-count')) {
            return Cache::get('user-count');
        }

        $userCount = $this->userRepository->count();

        Cache::put('user-count', $userCount);

        return $userCount;
    }

    public function createUser(RegisterRequestData $data): User
    {
        $user = $this->userRepository->create(
            name: $data->name,
            email: $data->email,
            password: $data->password,
        );

        Cache::forget('user-count');

        Storage::disk('records')->makeDirectory($user->id);

        return $user;
    }
}
