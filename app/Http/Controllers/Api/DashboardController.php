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
            $corpiCelesti = CorpoCeleste::select('corpi_celesti.*', 'categorie.nome as categoria_nome')
                ->join('categorie', 'corpi_celesti.categoria_id', '=', 'categorie.id')
                ->orderBy('corpi_celesti.created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function ($corpo) {
                    return [
                        'id' => $corpo->id,
                        'nome' => $corpo->nome,
                        'slug' => $corpo->slug,
                        'categoria' => $corpo->categoria_nome,
                        'tipo' => $corpo->tipo,
                    ];
                });

            $missionStats = Missione::selectRaw(
                'COUNT(*) as total, '
                . 'SUM(CASE WHEN stato = \'Completata\' THEN 1 ELSE 0 END) as completate, '
                . 'SUM(CASE WHEN stato = \'In corso\' THEN 1 ELSE 0 END) as in_corso, '
                . 'SUM(CASE WHEN stato = \'Pianificata\' THEN 1 ELSE 0 END) as pianificate'
            )->first();

            $evidenzaCount = (int) CorpoCeleste::where('in_evidenza', true)->count();

            return [
                'totale_corpi_celesti' => (int) CorpoCeleste::count(),
                'totale_categorie' => (int) Categoria::count(),
                'totale_missioni' => (int) Missione::count(),
                'corpi_in_evidenza' => $evidenzaCount,
                'ultimi_corpi' => $corpiCelesti,
                'missioni_per_stato' => [
                    'total' => (int) ($missionStats->total ?? 0),
                    'completate' => (int) ($missionStats->completate ?? 0),
                    'in_corso' => (int) ($missionStats->in_corso ?? 0),
                    'pianificate' => (int) ($missionStats->pianificate ?? 0),
                ],
            ];
        });

        return response()->json($data);
    }
}
