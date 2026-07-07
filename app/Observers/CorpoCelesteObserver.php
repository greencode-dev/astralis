<?php

namespace App\Observers;

use App\Models\CorpoCeleste;
use App\Services\NasaImageService;

class CorpoCelesteObserver
{
    public function __construct(
        private NasaImageService $nasaService,
    ) {}

    public function created(CorpoCeleste $corpo): void
    {
        $this->nasaService->importForBody($corpo, galleryCount: 3, force: true);
    }
}
