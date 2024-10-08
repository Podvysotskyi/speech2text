<?php

namespace App\Domain\AssemblyAi\Repositories;

use App\Models\AssemblyAi\FileUpload;
use App\Models\AssemblyAi\Transcription;
use Illuminate\Support\Collection;

class TranscriptionRepository
{
    public function createTranscription(FileUpload $fileUpload, string $id, string $status): Transcription
    {
        /** @var Transcription $transcription */
        $transcription = Transcription::query()->create([
            'id' => $id,
            'record_id' => $fileUpload->record_id,
            'upload_id' => $fileUpload->id,
            'status' => $status,
            'data' => null,
        ]);

        return $transcription;
    }

    public function updateTranscription(Transcription $transcription, string $status, array $data): Transcription
    {
        $transcription->fill([
            'status' => $status,
            'data' => $data,
        ])->save();

        return $transcription;
    }

    public function getTranscriptions(string $status, int $limit = 10): Collection
    {
        return Transcription::query()
            ->where('status', $status)
            ->limit($limit)
            ->get();
    }
}
