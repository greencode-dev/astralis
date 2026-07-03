<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function index(): View
    {
        $categorie = Categoria::withCount('corpiCelesti')
            ->orderBy('nome')
            ->get();

        return view('admin.categorie.index', compact('categorie'));
    }

    public function create(): View
    {
        return view('admin.categorie.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255', 'unique:categorie,nome'],
            'icona' => ['nullable', 'string', 'max:50'],
            'descrizione' => ['nullable', 'string', 'max:1000'],
            'colore' => ['nullable', 'string', 'max:20'],
        ]);

        Categoria::create($validated);

        return redirect()->route('admin.categorie.index')
            ->with('success', 'Categoria creata con successo.');
    }

    public function show(Categoria $categoria): View
    {
        $categoria->loadCount('corpiCelesti');

        return view('admin.categorie.show', compact('categoria'));
    }

    public function edit(Categoria $categoria): View
    {
        return view('admin.categorie.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255', 'unique:categorie,nome,' . $categoria->id],
            'icona' => ['nullable', 'string', 'max:50'],
            'descrizione' => ['nullable', 'string', 'max:1000'],
            'colore' => ['nullable', 'string', 'max:20'],
        ]);

        $categoria->update($validated);

        return redirect()->route('admin.categorie.index')
            ->with('success', 'Categoria aggiornata con successo.');
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        if ($categoria->corpiCelesti()->count() > 0) {
            return redirect()->route('admin.categorie.index')
                ->with('error', 'Impossibile eliminare: ci sono corpi celesti associati a questa categoria.');
        }

        $categoria->delete();

        return redirect()->route('admin.categorie.index')
            ->with('success', 'Categoria eliminata con successo.');
    }
}
