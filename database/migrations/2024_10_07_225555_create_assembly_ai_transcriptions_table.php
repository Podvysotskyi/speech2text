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
        Schema::create('assembly_ai_transcriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('record_id')->references('id')->on('records');
            $table->foreignUuid('upload_id')->references('id')->on('assembly_ai_uploads');
            $table->string('status');
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assembly_ai_transcriptions');
    }
};
