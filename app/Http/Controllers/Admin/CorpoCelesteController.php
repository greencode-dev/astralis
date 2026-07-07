<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use App\Services\NasaImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CorpoCelesteController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', CorpoCeleste::class);

        $query = CorpoCeleste::with('categoria');

        if ($search = $request->get('search')) {
            $query->where('nome', 'like', "%{$search}%")
                ->orWhere('nome_it', 'like', "%{$search}%");
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

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', CorpoCeleste::class);

        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255', 'unique:corpi_celesti,nome'],
            'nome_it' => ['nullable', 'string', 'max:255'],
            'categoria_id' => ['required', 'exists:categorie,id'],
            'immagine' => ['nullable', 'string', 'max:2048'],
            'descrizione' => ['nullable', 'string', 'max:5000'],
            'tipo' => ['nullable', 'string', 'max:50'],
            'massa_kg' => ['nullable', 'string', 'max:50'],
            'distanza_km' => ['nullable', 'string', 'max:50'],
            'diametro_km' => ['nullable', 'string', 'max:50'],
            'gravita' => ['nullable', 'numeric', 'max:999999'],
            'temperatura' => ['nullable', 'numeric', 'max:999999'],
            'periodo_orbitale' => ['nullable', 'numeric', 'max:999999'],
            'scopritore' => ['nullable', 'string', 'max:100'],
            'anno_scoperta' => ['nullable', 'integer', 'min:-5000', 'max:3000'],
            'in_evidenza' => ['nullable', 'boolean'],
        ]);

        $validated['in_evidenza'] = $request->boolean('in_evidenza');

        CorpoCeleste::create($validated);

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

    public function update(Request $request, CorpoCeleste $corpoCeleste): RedirectResponse
    {
        $this->authorize('update', $corpoCeleste);

        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255', 'unique:corpi_celesti,nome,' . $corpoCeleste->id],
            'nome_it' => ['nullable', 'string', 'max:255'],
            'categoria_id' => ['required', 'exists:categorie,id'],
            'immagine' => ['nullable', 'string', 'max:2048'],
            'descrizione' => ['nullable', 'string', 'max:5000'],
            'tipo' => ['nullable', 'string', 'max:50'],
            'massa_kg' => ['nullable', 'string', 'max:50'],
            'distanza_km' => ['nullable', 'string', 'max:50'],
            'diametro_km' => ['nullable', 'string', 'max:50'],
            'gravita' => ['nullable', 'numeric', 'max:999999'],
            'temperatura' => ['nullable', 'numeric', 'max:999999'],
            'periodo_orbitale' => ['nullable', 'numeric', 'max:999999'],
            'scopritore' => ['nullable', 'string', 'max:100'],
            'anno_scoperta' => ['nullable', 'integer', 'min:-5000', 'max:3000'],
            'in_evidenza' => ['nullable', 'boolean'],
        ]);

        $validated['in_evidenza'] = $request->boolean('in_evidenza');

        if ($request->filled('immagine')) {
            $validated['immagine_utente'] = true;
        }

        $corpoCeleste->update($validated);

        return redirect()->route('admin.corpi-celesti.index')
            ->with('success', 'Corpo celeste aggiornato con successo.');
    }

    public function destroy(CorpoCeleste $corpoCeleste): RedirectResponse
    {
        $this->authorize('delete', $corpoCeleste);

        $corpoCeleste->delete();

        return redirect()->route('admin.corpi-celesti.index')
            ->with('success', 'Corpo celeste eliminato con successo.');
    }

    public function setImageFromGallery(CorpoCeleste $corpoCeleste, GalleriaCorpo $galleriaCorpo): RedirectResponse
    {
        $this->authorize('update', $corpoCeleste);

        $corpoCeleste->update([
            'immagine' => $galleriaCorpo->percorso,
            'immagine_utente' => true,
        ]);

        return redirect()->route('admin.corpi-celesti.show', $corpoCeleste)
            ->with('success', 'Immagine principale aggiornata con successo.');
    }

    public function suggestNome(Request $request, NasaImageService $nasaService): \Illuminate\Http\JsonResponse
    {
        $this->authorize('viewAny', CorpoCeleste::class);

        $request->validate(['nome_it' => ['required', 'string', 'max:255']]);

        $nomeIt = $request->input('nome_it');

        $result = $nasaService->searchNasa($nomeIt);
        if ($result['success']) {
            $suggested = $this->guessEnglishName($result['items'], $nomeIt);
            if ($suggested) {
                return response()->json(['success' => true, 'nome' => $suggested]);
            }
        }

        $wordMap = [
            'Nebulosa' => 'Nebula',
            'Cometa' => 'Comet',
            'Galassia' => 'Galaxy',
            'Pianeta' => 'Planet',
            'Stella' => 'Star',
            'Asteroide' => 'Asteroid',
            'Luna' => 'Moon',
            'Sole' => 'Sun',
            'Satellite' => 'Moon',
            'Anello' => 'Ring',
            'Buco Nero' => 'Black Hole',
            'Ammasso' => 'Cluster',
            'Nana' => 'Dwarf',
            'Grande' => 'Great',
            'Piccola' => 'Small',
            'Nube' => 'Cloud',
            'Nuvola' => 'Cloud',
            'Via Lattea' => 'Milky Way',
            'Martello' => 'Hammer',
            'Boomerang' => 'Boomerang',
            'Falce' => 'Sickle',
            'Orsa' => 'Bear',
            'Cane' => 'Dog',
            'Granchio' => 'Crab',
            'Anello' => 'Ring',
            'Testa' => 'Head',
            'Coda' => 'Tail',
            'Giove' => 'Jupiter',
            'Marte' => 'Mars',
            'Venere' => 'Venus',
            'Mercurio' => 'Mercury',
            'Saturno' => 'Saturn',
            'Urano' => 'Uranus',
            'Nettuno' => 'Neptune',
            'Plutone' => 'Pluto',
            'Terra' => 'Earth',
            'Cerere' => 'Ceres',
            'Caronte' => 'Charon',
            'Europa' => 'Europa',
            'Titano' => 'Titan',
            'Encelado' => 'Enceladus',
            'Io' => 'Io',
            'Callisto' => 'Callisto',
            'Ganimede' => 'Ganymede',
            'Tritone' => 'Triton',
            'Fobos' => 'Phobos',
            'Deimos' => 'Deimos',
            'Titania' => 'Titania',
            'Oberon' => 'Oberon',
            'di' => '',
            'del' => '',
            'della' => '',
            'dell' => '',
            'degli' => '',
            'delle' => '',
            'con' => '',
            'per' => '',
            'tra' => '',
            'fra' => '',
            'sul' => '',
            'sulla' => '',
            'sulle' => '',
            'nell' => '',
            'nella' => '',
            'nelle' => '',
            'agli' => '',
            'alle' => '',
            'dal' => '',
            'dalla' => '',
            'dalle' => '',
        ];

        $translated = collect(explode(' ', $nomeIt))
            ->map(fn($w) => $wordMap[ucfirst($w)] ?? $wordMap[$w] ?? $w)
            ->filter()
            ->implode(' ');

        if ($translated !== $nomeIt) {
            $result = $nasaService->searchNasa($translated);
            if ($result['success']) {
                $suggested = $this->guessEnglishName($result['items'], $translated);
                if ($suggested) {
                    return response()->json(['success' => true, 'nome' => $suggested]);
                }
            }
        }

        return response()->json(['success' => false, 'message' => 'Nome inglese non trovato. Prova a cercare manualmente su NASA.']);
    }

    private function guessEnglishName(array $items, string $query): ?string
    {
        $lower = strtolower($query);
        foreach ($items as $item) {
            $title = $item['data'][0]['title'] ?? '';
            $keywords = $item['data'][0]['keywords'] ?? [];
            $all = $title . ' ' . implode(' ', $keywords);

            if (preg_match('/\b' . preg_quote($lower, '/') . '\b/i', $all)) {
                return $title;
            }
        }

        return $items[0]['data'][0]['title'] ?? null;
    }
}
