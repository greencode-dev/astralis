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
            'nome_it' => ['nullable', 'string', 'max:255'],
            'nome' => ['nullable', 'string', 'max:255'],
        ];
    }
}
