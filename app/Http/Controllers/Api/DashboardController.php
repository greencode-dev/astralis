<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\CorpoCeleste;
use App\Models\Missione;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        return response()->json([
            'totale_corpi_celesti' => CorpoCeleste::count(),
            'totale_categorie' => Categoria::count(),
            'totale_missioni' => Missione::count(),
            'corpi_in_evidenza' => CorpoCeleste::where('in_evidenza', true)->count(),
            'ultimi_corpi' => CorpoCeleste::with('categoria')
                ->latest()
                ->take(5)
                ->get()
                ->map(fn ($c) => [
                    'id' => $c->id,
                    'nome' => $c->nome,
                    'slug' => $c->slug,
                    'categoria' => $c->categoria?->nome,
                    'tipo' => $c->tipo,
                ]),
            'missioni_per_stato' => [
                'completate' => Missione::where('stato', 'Completata')->count(),
                'in_corso' => Missione::where('stato', 'In corso')->count(),
                'pianificate' => Missione::where('stato', 'Pianificata')->count(),
            ],
        ]);
    }
}
