<?php

namespace App\DataValueObjects\Requests\Records;

use App\DataValueObjects\DataValueObject;

class RecordsRequestData extends DataValueObject
{
    public function __construct(
        public ?string $status,
    ) {
    }
}
