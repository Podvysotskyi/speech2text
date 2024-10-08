<?php

namespace App\Models\AssemblyAi;

use App\Models\Record;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $record_id
 * @property string $upload_id
 * @property string $status
 * @property string|null $data
 * @property-read Record $record
 * @property-read FileUpload $fileUpload
 */
class Transcription extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'assembly_ai_transcriptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'record_id',
        'upload_id',
        'status',
        'data',
    ];

    public function record(): BelongsTo
    {
        return $this->belongsTo(Record::class);
    }

    public function fileUpload(): BelongsTo
    {
        return $this->belongsTo(FileUpload::class, 'upload_id');
    }
}
