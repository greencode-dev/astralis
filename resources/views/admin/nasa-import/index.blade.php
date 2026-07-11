@extends('admin.layouts.app')

@section('title', 'NASA Import')
@section('page_title', 'NASA Import')

@section('content')
    <div x-data="{ modalOpen: false }">
        <div class="mb-6">
            <p class="text-sm text-gray-400">Importa immagini dalla NASA Image Library per ogni corpo celeste.</p>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg text-sm bg-green-500/15 text-green-500 border border-green-500/20">
                {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="mb-6 p-4 rounded-lg text-sm bg-admin-accent/15 text-admin-accent border border-admin-accent/20">
                {{ session('warning') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 rounded-lg text-sm bg-red-500/15 text-red-500 border border-red-500/20">
                {{ session('error') }}
            </div>
        @endif

    <div class="mb-6 flex justify-end">
        <button type="button"
                @click="modalOpen = true"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-admin-accent/25 hover:border-admin-accent/40 bg-admin-accent/15 text-admin-accent border border-admin-accent/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Force Import All
        </button>
    </div>

    <div class="rounded-xl overflow-x-auto bg-admin-card border border-admin-primary/10">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-admin-primary/10">
                    <th class="text-left py-3 px-4 font-medium text-gray-400">Corpo Celeste</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-400">Categoria</th>
                    <th class="text-center py-3 px-4 font-medium text-gray-400">Immagine</th>
                    <th class="text-right py-3 px-4 font-medium text-gray-400">Azione</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($corpi as $corpo)
                    <tr class="border-b border-admin-primary/5 hover:bg-[rgba(34,211,238,0.03)]">
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                @if ($corpo->immagine)
                                    <img loading="lazy" src="{{ $corpo->immagine_url }}"
                                         alt="{{ $corpo->nome }}"
                                          class="w-8 h-8 rounded-full object-cover border border-admin-primary/20">
                                @else
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm bg-admin-primary/10 text-admin-primary" role="img" aria-label="{{ $corpo->nome }}">
                                        ★
                                    </div>
                                @endif
                                <a href="{{ route('admin.corpi-celesti.show', $corpo) }}" class="font-medium transition-colors duration-150 hover:text-admin-primary text-admin-text">
                                    {{ $corpo->nome }}
                                </a>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            @if ($corpo->categoria)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                      style="background-color: {{ $corpo->categoria->colore }}20; color: {{ $corpo->categoria->colore }};">
                                    {{ $corpo->categoria->nome }}
                                </span>
                            @else
                                <span class="text-gray-500">—</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center">
                            @if ($corpo->immagine)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/15 text-green-500">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Presente
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-500/15 text-gray-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Assente
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-right">
                            @if ($corpo->immagine)
                                <form method="POST" action="{{ route('admin.nasa-import.import', $corpo) }}" class="inline" onsubmit="return confirm('Sostituire l\'immagine di {{ $corpo->nome }} con una nuova da NASA?');">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200 hover:bg-admin-accent/25 hover:border-admin-accent/40 bg-admin-accent/15 text-admin-accent border border-admin-accent/20">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        Forza import
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.nasa-import.import', $corpo) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200 hover:bg-admin-primary/25 hover:border-admin-primary/40 bg-admin-primary/15 text-admin-primary border border-admin-primary/20">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                        Importa da NASA
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center">
                            <p class="text-lg text-gray-500">Nessun corpo celeste trovato</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 p-4 rounded-lg bg-admin-card border border-admin-primary/10">
        <h3 class="text-sm font-semibold mb-2 text-admin-text">Note</h3>
        <ul class="text-xs space-y-1 text-gray-400">
            <li>• Le immagini vengono cercate su <a href="https://images.nasa.gov" target="_blank" class="transition-colors hover:text-admin-secondary text-admin-primary">images.nasa.gov</a> usando il nome del corpo celeste.</li>
            <li>• Le immagini vengono ridimensionate a 800px (lato lungo) e salvate in <code class="text-yellow-400">storage/app/public/corpi-celesti/</code>.</li>
            <li>• Il pulsante <strong class="text-admin-primary">Importa da NASA</strong> appare solo per i corpi senza immagine.</li>
            <li>• Il pulsante <strong class="text-admin-accent">Forza import</strong> sostituisce l'immagine esistente.</li>
        </ul>
    </div>

    <div x-show="modalOpen"
         x-cloak
         role="dialog"
         aria-modal="true"
         aria-labelledby="force-import-title"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60"
         @click.away="modalOpen = false"
         @keydown.escape.window="modalOpen = false">
        <div class="w-full max-w-md rounded-xl p-6 bg-admin-card border border-admin-accent/30"
             @click.stop>
            <h3 id="force-import-title" class="text-lg font-semibold mb-2 text-admin-text">Force Import All</h3>
            <p class="text-sm mb-6 text-gray-400">
                Vuoi davvero importare le immagini dalla NASA per <strong class="text-admin-text">tutti</strong> i corpi celesti?<br>
                Le immagini esistenti verranno sovrascritte.
            </p>
            <div class="flex justify-end gap-3">
                <button type="button"
                        @click="modalOpen = false"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-gray-500/25 text-gray-400 bg-gray-500/15">
                    Annulla
                </button>
                <form method="POST" action="{{ route('admin.nasa-import.import-all') }}">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:brightness-110 bg-admin-accent text-white">
                        Avvia importazione
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
