<?php

namespace Tests\Unit\Exceptions\Records;

use App\Exceptions\Records\RecordExistsException;
use Tests\Unit\TestCase;

class RecordExistsExceptionTest extends TestCase
{
    public function testRecordExistsExceptionMessage()
    {
        $exception = new RecordExistsException();

        $this->assertEquals('Record already exists.', $exception->getMessage());
    }
}
