<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CorpoCeleste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class NasaImportController extends Controller
{
    private array $nameMap = [
        'Cerere'   => 'Ceres',
        'Terra'    => 'Earth',
        'Marte'    => 'Mars',
        'Giove'    => 'Jupiter',
        'Saturno'  => 'Saturn',
        'Urano'    => 'Uranus',
        'Nettuno'  => 'Neptune',
        'Venere'   => 'Venus',
        'Mercurio' => 'Mercury',
        'Luna'     => 'Moon',
        'Sole'     => 'Sun',
        'Via Lattea' => 'Milky Way',
    ];

    public function index(): View
    {
        $corpi = CorpoCeleste::with('categoria')
            ->orderBy('nome')
            ->get();

        return view('admin.nasa-import.index', compact('corpi'));
    }

    public function import(CorpoCeleste $corpoCeleste): RedirectResponse
    {
        $result = $this->importSingle($corpoCeleste);
        $key = $result['success'] ? 'success' : 'error';
        return redirect()->route('admin.nasa-import.index')->with($key, $result['message']);
    }

    public function importAll(): RedirectResponse
    {
        $corpi = CorpoCeleste::all();
        $successCount = 0;
        $errors = [];

        foreach ($corpi as $corpo) {
            $result = $this->importSingle($corpo);
            if ($result['success']) {
                $successCount++;
            } else {
                $errors[] = $result['message'];
            }
        }

        $total = $corpi->count();

        if ($successCount === $total) {
            return redirect()->route('admin.nasa-import.index')
                ->with('success', "Tutte le {$total} immagini sono state importate con successo.");
        }

        if ($successCount === 0) {
            return redirect()->route('admin.nasa-import.index')
                ->with('error', 'Nessuna immagine importata. Errori: ' . implode(' | ', array_slice($errors, 0, 5)) . (count($errors) > 5 ? ' (e altri ' . (count($errors) - 5) . ')' : ''));
        }

        return redirect()->route('admin.nasa-import.index')
            ->with('warning', "Importate {$successCount} su {$total} immagini. Errori: " . implode(' | ', array_slice($errors, 0, 5)) . (count($errors) > 5 ? ' (e altri ' . (count($errors) - 5) . ')' : ''));
    }

    private function importSingle(CorpoCeleste $corpoCeleste): array
    {
        $nome = $corpoCeleste->nome;
        $searchName = $this->nameMap[$nome] ?? $nome;

        $response = Http::withoutVerifying()->get('https://images-api.nasa.gov/search', [
            'q' => $searchName,
            'media_type' => 'image',
        ]);

        if ($response->failed()) {
            return ['success' => false, 'message' => 'Errore di connessione a NASA API per "' . $nome . '".'];
        }

        $items = $response->json('collection.items');
        if (empty($items)) {
            return ['success' => false, 'message' => 'Nessuna immagine trovata per "' . $nome . '".'];
        }

        $imageUrl = null;
        foreach ($items as $item) {
            if (!empty($item['links'])) {
                foreach ($item['links'] as $link) {
                    if (($link['rel'] ?? '') === 'preview' && ($link['render'] ?? '') === 'image') {
                        $imageUrl = $link['href'];
                        break 2;
                    }
                }
            }
        }

        if (!$imageUrl) {
            return ['success' => false, 'message' => 'Nessun URL immagine valido trovato per "' . $nome . '".'];
        }

        $origUrl = preg_replace('/~(thumb|small)\./', '~orig.', $imageUrl, 1);
        $imageResponse = Http::withoutVerifying()->timeout(30)->get($origUrl);
        if ($imageResponse->failed()) {
            $imageResponse = Http::withoutVerifying()->timeout(30)->get($imageUrl);
            if ($imageResponse->failed()) {
                return ['success' => false, 'message' => 'Impossibile scaricare l\'immagine per "' . $nome . '".'];
            }
        }

        if ($corpoCeleste->immagine) {
            Storage::disk('public')->delete('corpi-celesti/' . $corpoCeleste->immagine);
        }

        $extension = 'jpg';
        $filename = time() . '_' . uniqid() . '.' . $extension;

        try {
            $manager = new ImageManager(new Driver());
            $img = $manager->decodeBinary($imageResponse->body());
            $img->scaleDown(width: 800, height: 800);

            Storage::disk('public')->put('corpi-celesti/' . $filename, $img->encode());
        } catch (\Exception $e) {
            Storage::disk('public')->delete('corpi-celesti/' . $filename);
            return ['success' => false, 'message' => 'Errore durante l\'elaborazione dell\'immagine per "' . $nome . '": ' . $e->getMessage()];
        }

        $corpoCeleste->update(['immagine' => $filename]);

        return ['success' => true, 'message' => 'Immagine importata con successo per "' . $nome . '".'];
    }
}
