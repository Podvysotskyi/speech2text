<?php

namespace App\DataValueObjects\Requests\Auth;

use App\DataValueObjects\DataValueObject;

class RegisterRequestData extends DataValueObject
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {
    }
}
