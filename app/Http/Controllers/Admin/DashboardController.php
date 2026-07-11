<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\CorpoCeleste;
use App\Models\Curiosita;
use App\Models\Missione;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', CorpoCeleste::class);
        $data = Cache::remember('admin.dashboard', 3600, function () {
            $stats = [
                'corpi_celesti' => CorpoCeleste::count(),
                'categorie' => Categoria::count(),
                'missioni' => Missione::count(),
                'curiosita' => Curiosita::count(),
            ];

            $ultimiCorpi = CorpoCeleste::with('categoria')
                ->latest()
                ->take(5)
                ->get();

            $corpiPerCategoria = Categoria::withCount('corpiCelesti')
                ->having('corpi_celesti_count', '>', 0)
                ->orderByDesc('corpi_celesti_count')
                ->get()
                ->map(fn ($c) => [
                    'nome' => $c->nome,
                    'colore' => $c->colore,
                    'count' => $c->corpi_celesti_count,
                ]);

            $corpiPerTipo = CorpoCeleste::selectRaw('tipo, count(*) as count')
                ->whereNotNull('tipo')
                ->groupBy('tipo')
                ->orderByDesc('count')
                ->get();

            $missioniPerStato = Missione::selectRaw('stato, count(*) as count')
                ->whereIn('stato', ['Completata', 'In corso', 'Pianificata'])
                ->groupBy('stato')
                ->get()
                ->keyBy('stato')
                ->map(fn ($m) => $m->count)
                ->toArray();

            $missioniPerStato = array_merge([
                'Completata' => 0,
                'In corso' => 0,
                'Pianificata' => 0,
            ], $missioniPerStato);

            return compact(
                'stats', 'ultimiCorpi', 'corpiPerCategoria', 'corpiPerTipo', 'missioniPerStato'
            );
        });

        return view('admin.dashboard', $data);
    }
}
