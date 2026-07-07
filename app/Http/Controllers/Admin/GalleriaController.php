<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class GalleriaController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', GalleriaCorpo::class);

        $galleria = GalleriaCorpo::with('corpoCeleste')
            ->orderBy('ordine')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.galleria.index', compact('galleria'));
    }

    public function create(): View
    {
        $this->authorize('create', GalleriaCorpo::class);

        $corpi = CorpoCeleste::orderBy('nome')->get();

        return view('admin.galleria.create', compact('corpi'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', GalleriaCorpo::class);

        $validated = $request->validate([
            'corpo_celeste_id' => ['required', 'exists:corpi_celesti,id'],
            'percorso' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'didascalia' => ['nullable', 'string', 'max:500'],
            'crediti' => ['nullable', 'string', 'max:255'],
            'ordine' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        $validated['percorso'] = $this->uploadImmagine($request->file('percorso'));
        $validated['ordine'] = $validated['ordine'] ?? 0;

        GalleriaCorpo::create($validated);

        return redirect()->route('admin.galleria.index')
            ->with('success', 'Immagine aggiunta alla galleria con successo.');
    }

    public function edit(GalleriaCorpo $galleriaCorpo): View
    {
        $this->authorize('update', $galleriaCorpo);

        $corpi = CorpoCeleste::orderBy('nome')->get();

        return view('admin.galleria.edit', compact('galleriaCorpo', 'corpi'));
    }

    public function update(Request $request, GalleriaCorpo $galleriaCorpo): RedirectResponse
    {
        $this->authorize('update', $galleriaCorpo);

        $validated = $request->validate([
            'corpo_celeste_id' => ['required', 'exists:corpi_celesti,id'],
            'percorso' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'didascalia' => ['nullable', 'string', 'max:500'],
            'crediti' => ['nullable', 'string', 'max:255'],
            'ordine' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        if ($request->hasFile('percorso')) {
            Storage::disk('public')->delete('galleria/' . $galleriaCorpo->percorso);
            $validated['percorso'] = $this->uploadImmagine($request->file('percorso'));
        }

        $validated['ordine'] = $validated['ordine'] ?? 0;

        $galleriaCorpo->update($validated);

        return redirect()->route('admin.galleria.index')
            ->with('success', 'Immagine aggiornata con successo.');
    }

    public function destroy(GalleriaCorpo $galleriaCorpo): RedirectResponse
    {
        $this->authorize('delete', $galleriaCorpo);

        if (!str_starts_with($galleriaCorpo->percorso, 'http')) {
            Storage::disk('public')->delete('galleria/' . $galleriaCorpo->percorso);
        }

        $galleriaCorpo->delete();

        return redirect()->route('admin.galleria.index')
            ->with('success', 'Immagine eliminata con successo.');
    }

    public function aggiornaOrdine(Request $request, GalleriaCorpo $galleriaCorpo): RedirectResponse
    {
        $this->authorize('update', $galleriaCorpo);

        $request->validate([
            'direzione' => ['required', 'in:su,giu'],
        ]);

        $step = $request->direzione === 'su' ? -1 : 1;
        $galleriaCorpo->update(['ordine' => max(0, $galleriaCorpo->ordine + $step)]);

        return redirect()->route('admin.galleria.index')
            ->with('success', "Ordine aggiornato a {$galleriaCorpo->fresh()->ordine}.");
    }

    private function uploadImmagine($file): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        try {
            $img = (new ImageManager(new Driver()))->decodePath($file->getRealPath());
            $img->scaleDown(width: 1200, height: 1200);

            Storage::disk('public')->put('galleria/' . $filename, $img->encode());
        } catch (\Exception $e) {
            Log::error('Errore upload immagine galleria', [
                'file' => $file->getClientOriginalName(),
                'error' => $e->getMessage(),
            ]);

            if (Storage::disk('public')->exists('galleria/' . $filename)) {
                Storage::disk('public')->delete('galleria/' . $filename);
            }

            throw $e;
        }

        return $filename;
    }
}
