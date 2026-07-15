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
        {--fix : Scorciatoia per --sync --clean}';

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

        $this->removeDuplicates();
        $this->cleanOrphanedFiles();

        $hasBrokenAction = $this->option('check')
            || $this->option('clean')
            || $this->option('sync')
            || $this->option('fix');

        if ($hasBrokenAction) {
            $this->handleBrokenUrls();
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
            $imageUrl = $this->nasaService->pickImageUrl($nasaItem);
            if (!$imageUrl) {
                continue;
            }

            if (str_starts_with($item->percorso, 'http') && $imageUrl === $item->percorso) {
                continue;
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
