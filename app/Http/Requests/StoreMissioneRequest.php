<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMissioneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255', 'unique:missioni,nome'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:1024'],
            'agenzia' => ['nullable', 'string', 'max:100'],
            'data_lancio' => ['nullable', 'date'],
            'durata_giorni' => ['nullable', 'integer', 'min:0'],
            'stato' => ['nullable', 'string', 'max:50'],
            'descrizione' => ['nullable', 'string', 'max:5000'],
            'sito_web' => ['nullable', 'string', 'url', 'max:255'],
        ];
    }
}
