<?php

namespace App\Domain\AssemblyAi\DataValueObjects\Responses;

use App\DataValueObject;

readonly class TranscribeAudioData extends DataValueObject
{
    public function __construct(
        public string $id,
        public string $status,
        public ?array $data = null,
    ) {
    }
}
