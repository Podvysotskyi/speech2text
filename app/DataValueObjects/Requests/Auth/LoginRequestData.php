<?php

namespace App\DataValueObjects\Requests\Auth;

use App\DataValueObjects\DataValueObject;

class LoginRequestData extends DataValueObject
{
    public function __construct(
        public string $name,
        public string $password,
    ) {
    }
}
