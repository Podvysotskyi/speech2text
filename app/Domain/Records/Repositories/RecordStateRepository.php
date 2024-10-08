<?php

namespace App\Domain\Records\Repositories;

use App\Domain\Records\Enums\RecordState as RecordStates;
use App\Models\Record;
use App\Models\RecordState;

class RecordStateRepository
{
    public function updateState(Record $record, RecordStates $state): RecordState
    {
        /** @var RecordState $state */
        $state = RecordState::query()->updateOrCreate([
            'record_id' => $record->id,
        ], [
            'state' => $state,
        ]);

        return $state;
    }
}
