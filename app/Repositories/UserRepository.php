<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function count(): int
    {
        return User::query()->count();
    }

    public function create(string $name, string $email, string $password): User
    {
        $user = new User();
        $user->fill([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
        $user->save();

        return $user;
    }
}
