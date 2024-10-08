<?php

namespace App\Domain\Records\DataValueObjects\Response;

use App\DataValueObject;

readonly class RecordStateCountData extends DataValueObject
{
    public function __construct(
        public string $state,
        public int $count
    ) {
    }
}
