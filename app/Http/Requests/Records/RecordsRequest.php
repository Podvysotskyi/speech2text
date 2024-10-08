<?php

namespace App\Http\Requests\Records;

use App\Domain\Records\DataValueObjects\Requests\RecordsRequestData;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RecordsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'filled|string',
        ];
    }

    public function data(): RecordsRequestData
    {
        return new RecordsRequestData(
            status: $this->input('status'),
        );
    }
}
