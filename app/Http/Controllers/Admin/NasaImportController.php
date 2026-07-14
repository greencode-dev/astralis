<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CorpoCeleste;
use App\Jobs\ImportNasaImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Bus;
use Illuminate\View\View;

class NasaImportController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', CorpoCeleste::class);

        $corpi = CorpoCeleste::with('categoria')
            ->orderBy('nome')
            ->paginate(20)
            ->withQueryString();

        return view('admin.nasa-import.index', compact('corpi'));
    }

    public function import(CorpoCeleste $corpoCeleste): RedirectResponse
    {
        $this->authorize('update', $corpoCeleste);

        ImportNasaImage::dispatch($corpoCeleste);

        return redirect()->route('admin.nasa-import.index')
            ->with('success', "Importazione NASA per {$corpoCeleste->nome} accodata.");
    }

    public function importAll(): RedirectResponse
    {
        $this->authorize('create', CorpoCeleste::class);

        $jobs = [];
        CorpoCeleste::whereNull('immagine')
            ->chunk(50, function ($corpi) use (&$jobs) {
                foreach ($corpi as $corpo) {
                    $jobs[] = ImportNasaImage::dispatch($corpo, galleryCount: 5, force: true)
                        ->delay(now()->addSeconds(count($jobs) * 2));
                }
            });

        $count = count($jobs);
        return redirect()->route('admin.nasa-import.index')
            ->with('success', "{$count} importazioni NASA sono state accodate per l'elaborazione.");
    }
}
