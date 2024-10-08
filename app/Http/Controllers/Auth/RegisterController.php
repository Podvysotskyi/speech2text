<?php

namespace App\Http\Controllers\Auth;

use App\Domain\Users\Services\AuthService;
use App\Domain\Users\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class RegisterController extends Controller implements HasMiddleware
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected UserService $userService,
        protected AuthService $authService,
    ) {
    }

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'guest',
        ];
    }

    /**
     * Show register page
     */
    public function show(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle register request
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $data = $request->data();
        $user = $this->userService->createUser($data);

        $this->authService->authenticateUser($user, $request);

        RateLimiter::clear('register-attempts:'.$request->ip());

        return Redirect::route('home');
    }
}
