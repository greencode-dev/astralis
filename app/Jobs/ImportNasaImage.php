<?php
// Job queue: importa immagini NASA. ShouldBeUnique, timeout 60s, 3 retry. Dispatchato da Observer

namespace App\Jobs;

use App\Models\CorpoCeleste;
use App\Services\NasaImageService;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class ImportNasaImage implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Config: 3 tentativi, timeout 60s
    public int $tries = 3;

    public int $timeout = 60;

    // Constructor: corpo (serializzato), galleryCount, force flag
    public function __construct(
        public CorpoCeleste $corpo,
        public int $galleryCount = 5,
        public bool $force = false,
    ) {}

    // uniqueId: ID del corpo → previene job duplicati nella coda
    public function uniqueId(): mixed
    {
        return $this->corpo->id;
    }

    // handle: chiama NasaImageService→importForBody + invalida cache dashboard
    public function handle(NasaImageService $nasaService): void
    {
        if (app()->environment('testing')) {
            return;
        }

        $nasaService->importForBody($this->corpo, $this->galleryCount, $this->force);

        Cache::forget('api.dashboard.stats');
    }

    // failed: log errore con nome corpo
    public function failed(Throwable $e): void
    {
        Log::error("NASA import fallito per {$this->corpo->nome}: {$e->getMessage()}");
    }
}
