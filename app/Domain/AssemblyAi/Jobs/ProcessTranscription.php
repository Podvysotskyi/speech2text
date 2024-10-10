<?php

namespace App\Domain\AssemblyAi\Jobs;

use App\Domain\Records\Enums\RecordState;
use App\Domain\Records\Repositories\RecordStateRepository;
use App\Domain\Records\Repositories\RecordTranscriptionRepository;
use App\Models\AssemblyAi\Transcription;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessTranscription implements ShouldQueue
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
     * @throws Exception
     */
    public function handle(
        RecordStateRepository $recordStateRepository,
        RecordTranscriptionRepository $recordTranscriptionRepository,
    ): void {
        try {
            DB::transaction(function () use ($recordStateRepository, $recordTranscriptionRepository) {
                $speakers = [];

                foreach ($this->transcription->data['utterances'] as $utterance) {
                    $speaker = $utterance['speaker'];

                    if (! array_key_exists($utterance['speaker'], $speakers)) {
                        $speakers[$speaker] = $recordTranscriptionRepository->createSpeaker(
                            $this->transcription->record, $speaker
                        );
                    }

                    $recordTranscriptionRepository->createTranscription(
                        $this->transcription->record,
                        $speakers[$speaker],
                        $utterance['text'],
                        $utterance['start'],
                        $utterance['end'],
                    );
                }

                $recordStateRepository->updateState($this->transcription->record, RecordState::Completed);
            });
        } catch (Exception $e) {
            $recordStateRepository->updateState($this->transcription->record, RecordState::Failed);
            throw $e;
        }
    }
}
