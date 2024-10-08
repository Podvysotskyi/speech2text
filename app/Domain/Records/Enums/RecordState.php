<?php

namespace App\Domain\Records\Enums;

use App\EnumToArray;

enum RecordState: string
{
    use EnumToArray;

    case Pending = 'Pending';
    case Processing = 'Processing';
    case Completed = 'Completed';
    case Failed = 'Failed';
}
