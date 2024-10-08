<?php

namespace App\Http\Controllers\Auth;

use App\Domain\Users\Services\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Redirect;

class LogoutController extends Controller implements HasMiddleware
{
    public const string redirect_route = 'welcome';

    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected AuthService $authService,
    ) {
    }

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->authService->logout($request);

        return Redirect::route(self::redirect_route);
    }
}
