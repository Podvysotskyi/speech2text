<?php

namespace App\Domain\Users\DataValueObjects\Auth;

use App\DataValueObject;

readonly class LoginRequestData extends DataValueObject
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }
}
