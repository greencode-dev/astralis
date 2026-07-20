<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCorpoCelesteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255', 'unique:corpi_celesti,nome'],
            'nome_it' => ['nullable', 'string', 'max:255'],
            'categoria_id' => ['required', 'exists:categorie,id'],
            'immagine' => ['nullable', 'string', 'max:2047'],
            'descrizione' => ['nullable', 'string', 'max:5000'],
            'tipo' => ['nullable', 'string', 'max:50'],
            'massa_kg' => ['nullable', 'string', 'max:50'],
            'distanza_km' => ['nullable', 'string', 'max:50'],
            'diametro_km' => ['nullable', 'string', 'max:50'],
            'gravita' => ['nullable', 'numeric', 'max:999999'],
            'temperatura' => ['nullable', 'numeric', 'max:999999'],
            'periodo_orbitale' => ['nullable', 'numeric', 'max:999999'],
            'scopritore' => ['nullable', 'string', 'max:100'],
            'anno_scoperta' => ['nullable', 'integer', 'min:-5000', 'max:3000'],
            'in_evidenza' => ['nullable', 'boolean'],
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge([
            'in_evidenza' => $this->boolean('in_evidenza'),
        ]);
    }
}
