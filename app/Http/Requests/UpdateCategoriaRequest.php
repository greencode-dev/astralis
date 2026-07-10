<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateCategoriaRequest extends StoreCategoriaRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['nome'] = [
            'required',
            'string',
            'max:255',
            Rule::unique('categorie', 'nome')->ignore($this->route('categoria')),
        ];

        return $rules;
    }
}
