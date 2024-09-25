<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string id
 * @property string user_id
 * @property string name
 * @property string extension
 * @property string mime
 * @property string hash
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
}