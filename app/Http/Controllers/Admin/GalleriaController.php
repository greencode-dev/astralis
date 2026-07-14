<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ClearDashboardCache;
use App\Http\Controllers\Controller;
use App\Http\Requests\AggiornaOrdineRequest;
use App\Http\Requests\StoreGalleriaCorpoRequest;
use App\Http\Requests\UpdateGalleriaCorpoRequest;
use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleriaController extends Controller
{
    use ClearDashboardCache;
    public function index(Request $request): View
    {
        $this->authorize('viewAny', GalleriaCorpo::class);

        $galleria = GalleriaCorpo::with('corpoCeleste')
            ->when($request->get('search'), fn($q, $v) => $q->where('didascalia', 'like', '%' . static::escapeLike($v) . '%'))
            ->when($request->get('corpo_celeste_id'), fn($q, $v) => $q->where('corpo_celeste_id', $v))
            ->orderBy('ordine')
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.galleria.index', compact('galleria'));
    }

    public function create(): View
    {
        $this->authorize('create', GalleriaCorpo::class);

        $corpi = CorpoCeleste::orderBy('nome')->get();

        return view('admin.galleria.create', compact('corpi'));
    }

    public function store(StoreGalleriaCorpoRequest $request, ImageUploadService $uploader): RedirectResponse
    {
        $this->authorize('create', GalleriaCorpo::class);

        $validated = $request->validated();
        $validated['percorso'] = $uploader->upload($request->file('percorso'), 'galleria');
        $validated['ordine'] = $validated['ordine'] ?? 0;

        GalleriaCorpo::create($validated);

        $this->clearDashboardCache();

        return redirect()->route('admin.galleria.index')
            ->with('success', 'Immagine aggiunta alla galleria con successo.');
    }

    public function edit(GalleriaCorpo $galleriaCorpo): View
    {
        $this->authorize('update', $galleriaCorpo);

        $corpi = CorpoCeleste::orderBy('nome')->get();

        return view('admin.galleria.edit', compact('galleriaCorpo', 'corpi'));
    }

    public function update(UpdateGalleriaCorpoRequest $request, GalleriaCorpo $galleriaCorpo, ImageUploadService $uploader): RedirectResponse
    {
        $this->authorize('update', $galleriaCorpo);

        $validated = $request->validated();

        if ($request->hasFile('percorso')) {
            $validated['percorso'] = $uploader->upload($request->file('percorso'), 'galleria');
            if (!str_starts_with($galleriaCorpo->percorso, 'http')) {
                Storage::disk('public')->delete('galleria/' . $galleriaCorpo->percorso);
            }
        }

        $validated['ordine'] = $validated['ordine'] ?? 0;

        $galleriaCorpo->update($validated);

        $this->clearDashboardCache();

        return redirect()->route('admin.galleria.index')
            ->with('success', 'Immagine aggiornata con successo.');
    }

    public function destroy(GalleriaCorpo $galleriaCorpo): RedirectResponse
    {
        $this->authorize('delete', $galleriaCorpo);

        $inUse = CorpoCeleste::where('immagine', $galleriaCorpo->percorso)->exists();

        if ($inUse) {
            return redirect()->route('admin.galleria.index')
                ->with('error', 'Impossibile eliminare: questa immagine è usata come immagine principale di un corpo celeste.');
        }

        if (!str_starts_with($galleriaCorpo->percorso, 'http')) {
            Storage::disk('public')->delete('galleria/' . $galleriaCorpo->percorso);
        }

        $galleriaCorpo->delete();

        $this->clearDashboardCache();

        return redirect()->route('admin.galleria.index')
            ->with('success', 'Immagine eliminata con successo.');
    }

    public function aggiornaOrdine(AggiornaOrdineRequest $request, GalleriaCorpo $galleriaCorpo): RedirectResponse
    {
        $this->authorize('update', $galleriaCorpo);

        $request->validated();

        $step = $request->direzione === 'su' ? -1 : 1;
        $galleriaCorpo->update(['ordine' => max(0, $galleriaCorpo->ordine + $step)]);

        return redirect()->route('admin.galleria.index')
            ->with('success', "Ordine aggiornato a {$galleriaCorpo->fresh()->ordine}.");
    }
}
