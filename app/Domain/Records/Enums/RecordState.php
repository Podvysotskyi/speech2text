<?php

namespace App\Domain\Records\Enums;

enum RecordState: string
{
    case Pending = 'Pending';
    case Processing = 'Processing';
    case Completed = 'Completed';
    case Failed = 'Failed';
}
