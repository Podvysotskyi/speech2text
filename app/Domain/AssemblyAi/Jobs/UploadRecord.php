<?php

namespace App\Domain\AssemblyAi\Jobs;

use App\Domain\AssemblyAi\Repositories\FileUploadRepository as AssemblyAiFileUploadRepository;
use App\Domain\AssemblyAi\Services\ApiService;
use App\Domain\Records\Enums\RecordState;
use App\Domain\Records\Repositories\RecordStateRepository;
use App\Models\Record;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\SerializesModels;

class UploadRecord implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Record $record,
    ) {
    }

    /**
     * Execute the job.
     *
     * @throws ConnectionException
     * @throws RequestException
     */
    public function handle(
        ApiService $assemblyAiService,
        AssemblyAiFileUploadRepository $assemblyAiFileUploadRepository,
        RecordStateRepository $recordStateRepository,
    ): void {
        try {
            $data = $assemblyAiService->uploadFile($this->record);
            $fileUpload = $assemblyAiFileUploadRepository->saveFileUpload($this->record, $data->upload_url);

            TranscribeFile::dispatch($fileUpload);
        } catch (Exception $e) {
            $recordStateRepository->updateState($this->record, RecordState::Failed);
            throw $e;
        }
    }
}
