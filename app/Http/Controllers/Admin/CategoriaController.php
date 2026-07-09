<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Categoria::class);

        $categorie = Categoria::withCount('corpiCelesti')
            ->when($request->get('search'), fn($q, $v) => $q->where('nome', 'like', "%{$v}%"))
            ->orderBy('nome')
            ->paginate(20)
            ->withQueryString();

        return view('admin.categorie.index', compact('categorie'));
    }

    public function create(): View
    {
        $this->authorize('create', Categoria::class);

        return view('admin.categorie.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Categoria::class);

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
        $this->authorize('view', $categoria);

        $categoria->loadCount('corpiCelesti');

        return view('admin.categorie.show', compact('categoria'));
    }

    public function edit(Categoria $categoria): View
    {
        $this->authorize('update', $categoria);

        return view('admin.categorie.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria): RedirectResponse
    {
        $this->authorize('update', $categoria);

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
        $this->authorize('delete', $categoria);

        if ($categoria->corpiCelesti()->count() > 0) {
            return redirect()->route('admin.categorie.index')
                ->with('error', 'Impossibile eliminare: ci sono corpi celesti associati a questa categoria.');
        }

        $categoria->delete();

        return redirect()->route('admin.categorie.index')
            ->with('success', 'Categoria eliminata con successo.');
    }
}
