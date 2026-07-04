<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CorpoCeleste;
use App\Services\NasaImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NasaImportController extends Controller
{
    public function __construct(
        private NasaImageService $nasaService,
    ) {}

    public function index(): View
    {
        $corpi = CorpoCeleste::with('categoria')
            ->orderBy('nome')
            ->get();

        return view('admin.nasa-import.index', compact('corpi'));
    }

    public function import(CorpoCeleste $corpoCeleste): RedirectResponse
    {
        $result = $this->nasaService->importForBody($corpoCeleste, galleryCount: 3, force: true);
        $key = $result['success'] ? 'success' : 'error';
        return redirect()->route('admin.nasa-import.index')->with($key, $result['message']);
    }

    public function importAll(): RedirectResponse
    {
        $result = $this->nasaService->importAll(galleryCount: 5, force: true);

        $total = $result['total'];
        $successCount = $result['success'];

        if ($successCount === $total) {
            return redirect()->route('admin.nasa-import.index')
                ->with('success', "Tutte le {$total} immagini sono state importate con successo ({$result['total_gallery']} galleria).");
        }

        $errors = [];
        foreach ($result['results'] as $r) {
            if (!$r['success']) {
                $errors[] = $r['message'];
            }
            if (!empty($r['errors'])) {
                $errors = array_merge($errors, $r['errors']);
            }
        }

        if ($successCount === 0) {
            return redirect()->route('admin.nasa-import.index')
                ->with('error', 'Nessuna immagine importata. Errori: ' . implode(' | ', array_slice($errors, 0, 5)) . (count($errors) > 5 ? ' (e altri ' . (count($errors) - 5) . ')' : ''));
        }

        return redirect()->route('admin.nasa-import.index')
            ->with('warning', "Importate {$successCount} su {$total} immagini ({$result['total_gallery']} galleria). Errori: " . implode(' | ', array_slice($errors, 0, 5)) . (count($errors) > 5 ? ' (e altri ' . (count($errors) - 5) . ')' : ''));
    }
}
