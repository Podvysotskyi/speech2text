<?php

namespace Tests\Feature\Repositories;

use App\Models\Record;
use App\Models\User;
use App\Repositories\RecordRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\Feature\TestCase;

class RecordRepositoryTest extends TestCase
{
    use WithFaker;

    protected RecordRepository $testedClass;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testedClass = new RecordRepository();
    }

    public function test_repository_can_create_record()
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('test.mp3');

        $record = $this->testedClass->create($user, $file);

        $this->assertInstanceOf(Record::class, $record);
        $this->assertEquals('test.mp3', $record->name);
        $this->assertEquals('mp3', $record->extension);
        $this->assertEquals('audio/mpeg', $record->mime);

        $this->assertDatabaseHas(Record::class, [
            'id' => $record->id,
        ]);
    }

    public function test_repository_can_check_if_record_exists()
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('test.mp3');
        $hash = md5_file($file);

        Record::factory()->create([
            'user_id' => $user->id,
            'name' => 'test.mp3',
            'extension' => 'mp3',
        ]);

        $result = $this->testedClass->exists($user, $file->name, $hash);

        $this->assertTrue($result);
    }

    public function test_repository_can_check_if_record_not_exists()
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('test.mp3');
        $hash = md5_file($file);

        Record::factory()->create([
            'user_id' => $user->id,
            'name' => 'test.txt',
            'extension' => 'txt',
        ]);

        $result = $this->testedClass->exists($user, $file->name, $hash);

        $this->assertFalse($result);
    }
}
