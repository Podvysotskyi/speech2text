<?php

namespace Tests\Unit\Domain\Records\Exceptions\Records;

use App\Domain\Records\Exceptions\Records\RecordExistsException;
use Tests\Unit\TestCase;

class RecordExistsExceptionTest extends TestCase
{
    public function testRecordExistsExceptionMessage()
    {
        $exception = new RecordExistsException();

        $this->assertEquals('Record already exists.', $exception->getMessage());
    }
}
