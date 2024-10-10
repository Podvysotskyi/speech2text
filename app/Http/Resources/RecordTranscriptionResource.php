<?php

namespace App\Http\Resources;

use App\Models\RecordTranscription;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin RecordTranscription
 */
class RecordTranscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'text' => $this->text,
            'speaker' => new RecordTranscriptionSpeakerResource($this->speaker),
        ];
    }
}
