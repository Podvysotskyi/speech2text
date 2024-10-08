<?php

namespace App\Domain\Records\DataValueObjects\Requests;

use App\DataValueObject;
use Illuminate\Http\UploadedFile;

readonly class RecordRequestData extends DataValueObject
{
    public function __construct(
        public UploadedFile $file,
    ) {
    }
}
