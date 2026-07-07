<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CorpoCeleste;
use App\Models\Curiosita;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CuriositaController extends Controller
{
    public function index(): View
    {
        $curiosita = Curiosita::with('corpoCeleste.categoria')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.curiosita.index', compact('curiosita'));
    }

    public function create(): View
    {
        $corpi = CorpoCeleste::orderBy('nome')->get();

        return view('admin.curiosita.create', compact('corpi'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'corpo_celeste_id' => ['required', 'exists:corpi_celesti,id'],
            'titolo' => ['required', 'string', 'max:255'],
            'descrizione' => ['required', 'string', 'max:5000'],
            'fonte' => ['nullable', 'string', 'max:255'],
        ]);

        Curiosita::create($validated);

        return redirect()->route('admin.curiosita.index')
            ->with('success', 'Curiosità creata con successo.');
    }

    public function edit(Curiosita $curiositum): View
    {
        $corpi = CorpoCeleste::orderBy('nome')->get();

        return view('admin.curiosita.edit', compact('curiositum', 'corpi'));
    }

    public function update(Request $request, Curiosita $curiositum): RedirectResponse
    {
        $validated = $request->validate([
            'corpo_celeste_id' => ['required', 'exists:corpi_celesti,id'],
            'titolo' => ['required', 'string', 'max:255'],
            'descrizione' => ['required', 'string', 'max:5000'],
            'fonte' => ['nullable', 'string', 'max:255'],
        ]);

        $curiositum->update($validated);

        return redirect()->route('admin.curiosita.index')
            ->with('success', 'Curiosità aggiornata con successo.');
    }

    public function destroy(Curiosita $curiositum): RedirectResponse
    {
        $curiositum->delete();

        return redirect()->route('admin.curiosita.index')
            ->with('success', 'Curiosità eliminata con successo.');
    }
}
