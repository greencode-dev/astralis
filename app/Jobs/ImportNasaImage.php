<?php

namespace App\Jobs;

use App\Models\CorpoCeleste;
use App\Services\NasaImageService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class ImportNasaImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 120;

    public function __construct(
        public CorpoCeleste $corpo,
        public int $galleryCount = 5,
        public bool $force = true,
    ) {}

    public function handle(NasaImageService $nasaService): void
    {
        if (app()->environment('testing')) {
            return;
        }

        $nasaService->importForBody($this->corpo, $this->galleryCount, $this->force);

        Cache::forget('api.dashboard.stats');
    }

    public function failed(Throwable $e): void
    {
        Log::error("NASA import fallito per {$this->corpo->nome}: {$e->getMessage()}");
    }
}
