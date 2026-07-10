<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateMissioneRequest extends StoreMissioneRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['nome'] = [
            'required',
            'string',
            'max:255',
            Rule::unique('missioni', 'nome')->ignore($this->route('missione')),
        ];

        return $rules;
    }
}
