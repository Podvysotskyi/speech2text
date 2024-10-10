<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('record_transcriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('record_id')->references('id')->on('records');
            $table->foreignUuid('speaker_id')->references('id')->on('record_transcription_speakers');
            $table->text('text');
            $table->integer('start');
            $table->integer('end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('record_transcriptions');
    }
};
