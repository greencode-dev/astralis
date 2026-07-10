<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CorpoCeleste;
use App\Jobs\ImportNasaImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NasaImportController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', CorpoCeleste::class);

        $corpi = CorpoCeleste::with('categoria')
            ->orderBy('nome')
            ->get();

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

        $count = 0;
        CorpoCeleste::chunk(50, function ($corpi) use (&$count) {
            foreach ($corpi as $corpo) {
                ImportNasaImage::dispatch($corpo, galleryCount: 5, force: true);
                $count++;
            }
        });

        return redirect()->route('admin.nasa-import.index')
            ->with('success', "{$count} importazioni NASA sono state accodate per l'elaborazione.");
    }
}
