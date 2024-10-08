<?php

namespace App\Domain\AssemblyAi\Jobs;

use App\Domain\AssemblyAi\Repositories\TranscriptionRepository;
use App\Domain\AssemblyAi\Services\ApiService;
use App\Domain\Records\Enums\RecordState;
use App\Domain\Records\Repositories\RecordStateRepository;
use App\Models\AssemblyAi\FileUpload;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\SerializesModels;

class TranscribeFile implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public FileUpload $fileUpload;

    /**
     * Create a new job instance.
     */
    public function __construct(
        FileUpload $fileUpload,
    ) {
        $this->fileUpload = $fileUpload->load('record');
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
            $data = $apiService->transcribeAudio($this->fileUpload);

            $transcriptionRepository->createTranscription($this->fileUpload, $data->id, $data->status);

            $recordStateRepository->updateState($this->fileUpload->record, RecordState::Processing);
        } catch (Exception $e) {
            $recordStateRepository->updateState($this->fileUpload->record, RecordState::Failed);
            throw $e;
        }
    }
}
