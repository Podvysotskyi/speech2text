<?php

namespace App\Domain\Users\Services;

use App\Domain\Users\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {
    }

    public function attemptLogin(string $email, string $password, ?Request $request = null): bool
    {
        if (! Auth::attempt(['email' => $email, 'password' => $password])) {
            return false;
        }

        if (! is_null($request)) {
            $request->session()->regenerate();
        }

        return true;
    }

    public function authenticateUser(User $user, ?Request $request = null): void
    {
        Auth::loginUsingId($user->id);

        if (! is_null($request)) {
            $request->session()->regenerate();
        }
    }

    public function logout(?Request $request = null): void
    {
        Auth::logout();

        if (! is_null($request)) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
    }
}
