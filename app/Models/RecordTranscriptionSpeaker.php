<?php

namespace App\Models;

use App\Models\AssemblyAi\Transcription;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string id
 * @property string name
 * @property Carbon created_at
 * @property-read RecordState state
 */
class RecordTranscriptionSpeaker extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function record(): BelongsTo
    {
        return $this->belongsTo(Record::class);
    }

    public function transcription(): HasMany
    {
        return $this->hasMany(Transcription::class, 'speaker_id');
    }
}
