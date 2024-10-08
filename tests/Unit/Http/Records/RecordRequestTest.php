<?php

namespace Tests\Unit\Http\Records;

use App\Domain\Records\DataValueObjects\Requests\RecordRequestData;
use App\Http\Requests\Records\RecordRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Tests\Unit\TestCase;

class RecordRequestTest extends TestCase
{
    use WithFaker;

    protected RecordRequest $testedClass;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testedClass = new RecordRequest();
    }

    public function test_request_can_validate_data()
    {
        $data = [];

        $validator = Validator::make($data, $this->testedClass->rules());
        $this->assertTrue($validator->fails());

        $errors = $validator->errors()->messages();
        $this->assertArrayHasKey('record', $errors);
        $this->assertEquals([__('validation.required', ['attribute' => 'record'])], $errors['record']);
    }

    public function test_request_can_return_requested_date()
    {
        $file = UploadedFile::fake()->create('test.mp3');

        $this->testedClass->files->add(['record' => $file]);

        $this->testedClass->merge([
            'record' => $file,
        ]);

        $result = $this->testedClass->data();

        $this->assertInstanceOf(RecordRequestData::class, $result);
        $this->assertEquals($file, $result->file);
    }
}
