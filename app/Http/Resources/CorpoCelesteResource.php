<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CorpoCelesteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'nome_display' => $this->nome_display,
            'slug' => $this->slug,
            'categoria' => new CategoriaResource($this->whenLoaded('categoria')),
            'immagine_url' => $this->immagine_url,
            'descrizione' => $this->descrizione,
            'tipo' => $this->tipo,
            'massa_kg' => $this->massa_kg,
            'distanza_km' => $this->distanza_km,
            'diametro_km' => $this->diametro_km,
            'gravita' => $this->gravita,
            'temperatura' => $this->temperatura,
            'periodo_orbitale' => $this->periodo_orbitale,
            'scopritore' => $this->scopritore,
            'anno_scoperta' => $this->anno_scoperta,
            'in_evidenza' => $this->in_evidenza,
            'nasa_id' => $this->nasa_id,
            'galleria' => GalleriaCorpoResource::collection($this->whenLoaded('galleria')),
            'curiosita' => CuriositaResource::collection($this->whenLoaded('curiosita')),
            'missioni' => MissioneResource::collection($this->whenLoaded('missioni')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
