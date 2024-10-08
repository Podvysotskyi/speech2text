<?php

namespace App\Domain\AssemblyAi\DataValueObjects\Responses;

use App\DataValueObject;

readonly class FileUploadData extends DataValueObject
{
    public function __construct(
        public string $upload_url
    ) {
    }
}
