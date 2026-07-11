@extends('admin.layouts.app')

@section('title', $corpoCeleste->nome_display)
@section('page_title', $corpoCeleste->nome_display)

@section('content')
    <div class="max-w-5xl">
        <a href="{{ route('admin.corpi-celesti.index') }}" class="inline-flex items-center gap-2 text-sm mb-6 transition-colors duration-150 text-gray-400 hover:text-admin-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Torna alla lista
        </a>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="rounded-xl p-6 flex flex-col items-center text-center bg-admin-card border border-admin-primary/10">
                @if ($corpoCeleste->immagine)
                    <img loading="lazy" src="{{ $corpoCeleste->immagine_url }}"
                         alt="{{ $corpoCeleste->nome }}"
                         class="w-32 h-32 rounded-full object-cover mb-4 border-[3px] border-admin-primary/20">
                @else
                    <div class="w-32 h-32 rounded-full flex items-center justify-center text-4xl mb-4 bg-admin-primary/10 text-admin-primary" role="img" aria-label="{{ $corpoCeleste->nome }}">
                        ★
                    </div>
                    <form method="POST" action="{{ route('admin.nasa-import.import', $corpoCeleste) }}" class="mt-3">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200 bg-admin-primary/15 text-admin-primary border border-admin-primary/20 hover:bg-admin-primary/25 hover:border-admin-primary/40">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            Cerca su NASA
                        </button>
                    </form>
                @endif
                <h2 class="text-xl font-bold mb-2 text-admin-text">{{ $corpoCeleste->nome_display }}</h2>
                @if ($corpoCeleste->nome_it && $corpoCeleste->nome !== $corpoCeleste->nome_it)
                    <p class="text-xs text-gray-500">(EN: {{ $corpoCeleste->nome }})</p>
                @endif
                @if ($corpoCeleste->categoria)
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-medium"
                          style="background-color: {{ $corpoCeleste->categoria->colore }}20; color: {{ $corpoCeleste->categoria->colore }};">
                        {{ $corpoCeleste->categoria->icona ?? '' }} {{ $corpoCeleste->categoria->nome }}
                    </span>
                @endif
                @if ($corpoCeleste->in_evidenza)
                    <span class="inline-flex items-center gap-1 mt-3 px-3 py-1 rounded-full text-xs font-medium bg-yellow-400/15 text-yellow-400">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        In evidenza
                    </span>
                @endif
            </div>

            <div class="rounded-xl p-6 md:col-span-2 bg-admin-card border border-admin-primary/10">
                <h3 class="text-sm font-medium mb-3 uppercase tracking-wider text-gray-400">Descrizione</h3>
                <p class="text-admin-text leading-[1.7]">{{ $corpoCeleste->descrizione ?? 'Nessuna descrizione disponibile.' }}</p>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('admin.corpi-celesti.edit', $corpoCeleste) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-accent/15 text-admin-accent hover:bg-admin-accent/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Modifica
                    </a>
                    <form method="POST" action="{{ route('admin.corpi-celesti.destroy', $corpoCeleste) }}" class="inline" onsubmit="return confirm('Sei sicuro di voler eliminare {{ $corpoCeleste->nome }}?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-red-500/15 text-red-500 hover:bg-red-500/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Elimina
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="rounded-xl p-4 text-center bg-admin-card border border-admin-primary/10">
                <p class="text-xs uppercase tracking-wider mb-1 text-gray-400">Tipo</p>
                <p class="text-sm font-medium text-admin-text">{{ $corpoCeleste->tipo ?? '—' }}</p>
            </div>
            <div class="rounded-xl p-4 text-center bg-admin-card border border-admin-primary/10">
                <p class="text-xs uppercase tracking-wider mb-1 text-gray-400">Massa</p>
                <p class="text-sm font-medium text-admin-text font-mono">{{ $corpoCeleste->massa_kg ?? '—' }} kg</p>
            </div>
            <div class="rounded-xl p-4 text-center bg-admin-card border border-admin-primary/10">
                <p class="text-xs uppercase tracking-wider mb-1 text-gray-400">Distanza</p>
                <p class="text-sm font-medium text-admin-text font-mono">{{ $corpoCeleste->distanza_km ?? '—' }} km</p>
            </div>
            <div class="rounded-xl p-4 text-center bg-admin-card border border-admin-primary/10">
                <p class="text-xs uppercase tracking-wider mb-1 text-gray-400">Diametro</p>
                <p class="text-sm font-medium text-admin-text font-mono">{{ $corpoCeleste->diametro_km ?? '—' }} km</p>
            </div>
            <div class="rounded-xl p-4 text-center bg-admin-card border border-admin-primary/10">
                <p class="text-xs uppercase tracking-wider mb-1 text-gray-400">Gravità</p>
                <p class="text-sm font-medium text-admin-text">{{ $corpoCeleste->gravita ?? '—' }} m/s²</p>
            </div>
            <div class="rounded-xl p-4 text-center bg-admin-card border border-admin-primary/10">
                <p class="text-xs uppercase tracking-wider mb-1 text-gray-400">Temperatura</p>
                <p class="text-sm font-medium text-admin-text">{{ $corpoCeleste->temperatura ?? '—' }} °C</p>
            </div>
            <div class="rounded-xl p-4 text-center bg-admin-card border border-admin-primary/10">
                <p class="text-xs uppercase tracking-wider mb-1 text-gray-400">Periodo orbitale</p>
                <p class="text-sm font-medium text-admin-text">{{ $corpoCeleste->periodo_orbitale ?? '—' }} giorni</p>
            </div>
            <div class="rounded-xl p-4 text-center bg-admin-card border border-admin-primary/10">
                <p class="text-xs uppercase tracking-wider mb-1 text-gray-400">Scoperta</p>
                <p class="text-sm font-medium text-admin-text">
                    @if ($corpoCeleste->scopritore || $corpoCeleste->anno_scoperta)
                        {{ $corpoCeleste->scopritore ?? '—' }}{{ $corpoCeleste->scopritore && $corpoCeleste->anno_scoperta ? ', ' : '' }}{{ $corpoCeleste->anno_scoperta ?? '' }}
                    @else
                        —
                    @endif
                </p>
            </div>
        </div>

        @if ($corpoCeleste->galleria->count() > 0)
            <div class="rounded-xl p-6 mb-8 bg-admin-card border border-admin-primary/10">
                <h3 class="text-lg font-semibold mb-4 text-admin-text">Galleria ({{ $corpoCeleste->galleria->count() }})</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($corpoCeleste->galleria as $foto)
                        <div class="rounded-lg overflow-hidden border border-admin-primary/10">
                            <div class="aspect-square bg-admin-bg">
                                <img loading="lazy" src="{{ $foto->percorso_url }}" alt="{{ $foto->didascalia ?? '' }}" class="w-full h-full object-cover">
                            </div>
                            @if ($foto->didascalia)
                                <div class="p-2">
                                    <p class="text-xs text-gray-400">{{ $foto->didascalia }}</p>
                                </div>
                            @endif
                            <form method="POST" action="{{ route('admin.corpi-celesti.set-image', [$corpoCeleste, $foto]) }}">
                                @csrf
                                <button type="submit"
                                        class="w-full text-xs py-1.5 font-medium transition-all duration-200 bg-admin-primary/10 text-admin-primary hover:bg-admin-primary/25">
                                    Imposta come principale
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($corpoCeleste->curiosita->count() > 0)
            <div class="rounded-xl p-6 mb-8 bg-admin-card border border-admin-primary/10">
                <h3 class="text-lg font-semibold mb-4 text-admin-text">Curiosità ({{ $corpoCeleste->curiosita->count() }})</h3>
                <div class="space-y-4">
                    @foreach ($corpoCeleste->curiosita as $curiosita)
                        <div class="p-4 rounded-lg bg-admin-bg border border-admin-secondary/15">
                            <h4 class="text-sm font-medium mb-1 text-admin-secondary">{{ $curiosita->titolo }}</h4>
                            <p class="text-sm text-admin-dim">{{ $curiosita->descrizione }}</p>
                            @if ($curiosita->fonte)
                                <p class="text-xs mt-1 text-gray-500">Fonte: {{ $curiosita->fonte }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($corpoCeleste->missioni->count() > 0)
            <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
                <h3 class="text-lg font-semibold mb-4 text-admin-text">Missioni ({{ $corpoCeleste->missioni->count() }})</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-admin-primary/10">
                                <th class="text-left py-3 px-4 font-medium text-gray-400">Missione</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-400">Agenzia</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-400">Tipo esplorazione</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-400">Anno arrivo</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-400">Stato</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($corpoCeleste->missioni as $missione)
                                <tr class="border-b border-admin-primary/5">
                                    <td class="py-3 px-4 text-admin-text">{{ $missione->nome }}</td>
                                    <td class="py-3 px-4 text-gray-400">{{ $missione->agenzia }}</td>
                                    <td class="py-3 px-4 text-gray-400">{{ $missione->pivot->tipo_esplorazione ?? '—' }}</td>
                                    <td class="py-3 px-4 text-gray-400">{{ $missione->pivot->anno_arrivo ?? '—' }}</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                              style="background-color: {{ $missione->stato === 'Completata' ? 'rgba(34,197,94,0.15)' : ($missione->stato === 'In corso' ? 'rgba(34,211,238,0.15)' : 'rgba(250,204,21,0.15)') }}; color: {{ $missione->stato === 'Completata' ? 'var(--admin-success)' : ($missione->stato === 'In corso' ? 'var(--admin-primary)' : 'var(--admin-warning)') }};">
                                            {{ $missione->stato }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
