<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {
    }

    public function attemptLogin(string $name, string $password, ?Request $request = null): bool
    {
        if (! Auth::attempt(['name' => $name, 'password' => $password])) {
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
