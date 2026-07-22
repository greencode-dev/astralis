<?php
// Observer: created() dispatcha ImportNasaImage job. Skip in testing via app()->environment('testing')

namespace App\Observers;

use App\Models\CorpoCeleste;
use App\Jobs\ImportNasaImage;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;

class CorpoCelesteObserver implements ShouldDispatchAfterCommit
{
    // created(): dispatcha import NASA automatico (skip in testing)
    public function created(CorpoCeleste $corpo): void
    {
        if (app()->environment('testing')) {
            return;
        }

        ImportNasaImage::dispatch($corpo, galleryCount: 5);
    }
}
