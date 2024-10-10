<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string id
 * @property string user_id
 * @property string name
 * @property string extension
 * @property string mime
 * @property string hash
 * @property Carbon created_at
 * @property-read RecordState state
 */
class Record extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'extension',
        'mime',
        'hash',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function state(): HasOne
    {
        return $this->hasOne(RecordState::class);
    }

    public function transcription(): HasOne
    {
        return $this->hasOne(RecordTranscription::class);
    }

    public function speakers(): HasMany
    {
        return $this->hasMany(RecordTranscriptionSpeaker::class);
    }
}
