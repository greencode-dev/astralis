<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class GalleriaController extends Controller
{
    public function index(): View
    {
        $galleria = GalleriaCorpo::with('corpoCeleste')
            ->orderBy('ordine')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.galleria.index', compact('galleria'));
    }

    public function create(): View
    {
        $corpi = CorpoCeleste::orderBy('nome')->get();

        return view('admin.galleria.create', compact('corpi'));
    }

    public function store(Request $request): RedirectResponse
    {
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
        $corpi = CorpoCeleste::orderBy('nome')->get();

        return view('admin.galleria.edit', compact('galleriaCorpo', 'corpi'));
    }

    public function update(Request $request, GalleriaCorpo $galleriaCorpo): RedirectResponse
    {
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
        Storage::disk('public')->delete('galleria/' . $galleriaCorpo->percorso);

        $galleriaCorpo->delete();

        return redirect()->route('admin.galleria.index')
            ->with('success', 'Immagine eliminata con successo.');
    }

    private function uploadImmagine($file): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $img = (new ImageManager(new Driver()))->decodePath($file->getRealPath());
        $img->scaleDown(width: 1200, height: 1200);

        Storage::disk('public')->put('galleria/' . $filename, $img->encode());

        return $filename;
    }
}
