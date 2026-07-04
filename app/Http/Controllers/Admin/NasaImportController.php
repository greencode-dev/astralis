<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CorpoCeleste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Laravel\Facades\Image;

class NasaImportController extends Controller
{
    public function index(): View
    {
        $corpi = CorpoCeleste::with('categoria')
            ->orderBy('nome')
            ->get();

        return view('admin.nasa-import.index', compact('corpi'));
    }

    public function import(CorpoCeleste $corpoCeleste): RedirectResponse
    {
        $nome = $corpoCeleste->nome;

        $response = Http::get('https://images-api.nasa.gov/search', [
            'q' => $nome,
            'media_type' => 'image',
        ]);

        if ($response->failed()) {
            return redirect()->route('admin.nasa-import.index')
                ->with('error', 'Errore di connessione a NASA API per "' . $nome . '".');
        }

        $items = $response->json('collection.items');
        if (empty($items)) {
            return redirect()->route('admin.nasa-import.index')
                ->with('error', 'Nessuna immagine trovata per "' . $nome . '".');
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
            return redirect()->route('admin.nasa-import.index')
                ->with('error', 'Nessun URL immagine valido trovato per "' . $nome . '".');
        }

        $imageResponse = Http::timeout(30)->get($imageUrl);
        if ($imageResponse->failed()) {
            return redirect()->route('admin.nasa-import.index')
                ->with('error', 'Impossibile scaricare l\'immagine per "' . $nome . '".');
        }

        if ($corpoCeleste->immagine) {
            Storage::disk('public')->delete('corpi-celesti/' . $corpoCeleste->immagine);
        }

        $extension = 'jpg';
        $filename = time() . '_' . uniqid() . '.' . $extension;

        $img = Image::read($imageResponse->body());
        $img->resize(800, 800, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        Storage::disk('public')->put('corpi-celesti/' . $filename, $img->encode());

        $corpoCeleste->update(['immagine' => $filename]);

        return redirect()->route('admin.nasa-import.index')
            ->with('success', 'Immagine importata con successo per "' . $nome . '".');
    }
}
