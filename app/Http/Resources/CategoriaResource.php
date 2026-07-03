<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'slug' => $this->slug,
            'icona' => $this->icona,
            'descrizione' => $this->descrizione,
            'colore' => $this->colore,
            'corpi_count' => $this->whenCounted('corpiCelesti'),
            'corpi_celesti' => CorpoCelesteResource::collection($this->whenLoaded('corpiCelesti')),
        ];
    }
}
