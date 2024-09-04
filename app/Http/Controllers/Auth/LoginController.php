<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RegisterFirstUser;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller implements HasMiddleware
{
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
            'guest',
            RegisterFirstUser::class,
        ];
    }

    /**
     * Show login page
     */
    public function show(): Response|RedirectResponse
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Handle login request
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $data = $request->data();

        if ($this->authService->attemptLogin($data->name, $data->password, $request)) {
            RateLimiter::clear('login-attempts:'.$request->ip());

            return Redirect::route('home');
        }

        RateLimiter::increment('login-attempts:'.$request->ip());

        return Redirect::back()->withErrors([
            'name' => __('auth.failed'),
        ]);
    }
}
