<?php

namespace App\Console\Commands;

use App\Models\GalleriaCorpo;
use App\Services\NasaImageService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CleanupGalleryDuplicates extends Command
{
    protected $signature = 'astralis:gallery
        {--dry-run : Mostra le operazioni senza eseguirle}
        {--check : Controlla immagini non raggiungibili (solo report)}
        {--clean : Elimina i record con immagini non raggiungibili}
        {--sync : Sostituisce immagini non raggiungibili con nuove da NASA}
        {--fix : Scorciatoia per --sync --clean}
        {--trim= : Mantieni al massimo N immagini per corpo celeste}';

    protected $description = 'Rimuove duplicati, file orfani e gestisce immagini non raggiungibili (URL remoti o file locali mancanti)';

    public function __construct(
        private NasaImageService $nasaService,
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $onlyCheck = $this->option('check')
            && !$this->option('clean')
            && !$this->option('sync')
            && !$this->option('fix');

        if ($onlyCheck && $this->option('dry-run')) {
            $this->warn('--check è di sola lettura, --dry-run non è necessario.');
        }

        $this->cleanOrphanedFiles();

        $hasBrokenAction = $this->option('check')
            || $this->option('clean')
            || $this->option('sync')
            || $this->option('fix');

        if ($hasBrokenAction) {
            $this->handleBrokenUrls();
        }

        $this->removeDuplicates();
        $this->removeCrossTableDuplicates();

        if ($this->option('trim')) {
            $this->trimGalleries((int) $this->option('trim') + 2);
        }

        $this->removeNasaIdDuplicates();

        if ($this->option('trim')) {
            $this->trimGalleries((int) $this->option('trim'));
        }

        if (!$this->option('dry-run')) {
            $this->resequenceOrdine();
        }

        $this->newLine();
        $this->info('Operazione completata.');
    }

    private function removeDuplicates(): void
    {
        $this->info('Ricerca duplicati in galleria_corpi...');

        $duplicates = GalleriaCorpo::selectRaw('MIN(id) as keep_id, corpo_celeste_id, percorso, COUNT(*) as cnt')
            ->groupBy('corpo_celeste_id', 'percorso')
            ->having('cnt', '>', 1)
            ->get();

        if ($duplicates->isEmpty()) {
            $this->warn('Nessun duplicato trovato.');
            return;
        }

        $this->line("Trovati {$duplicates->count()} gruppi di duplicati.");

        $deleted = 0;
        foreach ($duplicates as $dup) {
            $toDelete = GalleriaCorpo::where('corpo_celeste_id', $dup->corpo_celeste_id)
                ->where('percorso', $dup->percorso)
                ->where('id', '!=', $dup->keep_id)
                ->get();

            foreach ($toDelete as $item) {
                $this->line("  Elimino #{$item->id} (duplicato di #{$dup->keep_id}, corpo: {$item->corpo_celeste_id})");
                if (!$this->option('dry-run')) {
                    $item->delete();
                }
                $deleted++;
            }
        }

        $this->info("Eliminati {$deleted} duplicati" . ($this->option('dry-run') ? ' (dry-run)' : '.'));
    }

    private function removeCrossTableDuplicates(): void
    {
        $this->info('Ricerca duplicati cross-table (galleria vs immagine principale)...');

        $crossDups = GalleriaCorpo::whereHas('corpoCeleste', function ($query) {
            $query->where('corpi_celesti.immagine', '!=', '')
                ->whereColumn('corpi_celesti.immagine', '=', 'galleria_corpi.percorso');
        })->get();

        if ($crossDups->isEmpty()) {
            $this->warn('Nessun duplicato cross-table trovato.');
            return;
        }

        $this->line("Trovati {$crossDups->count()} record da eliminare.");

        $deleted = 0;
        foreach ($crossDups as $item) {
            $this->line("  Elimino #{$item->id} (galleria duplica immagine principale di corpo: {$item->corpo_celeste_id})");
            if (!$this->option('dry-run')) {
                $item->delete();
            }
            $deleted++;
        }

        $this->info("Eliminati {$deleted} duplicati cross-table" . ($this->option('dry-run') ? ' (dry-run)' : '.'));
    }

    private function removeNasaIdDuplicates(): void
    {
        $this->info('Ricerca duplicati per NASA ID (stessa immagine, size diverse)...');

        $bodies = GalleriaCorpo::select('corpo_celeste_id')
            ->selectRaw('COUNT(*) as cnt')
            ->groupBy('corpo_celeste_id')
            ->having('cnt', '>', 1)
            ->get();

        $deleted = 0;
        foreach ($bodies as $body) {
            $items = GalleriaCorpo::where('corpo_celeste_id', $body->corpo_celeste_id)
                ->orderBy('ordine')
                ->get();

            $seen = [];
            foreach ($items as $item) {
                $baseId = strtok(basename($item->percorso), '~');
                if (!$baseId) {
                    continue;
                }
                if (in_array($baseId, $seen, true)) {
                    $this->line("  Elimino #{$item->id} (NASA ID {$baseId} già presente per corpo: {$body->corpo_celeste_id})");
                    if (!$this->option('dry-run')) {
                        $item->delete();
                    }
                    $deleted++;
                    continue;
                }
                $seen[] = $baseId;
            }
        }

        if ($deleted === 0) {
            $this->warn('Nessun duplicato NASA ID trovato.');
            return;
        }

        $this->info("Eliminati {$deleted} duplicati NASA ID" . ($this->option('dry-run') ? ' (dry-run)' : '.'));
    }

    private function resequenceOrdine(): void
    {
        $bodies = GalleriaCorpo::select('corpo_celeste_id')
            ->selectRaw('COUNT(*) as cnt')
            ->groupBy('corpo_celeste_id')
            ->get();

        foreach ($bodies as $body) {
            $items = GalleriaCorpo::where('corpo_celeste_id', $body->corpo_celeste_id)
                ->orderBy('id')
                ->get();
            foreach ($items as $i => $item) {
                if ($item->ordine !== $i) {
                    $item->update(['ordine' => $i]);
                }
            }
        }
    }

    private function trimGalleries(int $max): void
    {
        $this->info("Ritaglio gallerie a massimo {$max} immagini per corpo...");

        $bodies = GalleriaCorpo::select('corpo_celeste_id')
            ->selectRaw('COUNT(*) as cnt')
            ->groupBy('corpo_celeste_id')
            ->having('cnt', '>', $max)
            ->get();

        if ($bodies->isEmpty()) {
            $this->warn('Nessuna galleria supera il limite.');
            return;
        }

        $deleted = 0;
        foreach ($bodies as $body) {
            $corpo = $body->corpoCeleste;
            $keepIds = GalleriaCorpo::where('corpo_celeste_id', $body->corpo_celeste_id)
                ->orderBy('ordine')
                ->limit($max)
                ->pluck('id');

            $excess = GalleriaCorpo::where('corpo_celeste_id', $body->corpo_celeste_id)
                ->whereNotIn('id', $keepIds)
                ->get();

            $this->line("  {$corpo->nome}: {$body->cnt} → {$max} (elimino " . $excess->count() . ")");

            if (!$this->option('dry-run')) {
                foreach ($excess as $item) {
                    $item->delete();
                }

                $remaining = GalleriaCorpo::where('corpo_celeste_id', $body->corpo_celeste_id)
                    ->orderBy('id')
                    ->get();
                foreach ($remaining as $i => $item) {
                    if ($item->ordine !== $i) {
                        $item->update(['ordine' => $i]);
                    }
                }
            }
            $deleted += $excess->count();
        }

        $this->info("Eliminati {$deleted} record in eccesso" . ($this->option('dry-run') ? ' (dry-run)' : '.'));
    }

    private function cleanOrphanedFiles(): void
    {
        $this->info('Controllo file orfani su disco...');

        $validFiles = GalleriaCorpo::where('percorso', 'not like', 'http%')
            ->pluck('percorso')
            ->toArray();

        $diskFiles = Storage::disk('public')->files('galleria');

        $orphans = array_diff($diskFiles, array_map(fn($p) => "galleria/{$p}", $validFiles));

        if (empty($orphans)) {
            $this->warn('Nessun file orfano trovato.');
            return;
        }

        $this->line("Trovati " . count($orphans) . " file orfani.");
        foreach ($orphans as $file) {
            $this->line("  Elimino: {$file}");
            if (!$this->option('dry-run')) {
                Storage::disk('public')->delete($file);
            }
        }
    }

    private function handleBrokenUrls(): void
    {
        $check = $this->option('check');
        $clean = $this->option('clean') || $this->option('fix');
        $sync = $this->option('sync') || $this->option('fix');
        $dryRun = $this->option('dry-run');

        $this->info('Verifica integrità immagini (URL remoti e file locali)...');

        $records = GalleriaCorpo::with('corpoCeleste')->get();

        if ($records->isEmpty()) {
            $this->warn('Nessuna immagine in galleria.');
            return;
        }

        $ok = 0;
        $brokenCount = 0;
        $syncCount = 0;
        $cleanCount = 0;

        foreach ($records as $item) {
            $label = "  #{$item->id} ({$item->corpoCeleste->nome})";

            if (str_starts_with($item->percorso, 'http')) {
                $status = $this->headRequest($item->percorso);
                $isBroken = ($status >= 400 || $status === 0);
                $reason = $isBroken ? "HTTP {$status}" : null;
            } else {
                $exists = Storage::disk('public')->exists('galleria/' . $item->percorso);
                $isBroken = !$exists;
                $reason = $isBroken ? 'file mancante su disco' : null;
            }

            if (!$isBroken) {
                $this->line("{$label} OK");
                $ok++;
                continue;
            }

            $this->warn("{$label} KO ({$reason})");
            $brokenCount++;

            if ($sync) {
                $replaced = $this->handleSync($item, $dryRun);
                if ($replaced) {
                    $this->info("    sostituita.");
                    $syncCount++;
                    continue;
                }
            }

            if ($clean) {
                $this->handleDelete($item, $dryRun);
                $cleanCount++;
            }
        }

        $this->newLine();
        $formatted = ["<info>OK: {$ok}</info>", "<comment>KO: {$brokenCount}</comment>"];
        if ($syncCount) {
            $formatted[] = "<fg=blue>sincronizzati: {$syncCount}</fg=blue>";
        }
        if ($cleanCount) {
            $formatted[] = "<fg=red>eliminati: {$cleanCount}</fg=red>";
        }
        $this->line(implode(', ', $formatted));
    }

    private function headRequest(string $url): int
    {
        $http = Http::timeout(5);
        if (app()->environment('local', 'testing')) {
            $http = $http->withoutVerifying();
        }

        try {
            return $http->head($url)->status();
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function handleSync(GalleriaCorpo $item, bool $dryRun): bool
    {
        $corpo = $item->corpoCeleste;

        if (!$corpo) {
            return false;
        }

        $this->output->write("    Cerco sostituto su NASA... ");

        $searchResult = $this->nasaService->searchNasa($corpo->nome);

        if (!$searchResult['success']) {
            $this->warn("nessuna sostituzione trovata.");
            return false;
        }

        foreach ($searchResult['items'] as $nasaItem) {
            $imageUrl = $this->nasaService->pickMainImageUrl($nasaItem);
            if (!$imageUrl) {
                continue;
            }

            if (str_starts_with($item->percorso, 'http') && $imageUrl === $item->percorso) {
                continue;
            }

            $alreadyExists = GalleriaCorpo::where('corpo_celeste_id', $item->corpo_celeste_id)
                ->where('percorso', $imageUrl)
                ->where('id', '!=', $item->id)
                ->exists();

            if ($alreadyExists) {
                $this->warn("URL già esistente per questo corpo, elimino il record rotto.");
                if (!$dryRun) {
                    if (!str_starts_with($item->percorso, 'http')) {
                        Storage::disk('public')->delete('galleria/' . $item->percorso);
                    }
                    $item->delete();
                }
                return true;
            }

            $metadata = $this->nasaService->extractMetadata($nasaItem);

            if (!$dryRun) {
                if (!str_starts_with($item->percorso, 'http')) {
                    Storage::disk('public')->delete('galleria/' . $item->percorso);
                }

                $item->update([
                    'percorso' => $imageUrl,
                    'didascalia' => $metadata['title'],
                    'crediti' => $metadata['photographer'],
                ]);
            }

            return true;
        }

        $this->warn("nessuna sostituzione trovata.");
        return false;
    }

    private function handleDelete(GalleriaCorpo $item, bool $dryRun): void
    {
        $this->line("    Elimino record #{$item->id}.");
        if (!$dryRun) {
            if (!str_starts_with($item->percorso, 'http')) {
                Storage::disk('public')->delete('galleria/' . $item->percorso);
            }
            $item->delete();
        }
    }
}
