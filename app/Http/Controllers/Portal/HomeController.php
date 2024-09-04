<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    /**
     * Show home page.
     */
    public function __invoke(): Response
    {
        return Inertia::render('Portal/Home');
    }
}
