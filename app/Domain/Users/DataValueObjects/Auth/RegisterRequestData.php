<?php

namespace App\Domain\Users\DataValueObjects\Auth;

use App\DataValueObject;

readonly class RegisterRequestData extends DataValueObject
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {
    }
}
