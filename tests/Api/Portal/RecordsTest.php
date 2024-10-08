<?php

namespace Tests\Api\Portal;

use App\Domain\AssemblyAi\Jobs\UploadRecord;
use App\Domain\Records\Services\RecordService;
use App\Models\Record;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Inertia\Testing\AssertableInertia;
use Mockery;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Tests\Api\TestCase;

class RecordsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Queue::fake();
    }

    public function test_guest_get_redirected_to_login_page(): void
    {
        $response = $this->get('/records');

        $response->assertRedirectToRoute('login');
    }

    public function test_user_can_view_records_page(): void
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get('/records');

        $response->assertStatus(HttpResponse::HTTP_OK);

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Portal/Records');
        });
    }

    public function test_user_can_upload_record(): void
    {
        $user = User::factory()->make();

        $this->instance(RecordService::class, Mockery::mock(RecordService::class, function (MockInterface $mock) {
            $record = Record::factory()->make();

            $mock->shouldReceive('createRecord')
                ->once()
                ->andReturn($record);
        }));

        $response = $this->actingAs($user)->post('/records', [
            'record' => UploadedFile::fake()->create('test.mp3'),
        ]);
        $response->assertRedirectToRoute('records', ['status' => 'processing']);

        Queue::assertPushed(UploadRecord::class);
    }
}
