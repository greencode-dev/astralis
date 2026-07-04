<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\CorpoCeleste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class CorpoCelesteController extends Controller
{
    public function index(): View
    {
        $corpi = CorpoCeleste::with('categoria')
            ->orderBy('nome')
            ->get();

        return view('admin.corpi-celesti.index', compact('corpi'));
    }

    public function create(): View
    {
        $categorie = Categoria::orderBy('nome')->get();

        return view('admin.corpi-celesti.create', compact('categorie'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255', 'unique:corpi_celesti,nome'],
            'categoria_id' => ['required', 'exists:categorie,id'],
            'immagine' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
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

        if ($request->hasFile('immagine')) {
            $validated['immagine'] = $this->uploadImmagine($request->file('immagine'));
        }

        $validated['in_evidenza'] = $request->boolean('in_evidenza');

        CorpoCeleste::create($validated);

        return redirect()->route('admin.corpi-celesti.index')
            ->with('success', 'Corpo celeste creato con successo.');
    }

    public function show(CorpoCeleste $corpoCeleste): View
    {
        $corpoCeleste->load(['categoria', 'galleria', 'curiosita', 'missioni']);

        return view('admin.corpi-celesti.show', compact('corpoCeleste'));
    }

    public function edit(CorpoCeleste $corpoCeleste): View
    {
        $categorie = Categoria::orderBy('nome')->get();

        return view('admin.corpi-celesti.edit', compact('corpoCeleste', 'categorie'));
    }

    public function update(Request $request, CorpoCeleste $corpoCeleste): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255', 'unique:corpi_celesti,nome,' . $corpoCeleste->id],
            'categoria_id' => ['required', 'exists:categorie,id'],
            'immagine' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
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

        if ($request->hasFile('immagine')) {
            if ($corpoCeleste->immagine) {
                Storage::disk('public')->delete('corpi-celesti/' . $corpoCeleste->immagine);
            }
            $validated['immagine'] = $this->uploadImmagine($request->file('immagine'));
        }

        $validated['in_evidenza'] = $request->boolean('in_evidenza');

        $corpoCeleste->update($validated);

        return redirect()->route('admin.corpi-celesti.index')
            ->with('success', 'Corpo celeste aggiornato con successo.');
    }

    public function destroy(CorpoCeleste $corpoCeleste): RedirectResponse
    {
        if ($corpoCeleste->immagine) {
            Storage::disk('public')->delete('corpi-celesti/' . $corpoCeleste->immagine);
        }

        $corpoCeleste->delete();

        return redirect()->route('admin.corpi-celesti.index')
            ->with('success', 'Corpo celeste eliminato con successo.');
    }

    private function uploadImmagine($file): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $img = (new ImageManager(new Driver()))->decodePath($file->getRealPath());
        $img->scaleDown(width: 800, height: 800);

        Storage::disk('public')->put('corpi-celesti/' . $filename, $img->encode());

        return $filename;
    }
}
