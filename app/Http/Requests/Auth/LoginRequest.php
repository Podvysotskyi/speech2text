<?php

namespace App\Http\Requests\Auth;

use App\Domain\Users\DataValueObjects\Auth\LoginRequestData;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;

class LoginRequest extends FormRequest
{
    public const int RATE_LIMITER_MAX_ATTEMPTS = 5;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return ! RateLimiter::tooManyAttempts(
            'login-attempts:'.$this->ip(),
            self::RATE_LIMITER_MAX_ATTEMPTS,
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function data(): LoginRequestData
    {
        return new LoginRequestData(
            email: $this->input('email'),
            password: $this->input('password'),
        );
    }
}
