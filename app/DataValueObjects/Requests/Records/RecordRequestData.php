<?php

namespace App\DataValueObjects\Requests\Records;

use App\DataValueObjects\DataValueObject;
use Illuminate\Http\UploadedFile;

class RecordRequestData extends DataValueObject
{
    public function __construct(
        public UploadedFile $file,
    ) {
    }
}
