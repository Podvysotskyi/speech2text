<?php

namespace App\Repositories;

use App\DataValueObjects\Requests\Auth\RegisterRequestData;
use App\Models\User;

class UserRepository
{
    public function count(): int
    {
        return User::query()->count();
    }

    public function create(RegisterRequestData $data): User
    {
        $user = new User();
        $user->fill($data->toArray());
        $user->save();

        return $user;
    }
}
