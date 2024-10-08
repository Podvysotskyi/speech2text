<?php

namespace App\Domain\AssemblyAi\Repositories;

use App\Models\AssemblyAi\FileUpload;
use App\Models\Record;

class FileUploadRepository
{
    public function saveFileUpload(Record $record, string $url): FileUpload
    {
        /** @var FileUpload $fileUpload */
        $fileUpload = FileUpload::query()->create([
            'record_id' => $record->id,
            'url' => $url,
        ]);

        return $fileUpload;
    }
}
