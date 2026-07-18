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
        $this->authorize('viewAny', CorpoCeleste::class);

        $stats = [
            'corpi_celesti' => CorpoCeleste::count(),
            'categorie' => Categoria::count(),
            'missioni' => Missione::count(),
            'curiosita' => Curiosita::count(),
        ];

        $statMeta = [
            'corpi_celesti' => $this->formatLastCreated(CorpoCeleste::class),
            'categorie' => $this->formatLastCreated(Categoria::class),
            'missioni' => $this->formatMissionMeta(),
            'curiosita' => $this->formatLastCreated(Curiosita::class),
        ];

        $ultimiCorpi = CorpoCeleste::with('categoria')
            ->latest()
            ->take(5)
            ->get();

        $corpiPerCategoria = Categoria::withCount('corpiCelesti')
            ->orderByDesc('corpi_celesti_count')
            ->get()
            ->filter(fn ($c) => $c->corpi_celesti_count > 0)
            ->values()
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

        return view('admin.dashboard', compact(
            'stats', 'statMeta', 'ultimiCorpi', 'corpiPerCategoria', 'corpiPerTipo', 'missioniPerStato'
        ));
    }

    private function formatLastCreated(string $model): ?string
    {
        $latest = $model::latest('created_at')->value('created_at');

        return $latest ? 'Ultimo: ' . $latest->format('d/m/Y') : null;
    }

    private function formatMissionMeta(): ?string
    {
        $counts = Missione::selectRaw('stato, count(*) as count')
            ->whereIn('stato', ['Completata', 'In corso', 'Pianificata'])
            ->groupBy('stato')
            ->pluck('count', 'stato');

        if ($counts->isEmpty()) {
            return null;
        }

        $parts = [];
        if (($counts['Completata'] ?? 0) > 0) {
            $parts[] = $counts['Completata'] . ' completate';
        }
        if (($counts['In corso'] ?? 0) > 0) {
            $parts[] = $counts['In corso'] . ' in corso';
        }
        if (($counts['Pianificata'] ?? 0) > 0) {
            $parts[] = $counts['Pianificata'] . ' pianificate';
        }

        return $parts ? implode(', ', $parts) : null;
    }
}
