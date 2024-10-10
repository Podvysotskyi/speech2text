<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $speaker_id
 * @property string $text
 * @property int $start
 * @property int $end
 * @property Carbon $created_at
 * @property-read Record $record
 * @property-read RecordTranscriptionSpeaker $speaker
 */
class RecordTranscription extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'speaker_id',
        'text',
        'start',
        'end',
    ];

    public function record(): BelongsTo
    {
        return $this->belongsTo(Record::class);
    }

    public function speaker(): BelongsTo
    {
        return $this->belongsTo(RecordTranscriptionSpeaker::class, 'speaker_id');
    }
}
