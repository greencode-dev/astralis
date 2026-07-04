<?php

namespace App\Console\Commands;

use App\Services\NasaImageService;
use Illuminate\Console\Command;

class FetchNasaCommand extends Command
{
    protected $signature = 'astralis:fetch-nasa
        {--force : Sovrascrive immagini esistenti}
        {--gallery=5 : Numero di immagini galleria per corpo celeste}
        {--update-description : Aggiorna la descrizione del corpo con i metadati NASA}';

    protected $description = 'Scarica immagini da NASA API per tutti i corpi celesti';

    public function handle(NasaImageService $service): int
    {
        $force = $this->option('force');
        $galleryCount = (int) $this->option('gallery');
        $updateDescription = $this->option('update-description');

        $this->line('🌌 Astralis — NASA Image Fetch');
        $this->line(str_repeat('─', 60));

        $this->line("Gallery: {$galleryCount} immagini per corpo");
        $this->line("Modalità: " . ($force ? 'FORCE (sovrascrivi)' : 'Normale (skip esistenti)'));
        if ($updateDescription) {
            $this->line('Aggiornamento descrizioni: ✅');
        }
        $this->line('');

        $result = $service->importAll(
            galleryCount: $galleryCount,
            force: $force,
            updateDescription: $updateDescription,
        );

        $this->line('');
        $this->line('📊 Riepilogo');
        $this->line(str_repeat('─', 60));
        $this->line("Corpi processati:    {$result['total']}");
        $this->line("Immagini principali: {$result['total_main']}/{$result['total']}");
        $this->line("Immagini galleria:   {$result['total_gallery']}");
        $this->line("Successi:            {$result['success']}");
        $this->line(str_repeat('─', 60));

        $failed = $result['total'] - $result['success'];
        if ($failed > 0) {
            $this->warn("{$failed} corpi con errori:");
            foreach ($result['results'] as $r) {
                if (!$r['success'] && !empty($r['message'])) {
                    $this->warn("  • {$r['message']}");
                }
                if (!empty($r['errors'])) {
                    foreach ($r['errors'] as $err) {
                        $this->warn("  • {$err}");
                    }
                }
            }
        }

        $this->line('');
        $this->info('✅ Import completato.');

        return Command::SUCCESS;
    }
}
