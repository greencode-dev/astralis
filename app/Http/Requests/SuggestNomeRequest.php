<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuggestNomeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['nullable', 'string', 'max:255'],
            'nome_en' => ['nullable', 'string', 'max:255'],
        ];
    }
}
