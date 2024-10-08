<?php

namespace App\Domain\AssemblyAi\Services;

use App\Domain\AssemblyAi\DataValueObjects\Responses\FileUploadData;
use App\Domain\AssemblyAi\DataValueObjects\Responses\TranscribeAudioData;
use App\Domain\AssemblyAi\Repositories\FileUploadRepository;
use App\Domain\Records\Repositories\RecordRepository;
use App\Models\AssemblyAi\FileUpload;
use App\Models\AssemblyAi\Transcription;
use App\Models\Record;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Psr\Http\Message\ResponseInterface;

class ApiService
{
    protected readonly string $endpoint;

    protected readonly string $token;

    public function __construct(
        protected FileUploadRepository $fileUploadRepository,
        protected RecordRepository $recordRepository,
    ) {
        $this->endpoint = config('services.assembly_ai.endpoint');
        $this->token = config('services.assembly_ai.token');
    }

    protected function apiRequest(): PendingRequest
    {
        $request = Http::baseUrl($this->endpoint)
            ->withToken($this->token);

        $request->withResponseMiddleware(function (ResponseInterface $response) use ($request) {
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/api.log'),
            ])->info($request->getOptions(), (array) $response->getBody());

            return $response;
        });

        return $request;
    }

    /**
     * @throws ConnectionException
     * @throws RequestException
     */
    public function uploadFile(Record $record): FileUploadData
    {
        $file = Storage::disk('records')->readStream("$record->user_id/$record->id");

        $response = $this->apiRequest()->attach(
            'attachment', $file, $record->name,
        )->post('/v2/upload')->throw();

        return new FileUploadData(
            upload_url: $response->json('upload_url'),
        );
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function transcribeAudio(FileUpload $fileUpload): TranscribeAudioData
    {
        $response = $this->apiRequest()
            ->post('/v2/transcribe', [
                'audio_url' => $fileUpload->url,
                'format_text' => true,
                'language_code' => 'en_us',
                'punctuate' => true,
                'speaker_labels' => true,
            ])->throw();

        return new TranscribeAudioData(
            id: $response->json('id'),
            status: $response->json('status'),
        );
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function getTranscription(Transcription $transcription): TranscribeAudioData
    {
        $response = $this->apiRequest()
            ->get("/v2/transcript/{$transcription->id}")
            ->throw();

        return new TranscribeAudioData(
            id: $response->json('id'),
            status: $response->json('status'),
            data: $response->json(),
        );
    }
}
