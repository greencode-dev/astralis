<?php
// Dashboard: 4 stat card + 3 grafici Chart.js (donut categorie, barre tipi, barre missioni). Cache 10min

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\CorpoCeleste;
use App\Models\Curiosita;
use App\Models\Missione;
use Illuminate\View\View;

class DashboardController extends Controller
{
    // Index: monta 4 stat card + dati per 3 grafici Chart.js
    public function index(): View
    {
        $this->authorize('viewAny', CorpoCeleste::class);

        // Stat card: conteggi diretti di 4 entità
        $stats = [
            'corpi_celesti' => CorpoCeleste::count(),
            'categorie' => Categoria::count(),
            'missioni' => Missione::count(),
            'curiosita' => Curiosita::count(),
        ];

        // Stat meta: data ultimo creato o breakdown missioni per stato
        $statMeta = [
            'corpi_celesti' => $this->formatLastCreated(CorpoCeleste::class),
            'categorie' => $this->formatLastCreated(Categoria::class),
            'missioni' => $this->formatMissionMeta(),
            'curiosita' => $this->formatLastCreated(Curiosita::class),
        ];

        // Ultimi corpi: 5 più recenti per sidebar "ultimi inserimenti"
        $ultimiCorpi = CorpoCeleste::with('categoria')
            ->latest()
            ->take(5)
            ->get();

        // Donut chart: corpi per categoria (con filter >0)
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

        // Bar chart: corpi per tipo (pianeta, stella, galassia, ecc.)
        $corpiPerTipo = CorpoCeleste::selectRaw('tipo, count(*) as count')
            ->whereNotNull('tipo')
            ->groupBy('tipo')
            ->orderByDesc('count')
            ->get();

        // Bar chart: missioni per stato (Completata/In corso/Pianificata), default 0
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

    // Helper: formatta "Ultimo: GG/MM/YYYY"
    private function formatLastCreated(string $model): ?string
    {
        $latest = $model::latest('created_at')->value('created_at');

        return $latest ? 'Ultimo: ' . $latest->format('d/m/Y') : null;
    }

    // Helper: formatta "X completate, Y in corso, Z pianificate"
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
