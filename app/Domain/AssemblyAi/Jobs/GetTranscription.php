<?php

namespace App\Domain\AssemblyAi\Jobs;

use App\Domain\AssemblyAi\Repositories\TranscriptionRepository;
use App\Domain\AssemblyAi\Services\ApiService;
use App\Domain\Records\Enums\RecordState;
use App\Domain\Records\Repositories\RecordStateRepository;
use App\Models\AssemblyAi\Transcription;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\SerializesModels;

class GetTranscription implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    private Transcription $transcription;

    /**
     * Create a new job instance.
     */
    public function __construct(
        Transcription $transcription,
    ) {
        $this->transcription = $transcription->load('record');
    }

    /**
     * Execute the job.
     *
     * @throws ConnectionException
     * @throws RequestException
     */
    public function handle(
        ApiService $apiService,
        RecordStateRepository $recordStateRepository,
        TranscriptionRepository $transcriptionRepository,
    ): void {
        try {
            $dto = $apiService->getTranscription($this->transcription);

            $transcriptionRepository->updateTranscription($this->transcription, $dto->status, $dto->data);

            if ($dto->status !== 'completed') {
                return;
            }

            //TODO: Process transcription

            $recordStateRepository->updateState($this->transcription->record, RecordState::Completed);
        } catch (Exception $e) {
            $recordStateRepository->updateState($this->transcription->record, RecordState::Failed);
            throw $e;
        }
    }
}
