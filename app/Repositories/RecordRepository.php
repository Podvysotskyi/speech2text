<?php

namespace App\Repositories;

use App\Models\Record;
use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
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

    public function exists(User $user, string $name, string $hash): bool
    {
        return $user->records()->where(function (Builder $query) use ($name, $hash) {
            $query->where('name', $name)
                ->orWhere('hash', $hash);
        })->exists();
    }
}
