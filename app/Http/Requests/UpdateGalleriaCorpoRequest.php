<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGalleriaCorpoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'corpo_celeste_id' => ['required', 'exists:corpi_celesti,id'],
            'percorso' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'didascalia' => ['nullable', 'string', 'max:500'],
            'crediti' => ['nullable', 'string', 'max:255'],
            'ordine' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }
}
