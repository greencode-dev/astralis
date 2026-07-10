<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCuriositaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'corpo_celeste_id' => ['required', 'exists:corpi_celesti,id'],
            'titolo' => ['required', 'string', 'max:255'],
            'descrizione' => ['required', 'string', 'max:5000'],
            'fonte' => ['nullable', 'string', 'max:255'],
        ];
    }
}
