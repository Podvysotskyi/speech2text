<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Records\RecordRequest;
use App\Http\Requests\Records\RecordsRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class RecordsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    /**
     * Show all records page.
     */
    public function all(RecordsRequest $request): Response
    {
        $data = $request->data();

        return Inertia::render('Portal/Records', [
            'status' => $data->status,
        ]);
    }

    public function upload(RecordRequest $request): RedirectResponse
    {
        $data = $request->data();

        return Redirect::route('records', ['status' => 'processing']);
    }
}
