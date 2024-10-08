<?php

namespace App\Domain\Records\DataValueObjects\Requests;

use App\DataValueObject;

readonly class RecordsRequestData extends DataValueObject
{
    public function __construct(
        public ?string $status,
    ) {
    }
}
