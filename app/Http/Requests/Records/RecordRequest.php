<?php

namespace App\Http\Requests\Records;

use App\Domain\Records\DataValueObjects\Requests\RecordRequestData;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RecordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'record' => 'required|file',
        ];
    }

    public function data(): RecordRequestData
    {
        return new RecordRequestData(
            file: $this->file('record'),
        );
    }
}
