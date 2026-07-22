<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CheckFileHeaders extends Command
{
    protected $signature = 'astralis:check-headers';
    protected $description = 'Verifica che i file principali abbiano il commento header aggiornato';

    public function handle(): int
    {
        $headers = config('admin.file_headers', []);

        if (empty($headers)) {
            $this->warn('Nessun file_header configurato in config/admin.php');
            return self::SUCCESS;
        }

        $errors = 0;
        $ok = 0;

        foreach ($headers as $relativePath => $expectedComment) {
            $fullPath = base_path($relativePath);

            if (!File::exists($fullPath)) {
                $this->error("❌ {$relativePath} — file non trovato");
                $errors++;
                continue;
            }

            $firstLines = implode('', array_slice(file($fullPath), 0, 5));

            if (str_contains($firstLines, $expectedComment)) {
                $this->info("✅ {$relativePath}");
                $ok++;
            } else {
                $this->newLine();
                $this->error("❌ {$relativePath} — commento mancante o diverso");
                $this->comment("   Atteso: {$expectedComment}");
                $errors++;
            }
        }

        $this->newLine();

        if ($errors > 0) {
            $this->error("⚠️  {$errors} file da aggiornare, {$ok} OK");
            $this->newLine();
            $this->comment('Aggiorna i commenti nei file e in config/admin.php, poi riprova.');
            return self::FAILURE;
        }

        $this->info("🎉 Tutti i {$ok} file hanno il commento corretto.");
        return self::SUCCESS;
    }
}
