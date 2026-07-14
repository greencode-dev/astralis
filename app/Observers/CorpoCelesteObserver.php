<?php

namespace App\Observers;

use App\Models\CorpoCeleste;
use App\Jobs\ImportNasaImage;

class CorpoCelesteObserver
{
    public function created(CorpoCeleste $corpo): void
    {
        if (app()->environment('testing')) {
            return;
        }

        ImportNasaImage::dispatch($corpo, galleryCount: 5);
    }
}
