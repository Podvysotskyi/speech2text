<?php

use App\Domain\AssemblyAi\Commands\ProcessTranscriptions;
use Illuminate\Support\Facades\Schedule;

Schedule::command(ProcessTranscriptions::class)->everyMinute();
