<?php

namespace App\Domain\Records\Services;

use App\Domain\Records\DataValueObjects\Requests\RecordRequestData;
use App\Domain\Records\DataValueObjects\Requests\RecordsRequestData;
use App\Domain\Records\DataValueObjects\Response\RecordStateCountData;
use App\Domain\Records\Enums\RecordState;
use App\Domain\Records\Exceptions\Records\RecordExistsException;
use App\Domain\Records\Repositories\RecordRepository;
use App\Domain\Records\Repositories\RecordStateRepository;
use App\Models\Record;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RecordService
{
    public function __construct(
        protected RecordRepository $recordRepository,
        protected RecordStateRepository $recordStateRepository,
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
            $this->recordStateRepository->updateState($record, RecordState::Pending);

            Storage::disk('records')->putFileAs($data->file, "$user->id/$record->id");

            return $record;
        });

        return $record;
    }

    private function checkRecordExists(User $user, UploadedFile $file): bool
    {
        $name = $file->getClientOriginalName();
        $hash = md5_file($file->getRealPath());

        return $this->recordRepository->exists($user, $hash, $name);
    }

    public function getUserRecords(User $user, RecordsRequestData $data): Collection
    {
        return $this->recordRepository->getRecords($user, $data->status);
    }

    public function countUserRecords(User $user): Collection
    {
        $result = collect();

        $states = RecordState::cases();
        foreach ($states as $state) {
            $count = $this->recordRepository->countRecords($user, $state);
            $dto = new RecordStateCountData(
                state: $state->value,
                count: $count,
            );
            $result->add($dto);
        }

        return $result;
    }
}
