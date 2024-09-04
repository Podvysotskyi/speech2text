<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

/**
 * @property string id
 */
class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use HasUuids;
}
