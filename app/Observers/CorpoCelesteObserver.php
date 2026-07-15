<?php

namespace App\Observers;

use App\Models\CorpoCeleste;
use App\Jobs\ImportNasaImage;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;

class CorpoCelesteObserver implements ShouldDispatchAfterCommit
{
    public function created(CorpoCeleste $corpo): void
    {
        if (app()->environment('testing')) {
            return;
        }

        ImportNasaImage::dispatch($corpo, galleryCount: 5);
    }
}
