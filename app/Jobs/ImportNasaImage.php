<?php

namespace App\Jobs;

use App\Models\CorpoCeleste;
use App\Services\NasaImageService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportNasaImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public CorpoCeleste $corpo,
        public int $galleryCount = 3,
        public bool $force = true,
    ) {}

    public function handle(NasaImageService $nasaService): void
    {
        if (app()->environment('testing')) {
            return;
        }

        $nasaService->importForBody($this->corpo, $this->galleryCount, $this->force);
    }
}
