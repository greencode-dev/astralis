<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ClearDashboardCache;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCuriositaRequest;
use App\Http\Requests\UpdateCuriositaRequest;
use App\Models\CorpoCeleste;
use App\Models\Curiosita;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\View\View;

class CuriositaController extends Controller
{
    use ClearDashboardCache;
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Curiosita::class);

        $curiosita = Curiosita::with('corpoCeleste.categoria')
            ->when($request->get('search'), fn($q, $v) => $q->where('titolo', 'like', '%' . static::escapeLike($v) . '%'))
            ->when($request->get('corpo_celeste_id'), fn($q, $v) => $q->where('corpo_celeste_id', $v))
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.curiosita.index', compact('curiosita'));
    }

    public function show(Curiosita $curiositum): View
    {
        $this->authorize('view', $curiositum);

        $curiositum->load('corpoCeleste');

        return view('admin.curiosita.show', compact('curiositum'));
    }

    public function create(): View
    {
        $this->authorize('create', Curiosita::class);

        $corpi = CorpoCeleste::orderBy('nome')->get();

        return view('admin.curiosita.create', compact('corpi'));
    }

    public function store(StoreCuriositaRequest $request): RedirectResponse
    {
        $this->authorize('create', Curiosita::class);

        Curiosita::create($request->validated());

        $this->clearDashboardCache();

        return redirect()->route('admin.curiosita.index')
            ->with('success', 'Curiosità creata con successo.');
    }

    public function edit(Curiosita $curiositum): View
    {
        $this->authorize('update', $curiositum);

        $corpi = CorpoCeleste::orderBy('nome')->get();

        return view('admin.curiosita.edit', compact('curiositum', 'corpi'));
    }

    public function update(UpdateCuriositaRequest $request, Curiosita $curiositum): RedirectResponse
    {
        $this->authorize('update', $curiositum);

        $curiositum->update($request->validated());

        $this->clearDashboardCache();

        return redirect()->route('admin.curiosita.index')
            ->with('success', 'Curiosità aggiornata con successo.');
    }

    public function destroy(Curiosita $curiositum): RedirectResponse
    {
        $this->authorize('delete', $curiositum);

        $curiositum->delete();

        $this->clearDashboardCache();

        return redirect()->route('admin.curiosita.index')
            ->with('success', 'Curiosità eliminata con successo.');
    }
}
