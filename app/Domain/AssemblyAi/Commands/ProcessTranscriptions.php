<?php

namespace App\Domain\AssemblyAi\Commands;

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
    protected $description = 'Process Transcriptions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //TODO: update pending transcriptions
    }
}
