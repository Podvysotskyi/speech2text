<?php

namespace App\Domain\Records\Repositories;

use App\Domain\Records\Enums\RecordState;
use App\Models\Record;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class RecordRepository
{
    public function create(User $user, UploadedFile $file): Record
    {
        $name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $mime = $file->getClientMimeType();
        $hash = md5_file($file->getRealPath());

        /** @var Record $record */
        $record = $user->records()
            ->create([
                'name' => $name,
                'extension' => $extension,
                'mime' => $mime,
                'hash' => $hash,
            ]);

        return $record;
    }

    public function exists(User $user, string $name, string $hash): bool
    {
        return $user->records()
            ->where(function (Builder $query) use ($name, $hash) {
                $query->where('name', $name)
                    ->orWhere('hash', $hash);
            })->exists();
    }

    public function getRecords(User $user, ?string $state = null): Collection
    {
        return $user->records()
            ->with('state')
            ->when($state, function (Builder $query, string $state) {
                $query->whereHas('state', function (Builder $query) use ($state) {
                    $query->where('state', $state);
                });
            })->get();
    }

    public function countRecords(User $user, RecordState $state): int
    {
        return $user->records()
            ->whereHas('state', function (Builder $query) use ($state) {
                $query->where('state', $state->value);
            })->count();
    }
}
