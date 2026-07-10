<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\CorpoCeleste;
use App\Models\Missione;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        $data = Cache::remember('api.dashboard.stats', 3600, function () {
            return [
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
                'missioni_per_stato' => Missione::selectRaw("
                        SUM(CASE WHEN stato = 'Completata' THEN 1 ELSE 0 END) as completate,
                        SUM(CASE WHEN stato = 'In corso' THEN 1 ELSE 0 END) as in_corso,
                        SUM(CASE WHEN stato = 'Pianificata' THEN 1 ELSE 0 END) as pianificate
                    ")->first(),
            ];
        });

        return response()->json($data);
    }
}
