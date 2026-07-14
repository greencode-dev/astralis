<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MissioneResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'slug' => $this->slug,
            'logo_url' => $this->logo
                ? (str_starts_with($this->logo, 'http')
                    ? $this->logo
                    : Storage::url('missioni/' . $this->logo))
                : null,
            'agenzia' => $this->agenzia,
            'data_lancio' => $this->data_lancio?->format('Y-m-d'),
            'durata_giorni' => $this->durata_giorni,
            'stato' => $this->stato,
            'descrizione' => $this->descrizione,
            'sito_web' => $this->sito_web,
            'pivot' => $this->whenPivotLoaded('corpo_celeste_missione', fn () => [
                'tipo_esplorazione' => $this->pivot->tipo_esplorazione,
                'anno_arrivo' => $this->pivot->anno_arrivo,
            ]),
            'corpi_celesti' => CorpoCelesteResource::collection($this->whenLoaded('corpiCelesti')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
