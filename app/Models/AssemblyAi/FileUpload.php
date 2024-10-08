<?php

namespace App\Models\AssemblyAi;

use App\Models\Record;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string id
 * @property string record_id
 * @property string $url
 * @property-read Record $record
 */
class FileUpload extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'assembly_ai_uploads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'record_id',
        'url',
    ];

    public function record(): BelongsTo
    {
        return $this->belongsTo(Record::class);
    }

    public function transcription(): HasOne
    {
        return $this->hasOne(Transcription::class, 'upload_id');
    }
}
