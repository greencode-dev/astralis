<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CuriositaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'corpo_celeste_id' => $this->corpo_celeste_id,
            'titolo' => $this->titolo,
            'descrizione' => $this->descrizione,
            'fonte' => $this->fonte,
            'corpo_celeste' => new CorpoCelesteResource($this->whenLoaded('corpoCeleste')),
        ];
    }
}
