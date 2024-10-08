<?php

namespace App\Domain\Records\Exceptions\Records;

use Exception;

class RecordExistsException extends Exception
{
    public function __construct()
    {
        parent::__construct('Record already exists.');
    }
}
