<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ClearDashboardCache;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCorpoCelesteRequest;
use App\Http\Requests\SuggestNomeRequest;
use App\Http\Requests\UpdateCorpoCelesteRequest;
use App\Models\Categoria;
use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use App\Services\ImageUploadService;
use App\Services\NasaImageService;
use App\Services\WordMapService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CorpoCelesteController extends Controller
{
    use ClearDashboardCache;
    public function index(Request $request): View
    {
        $this->authorize('viewAny', CorpoCeleste::class);

        $query = CorpoCeleste::with('categoria');

        if ($search = $request->get('search')) {
            $safe = static::escapeLike($search);
            $query->where(function ($q) use ($safe) {
                $q->where('nome', 'like', "%{$safe}%")
                    ->orWhere('nome_en', 'like', "%{$safe}%");
            });
        }

        $corpi = $query->orderBy('nome')->paginate(20)->withQueryString();

        return view('admin.corpi-celesti.index', compact('corpi'));
    }

    public function create(): View
    {
        $this->authorize('create', CorpoCeleste::class);

        $categorie = Categoria::orderBy('nome')->get();

        return view('admin.corpi-celesti.create', compact('categorie'));
    }

    public function store(StoreCorpoCelesteRequest $request, ImageUploadService $uploader): RedirectResponse
    {
        $this->authorize('create', CorpoCeleste::class);

        $validated = $request->validated();

        if ($request->hasFile('immagine_file')) {
            $validated['immagine'] = $uploader->upload($request->file('immagine_file'), 'corpi-celesti');
            $validated['immagine_utente'] = true;
        } elseif ($request->filled('immagine')) {
            $validated['immagine_utente'] = true;
        }

        unset($validated['immagine_file']);

        CorpoCeleste::create($validated);

        $this->clearDashboardCache();

        return redirect()->route('admin.corpi-celesti.index')
            ->with('success', 'Corpo celeste creato con successo.');
    }

    public function show(CorpoCeleste $corpoCeleste): View
    {
        $this->authorize('view', $corpoCeleste);

        $corpoCeleste->load(['categoria', 'galleria', 'curiosita', 'missioni']);

        return view('admin.corpi-celesti.show', compact('corpoCeleste'));
    }

    public function edit(CorpoCeleste $corpoCeleste): View
    {
        $this->authorize('update', $corpoCeleste);

        $categorie = Categoria::orderBy('nome')->get();

        return view('admin.corpi-celesti.edit', compact('corpoCeleste', 'categorie'));
    }

    public function update(UpdateCorpoCelesteRequest $request, CorpoCeleste $corpoCeleste, ImageUploadService $uploader): RedirectResponse
    {
        $this->authorize('update', $corpoCeleste);

        $validated = $request->validated();

        if ($request->hasFile('immagine_file')) {
            if ($corpoCeleste->immagine && !str_starts_with($corpoCeleste->immagine, 'http')) {
                Storage::disk('public')->delete('corpi-celesti/' . $corpoCeleste->immagine);
            }
            $validated['immagine'] = $uploader->upload($request->file('immagine_file'), 'corpi-celesti');
            $validated['immagine_utente'] = true;
        } elseif ($request->filled('immagine')) {
            $validated['immagine_utente'] = true;
        }

        unset($validated['immagine_file']);

        $corpoCeleste->update($validated);

        $this->clearDashboardCache();

        return redirect()->route('admin.corpi-celesti.index')
            ->with('success', 'Corpo celeste aggiornato con successo.');
    }

    public function destroy(CorpoCeleste $corpoCeleste): RedirectResponse
    {
        $this->authorize('delete', $corpoCeleste);

        $corpoCeleste->load('galleria');

        foreach ($corpoCeleste->galleria as $img) {
            if (!str_starts_with($img->percorso, 'http')) {
                Storage::disk('public')->delete('galleria/' . $img->percorso);
            }
        }

        if ($corpoCeleste->immagine && !str_starts_with($corpoCeleste->immagine, 'http')) {
            Storage::disk('public')->delete('corpi-celesti/' . $corpoCeleste->immagine);
        }

        $corpoCeleste->delete();

        $this->clearDashboardCache();

        return redirect()->route('admin.corpi-celesti.index')
            ->with('success', 'Corpo celeste eliminato con successo.');
    }

    public function setImageFromGallery(CorpoCeleste $corpoCeleste, GalleriaCorpo $galleriaCorpo): RedirectResponse
    {
        $this->authorize('update', $corpoCeleste);

        if ((int) $galleriaCorpo->corpo_celeste_id !== (int) $corpoCeleste->id) {
            abort(404);
        }

        $corpoCeleste->update([
            'immagine' => $galleriaCorpo->percorso,
            'immagine_utente' => true,
        ]);

        $this->clearDashboardCache();

        return redirect()->route('admin.corpi-celesti.show', $corpoCeleste)
            ->with('success', 'Immagine principale aggiornata con successo.');
    }

    public function galleryAdd(Request $request, CorpoCeleste $corpoCeleste): \Illuminate\Http\JsonResponse
    {
        $this->authorize('update', $corpoCeleste);

        $validated = $request->validate([
            'percorso' => ['required', 'string', 'max:2047'],
            'didascalia' => ['nullable', 'string', 'max:255'],
            'crediti' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['corpo_celeste_id'] = $corpoCeleste->id;
        $validated['ordine'] = $corpoCeleste->galleria()->max('ordine') + 1;

        GalleriaCorpo::create($validated);

        return response()->json(['success' => true]);
    }

    public function suggestNome(SuggestNomeRequest $request, NasaImageService $nasaService, WordMapService $wordMapService): \Illuminate\Http\JsonResponse
    {
        $this->authorize('viewAny', CorpoCeleste::class);

        $nomeIt = $request->input('nome');
        $nomeEn = $request->input('nome_en');

        if ($nomeEn) {
            $result = $nasaService->searchNasa($nomeEn);
            if ($result['success']) {
                $suggested = $wordMapService->guessEnglishName($result['items'], $nomeEn);
                if ($suggested) {
                    return response()->json(['success' => true, 'nome_en' => $suggested]);
                }
            }
        }

        if ($nomeIt) {
            $translated = $wordMapService->translate($nomeIt);
            if ($translated !== $nomeIt) {
                $result = $nasaService->searchNasa($translated);
                if ($result['success']) {
                    $suggested = $wordMapService->guessEnglishName($result['items'], $translated);
                    if ($suggested) {
                        return response()->json(['success' => true, 'nome_en' => $suggested]);
                    }
                }
            }

            $apiTranslated = $wordMapService->translateWithApi($nomeIt);
            if ($apiTranslated) {
                $result = $nasaService->searchNasa($apiTranslated);
                if ($result['success']) {
                    $suggested = $wordMapService->guessEnglishName($result['items'], $apiTranslated);
                    if ($suggested) {
                        return response()->json(['success' => true, 'nome_en' => $suggested]);
                    }
                }
            }

            return response()->json([
                'success' => false,
                'needs_manual' => true,
                'message' => 'Impossibile tradurre automaticamente. Inserisci il nome inglese manualmente.',
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Inserisci almeno un nome.']);
    }
}
