<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class GalleriaCorpoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'corpo_celeste_id' => $this->corpo_celeste_id,
            'immagine_url' => Storage::url('galleria/' . $this->percorso),
            'didascalia' => $this->didascalia,
            'crediti' => $this->crediti,
            'ordine' => $this->ordine,
            'corpo_celeste' => new CorpoCelesteResource($this->whenLoaded('corpoCeleste')),
        ];
    }
}
