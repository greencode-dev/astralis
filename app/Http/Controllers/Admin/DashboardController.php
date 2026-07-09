<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\CorpoCeleste;
use App\Models\Curiosita;
use App\Models\Missione;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
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

        $missioniPerStato = [
            'Completata' => Missione::where('stato', 'Completata')->count(),
            'In corso' => Missione::where('stato', 'In corso')->count(),
            'Pianificata' => Missione::where('stato', 'Pianificata')->count(),
        ];

        return view('admin.dashboard', compact(
            'stats', 'ultimiCorpi', 'corpiPerCategoria', 'corpiPerTipo', 'missioniPerStato'
        ));
    }
}
