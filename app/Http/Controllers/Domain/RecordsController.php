<?php

namespace App\Http\Controllers\Domain;

use App\Domain\AssemblyAi\Jobs\UploadRecord;
use App\Domain\Records\Exceptions\Records\RecordExistsException;
use App\Domain\Records\Services\RecordService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Records\RecordRequest;
use App\Http\Requests\Records\RecordsRequest;
use App\Http\Requests\Records\UploadRecordRequest;
use App\Http\Resources\RecordResource;
use App\Models\Record;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class RecordsController extends Controller implements HasMiddleware
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected RecordService $recordService,
    ) {
    }

    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    /**
     * Show records page.
     */
    public function records(RecordsRequest $request): InertiaResponse
    {
        $data = $request->data();

        $records = $this->recordService->getUserRecords($request->user(), $data);
        $counts = $this->recordService->countUserRecords($request->user());

        return Inertia::render('Domain/Records', [
            'status' => $data->status,
            'records' => RecordResource::collection($records),
            'status_counts' => $counts,
        ]);
    }

    public function record(RecordRequest $request, Record $record): InertiaResponse
    {
        $record->load(['transcriptions', 'transcriptions.speaker']);

        return Inertia::render('Domain/Record', [
            'record' => new RecordResource($record),
        ]);
    }

    /**
     * Create new record
     */
    public function upload(UploadRecordRequest $request): RedirectResponse
    {
        $data = $request->data();

        try {
            $record = $this->recordService->createRecord($request->user(), $data);

            UploadRecord::dispatch($record);
        } catch (RecordExistsException $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }

        return Redirect::route('records', [
            'status' => 'processing',
        ]);
    }

    public function export(RecordRequest $request, Record $record): \Illuminate\Http\Response
    {
        $record->load(['transcriptions', 'transcriptions.speaker']);

        $content = View::make('record', ['record' => $record])->render();
        $filename = substr($record->name, 0, strlen($record->name) - strlen($record->extension) - 1);

        return Response::make($content, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => "attachment; filename=\"$filename.txt\"",
            'Content-Length' => strlen($content),
        ]);
    }
}
