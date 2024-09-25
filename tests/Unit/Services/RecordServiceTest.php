<?php

namespace Tests\Unit\Services;

use App\DataValueObjects\Requests\Records\RecordRequestData;
use App\DataValueObjects\Requests\Records\RecordsRequestData;
use App\Exceptions\Records\RecordExistsException;
use App\Models\Record;
use App\Models\User;
use App\Repositories\RecordRepository;
use App\Services\RecordService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Mockery\MockInterface;
use Tests\Unit\TestCase;

class RecordServiceTest extends TestCase
{
    use WithFaker;

    protected RecordService $testedClass;

    protected MockInterface|RecordRepository $recordRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->recordRepositoryMock = Mockery::mock(RecordRepository::class);

        $this->testedClass = new RecordService(
            recordRepository: $this->recordRepositoryMock,
        );
    }

    public function test_service_throws_exception_if_record_exists()
    {
        $user = User::factory()->make();
        $data = new RecordRequestData(
            file: UploadedFile::fake()->image('test.mp3'),
        );

        $this->recordRepositoryMock->shouldReceive('exists')
            ->once()
            ->andReturn(true);

        $this->expectException(RecordExistsException::class);

        $this->testedClass->createRecord($user, $data);
    }

    public function test_service_can_create_record()
    {
        Storage::fake('records');

        $user = User::factory()->make();
        $data = new RecordRequestData(
            file: UploadedFile::fake()->image('test.mp3'),
        );

        $record = Record::factory()->make();

        $this->recordRepositoryMock->shouldReceive('exists')
            ->once()
            ->andReturn(false);
        $this->recordRepositoryMock->shouldReceive('create')
            ->once()
            ->with($user, $data->file)
            ->andReturn($record);

        $result = $this->testedClass->createRecord($user, $data);

        $this->assertEquals($record, $result);

        Storage::disk('records')->assertExists("$user->id/$record->id.mp3");
    }

    public function test_service_can_get_user_records()
    {
        $user = User::factory()->make();
        $data = new RecordsRequestData(
            status: null,
        );

        $records = collect([
            Record::factory()->make(),
        ]);

        $this->recordRepositoryMock->shouldReceive('getRecords')
            ->once()
            ->with($user)
            ->andReturn($records);

        $result = $this->testedClass->getUserRecords($user, $data);

        $this->assertEquals($records, $result);
    }
}
