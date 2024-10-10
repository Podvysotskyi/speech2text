<?php

namespace App\Domain\Records\Repositories;

use App\Models\Record;
use App\Models\RecordTranscription;
use App\Models\RecordTranscriptionSpeaker;

class RecordTranscriptionRepository
{
    public function createSpeaker(Record $record, string $speaker): RecordTranscriptionSpeaker
    {
        /** @var RecordTranscriptionSpeaker $speaker */
        $speaker = $record->speakers()->firstOrCreate([
            'name' => $speaker,
        ]);

        return $speaker;
    }

    public function createTranscription(Record $record, RecordTranscriptionSpeaker $speaker, string $text, int $start, int $end): RecordTranscription
    {
        /** @var RecordTranscription $transcription */
        $transcription = $record->transcriptions()->create([
            'speaker_id' => $speaker->id,
            'text' => $text,
            'start' => $start,
            'end' => $end,
        ]);

        return $transcription;
    }
}
