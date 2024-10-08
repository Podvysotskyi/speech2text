<?php

namespace App\Models;

use App\Domain\Records\Enums\RecordState as RecordStates;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string record_id
 * @property RecordState state
 */
class RecordState extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'record_id',
        'state',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'state' => RecordStates::class,
        ];
    }

    public function record(): BelongsTo
    {
        return $this->belongsTo(Record::class);
    }
}
