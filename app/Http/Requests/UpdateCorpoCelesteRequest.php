<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateCorpoCelesteRequest extends StoreCorpoCelesteRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['nome'] = [
            'required',
            'string',
            'max:255',
            Rule::unique('corpi_celesti', 'nome')->ignore($this->route('corpoCeleste')),
        ];

        return $rules;
    }
}
