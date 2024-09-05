<?php

namespace App\Repositories;

use App\Models\Record;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class RecordRepository
{
    public function create(User $user, UploadedFile $file): Record
    {
        $name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $mime = $file->getClientMimeType();
        $hash = md5_file($file->getRealPath());

        /** @var Record $record */
        $record = $user->records()->create([
            'name' => $name,
            'extension' => $extension,
            'mime' => $mime,
            'hash' => $hash,
        ]);

        return $record;
    }
}
