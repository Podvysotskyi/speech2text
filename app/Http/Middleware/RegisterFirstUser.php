<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RegisterFirstUser
{
    protected string $redirectTo = 'register';

    public function __construct(
        protected UserService $userService,
    ) {
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $userCount = $this->userService->getUserCount();

        if ($userCount === 0) {
            return Redirect::route($this->redirectTo);
        }

        return $next($request);
    }
}
