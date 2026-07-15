<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ClearDashboardCache;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMissioneRequest;
use App\Http\Requests\UpdateMissioneRequest;
use App\Models\Missione;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MissioneController extends Controller
{
    use ClearDashboardCache;
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Missione::class);

        $missioni = Missione::when($request->get('search'), fn($q, $v) => $q->where('nome', 'like', '%' . static::escapeLike($v) . '%'))
            ->when($request->get('agenzia'), fn($q, $v) => $q->where('agenzia', $v))
            ->when($request->get('stato'), fn($q, $v) => $q->where('stato', $v))
            ->orderBy('data_lancio', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.missioni.index', compact('missioni'));
    }

    public function create(): View
    {
        $this->authorize('create', Missione::class);

        return view('admin.missioni.create');
    }

    public function store(StoreMissioneRequest $request, ImageUploadService $uploader): RedirectResponse
    {
        $this->authorize('create', Missione::class);

        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            $validated['logo'] = $uploader->upload($request->file('logo'), 'missioni', 300, 300);
        }

        Missione::create($validated);

        $this->clearDashboardCache();

        return redirect()->route('admin.missioni.index')
            ->with('success', 'Missione creata con successo.');
    }

    public function show(Missione $missione): View
    {
        $this->authorize('view', $missione);

        $missione->load('corpiCelesti.categoria');

        return view('admin.missioni.show', compact('missione'));
    }

    public function edit(Missione $missione): View
    {
        $this->authorize('update', $missione);

        return view('admin.missioni.edit', compact('missione'));
    }

    public function update(UpdateMissioneRequest $request, Missione $missione, ImageUploadService $uploader): RedirectResponse
    {
        $this->authorize('update', $missione);

        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            if ($missione->logo && !str_starts_with($missione->logo, 'http')) {
                Storage::disk('public')->delete('missioni/' . $missione->logo);
            }
            $validated['logo'] = $uploader->upload($request->file('logo'), 'missioni', 300, 300);
        }

        $missione->update($validated);

        $this->clearDashboardCache();

        return redirect()->route('admin.missioni.index')
            ->with('success', 'Missione aggiornata con successo.');
    }

    public function destroy(Missione $missione): RedirectResponse
    {
        $this->authorize('delete', $missione);

        if ($missione->corpiCelesti()->exists()) {
            return redirect()->route('admin.missioni.index')
                ->with('error', 'Impossibile eliminare: ci sono corpi celesti associati a questa missione.');
        }

        if ($missione->logo && !str_starts_with($missione->logo, 'http')) {
            Storage::disk('public')->delete('missioni/' . $missione->logo);
        }

        $missione->delete();

        $this->clearDashboardCache();

        return redirect()->route('admin.missioni.index')
            ->with('success', 'Missione eliminata con successo.');
    }
}
