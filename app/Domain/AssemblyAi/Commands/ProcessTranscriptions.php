<?php

namespace App\Domain\AssemblyAi\Commands;

use App\Domain\AssemblyAi\Jobs\UpdateTranscription;
use App\Domain\AssemblyAi\Repositories\TranscriptionRepository;
use App\Models\AssemblyAi\Transcription;
use Illuminate\Console\Command;

class ProcessTranscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assessment-ai:process-transcriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process RecordTranscription';

    /**
     * Execute the console command.
     */
    public function handle(TranscriptionRepository $transcriptionRepository): void
    {
        $transcriptions = $transcriptionRepository->getTranscriptions(['queued', 'processing']);

        $transcriptions->each(function (Transcription $transcription) {
            UpdateTranscription::dispatch($transcription);
        });
    }
}
