<?php

namespace App\Services;

use App\DataValueObjects\Requests\Records\RecordRequestData;
use App\Exceptions\Records\RecordExistsException;
use App\Models\Record;
use App\Models\User;
use App\Repositories\RecordRepository;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RecordService
{
    public function __construct(
        protected RecordRepository $recordRepository,
    ) {
    }

    /**
     * @throws RecordExistsException
     */
    public function createRecord(User $user, RecordRequestData $data): Record
    {
        if ($this->checkRecordExists($user, $data->file)) {
            throw new RecordExistsException();
        }

        /** @var Record $record */
        $record = DB::transaction(function () use ($user, $data) {
            $record = $this->recordRepository->create($user, $data->file);

            Storage::disk('records')->putFileAs($data->file, "$user->id/$record->id");

            return $record;
        });

        return $record;
    }

    private function checkRecordExists(User $user, UploadedFile $file): bool
    {
        $name = $file->getClientOriginalName();
        $hash = md5_file($file->getRealPath());

        return $user->records()->where(function (Builder $query) use ($name, $hash) {
            $query->where('name', $name)
                ->orWhere('hash', $hash);
        })->exists();
    }
}
