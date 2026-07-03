<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Missione;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Laravel\Facades\Image;

class MissioneController extends Controller
{
    public function index(): View
    {
        $missioni = Missione::orderBy('data_lancio', 'desc')->get();

        return view('admin.missioni.index', compact('missioni'));
    }

    public function create(): View
    {
        return view('admin.missioni.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255', 'unique:missioni,nome'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:1024'],
            'agenzia' => ['nullable', 'string', 'max:100'],
            'data_lancio' => ['nullable', 'date'],
            'durata_giorni' => ['nullable', 'integer', 'min:0'],
            'stato' => ['nullable', 'string', 'max:50'],
            'descrizione' => ['nullable', 'string', 'max:5000'],
            'sito_web' => ['nullable', 'string', 'url', 'max:255'],
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $this->uploadLogo($request->file('logo'));
        }

        Missione::create($validated);

        return redirect()->route('admin.missioni.index')
            ->with('success', 'Missione creata con successo.');
    }

    public function show(Missione $missione): View
    {
        $missione->load('corpiCelesti');

        return view('admin.missioni.show', compact('missione'));
    }

    public function edit(Missione $missione): View
    {
        return view('admin.missioni.edit', compact('missione'));
    }

    public function update(Request $request, Missione $missione): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255', 'unique:missioni,nome,' . $missione->id],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:1024'],
            'agenzia' => ['nullable', 'string', 'max:100'],
            'data_lancio' => ['nullable', 'date'],
            'durata_giorni' => ['nullable', 'integer', 'min:0'],
            'stato' => ['nullable', 'string', 'max:50'],
            'descrizione' => ['nullable', 'string', 'max:5000'],
            'sito_web' => ['nullable', 'string', 'url', 'max:255'],
        ]);

        if ($request->hasFile('logo')) {
            if ($missione->logo) {
                Storage::disk('public')->delete('missioni/' . $missione->logo);
            }
            $validated['logo'] = $this->uploadLogo($request->file('logo'));
        }

        $missione->update($validated);

        return redirect()->route('admin.missioni.index')
            ->with('success', 'Missione aggiornata con successo.');
    }

    public function destroy(Missione $missione): RedirectResponse
    {
        if ($missione->corpiCelesti()->count() > 0) {
            return redirect()->route('admin.missioni.index')
                ->with('error', 'Impossibile eliminare: ci sono corpi celesti associati a questa missione.');
        }

        if ($missione->logo) {
            Storage::disk('public')->delete('missioni/' . $missione->logo);
        }

        $missione->delete();

        return redirect()->route('admin.missioni.index')
            ->with('success', 'Missione eliminata con successo.');
    }

    private function uploadLogo($file): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $img = Image::read($file->getRealPath());
        $img->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        Storage::disk('public')->put('missioni/' . $filename, $img->encode());

        return $filename;
    }
}
