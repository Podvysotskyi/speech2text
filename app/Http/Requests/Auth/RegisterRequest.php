<?php

namespace App\Http\Requests\Auth;

use App\Domain\Users\DataValueObjects\Auth\RegisterRequestData;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    public const int RATE_LIMITER_MAX_ATTEMPTS = 5;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return ! RateLimiter::tooManyAttempts(
            'register-attempts:'.$this->ip(),
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
            'name' => 'required|string|min:1|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|max:255',
            'password_confirmation' => 'required|string|same:password',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator): void
    {
        RateLimiter::increment('register-attempts:'.$this->ip());

        parent::failedValidation($validator);
    }

    public function data(): RegisterRequestData
    {
        return new RegisterRequestData(
            name: $this->input('name'),
            email: $this->input('email'),
            password: $this->input('password'),
        );
    }
}
