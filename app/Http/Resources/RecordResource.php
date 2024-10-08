<?php

namespace App\Http\Resources;

use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Record
 */
class RecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => substr($this->name, 0, strlen($this->name) - strlen($this->extension) - 1),
            'extension' => $this->extension,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
