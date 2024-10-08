<?php

namespace App\Http\Controllers\Portal;

use App\Domain\AssemblyAi\Jobs\UploadRecord;
use App\Domain\Records\Exceptions\Records\RecordExistsException;
use App\Domain\Records\Services\RecordService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Records\RecordRequest;
use App\Http\Requests\Records\RecordsRequest;
use App\Http\Resources\RecordResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

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
    public function records(RecordsRequest $request): Response
    {
        $data = $request->data();

        $records = $this->recordService->getUserRecords($request->user(), $data);
        $counts = $this->recordService->countUserRecords($request->user());

        return Inertia::render('Portal/Records', [
            'status' => $data->status,
            'records' => RecordResource::collection($records),
            'status_counts' => $counts,
        ]);
    }

    /**
     * Create new record
     */
    public function upload(RecordRequest $request): RedirectResponse
    {
        $data = $request->data();

        try {
            $record = $this->recordService->createRecord($request->user(), $data);

            UploadRecord::dispatch($record);
        } catch (RecordExistsException $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }

        return Redirect::route('records', ['status' => 'processing']);
    }
}
