@extends('admin.layouts.app')

@section('title', 'NASA Import')
@section('page_title', 'NASA Import')

@section('content')
    <div x-data="{ modalOpen: false }">
        <div class="mb-6">
            <p class="text-sm" style="color: #9CA3AF;">Importa immagini dalla NASA Image Library per ogni corpo celeste.</p>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg text-sm" style="background-color: rgba(34, 197, 94, 0.15); color: #22C55E; border: 1px solid rgba(34, 197, 94, 0.2);">
                {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="mb-6 p-4 rounded-lg text-sm" style="background-color: rgba(249, 115, 22, 0.15); color: #F97316; border: 1px solid rgba(249, 115, 22, 0.2);">
                {{ session('warning') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 rounded-lg text-sm" style="background-color: rgba(239, 68, 68, 0.15); color: #EF4444; border: 1px solid rgba(239, 68, 68, 0.2);">
                {{ session('error') }}
            </div>
        @endif

    <div class="mb-6 flex justify-end">
        <button type="button"
                @click="modalOpen = true"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                style="background-color: rgba(249, 115, 22, 0.15); color: #F97316; border: 1px solid rgba(249, 115, 22, 0.2);"
                onmouseover="this.style.backgroundColor='rgba(249,115,22,0.25)'; this.style.borderColor='rgba(249,115,22,0.4)';"
                onmouseout="this.style.backgroundColor='rgba(249,115,22,0.15)'; this.style.borderColor='rgba(249,115,22,0.2)';">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Force Import All
        </button>
    </div>

    <div class="rounded-xl overflow-hidden" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
        <table class="w-full text-sm">
            <thead>
                <tr style="border-bottom: 1px solid rgba(34, 211, 238, 0.1);">
                    <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Corpo Celeste</th>
                    <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Categoria</th>
                    <th class="text-center py-3 px-4 font-medium" style="color: #9CA3AF;">Immagine</th>
                    <th class="text-right py-3 px-4 font-medium" style="color: #9CA3AF;">Azione</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($corpi as $corpo)
                    <tr style="border-bottom: 1px solid rgba(34, 211, 238, 0.05);" class="transition-colors duration-150" onmouseover="this.style.backgroundColor='rgba(34,211,238,0.03)';" onmouseout="this.style.backgroundColor='transparent';">
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                @if ($corpo->immagine)
                                    <img loading="lazy" src="{{ $corpo->immagine_url }}"
                                         alt="{{ $corpo->nome }}"
                                         class="w-8 h-8 rounded-full object-cover"
                                         style="border: 1px solid rgba(34, 211, 238, 0.2);">
                                @else
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm" style="background-color: rgba(34, 211, 238, 0.1); color: #22D3EE;">
                                        ★
                                    </div>
                                @endif
                                <a href="{{ route('admin.corpi-celesti.show', $corpo) }}" class="font-medium transition-colors duration-150" style="color: #F0F0FA;" onmouseover="this.style.color='#22D3EE';" onmouseout="this.style.color='#F0F0FA';">
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
                                <span style="color: #6B7280;">—</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center">
                            @if ($corpo->immagine)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: rgba(34, 197, 94, 0.15); color: #22C55E;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Presente
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: rgba(107, 114, 128, 0.15); color: #9CA3AF;">
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
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200"
                                            style="background-color: rgba(249, 115, 22, 0.15); color: #F97316; border: 1px solid rgba(249, 115, 22, 0.2);"
                                            onmouseover="this.style.backgroundColor='rgba(249,115,22,0.25)'; this.style.borderColor='rgba(249,115,22,0.4)';"
                                            onmouseout="this.style.backgroundColor='rgba(249,115,22,0.15)'; this.style.borderColor='rgba(249,115,22,0.2)';">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        Forza import
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.nasa-import.import', $corpo) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200"
                                            style="background-color: rgba(34, 211, 238, 0.15); color: #22D3EE; border: 1px solid rgba(34, 211, 238, 0.2);"
                                            onmouseover="this.style.backgroundColor='rgba(34,211,238,0.25)'; this.style.borderColor='rgba(34,211,238,0.4)';"
                                            onmouseout="this.style.backgroundColor='rgba(34,211,238,0.15)'; this.style.borderColor='rgba(34,211,238,0.2)';">
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
                            <p class="text-lg" style="color: #6B7280;">Nessun corpo celeste trovato</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 p-4 rounded-lg" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
        <h3 class="text-sm font-semibold mb-2" style="color: #F0F0FA;">Note</h3>
        <ul class="text-xs space-y-1" style="color: #9CA3AF;">
            <li>• Le immagini vengono cercate su <a href="https://images.nasa.gov" target="_blank" class="transition-colors" style="color: #22D3EE;" onmouseover="this.style.color='#A855F7';" onmouseout="this.style.color='#22D3EE';">images.nasa.gov</a> usando il nome del corpo celeste.</li>
            <li>• Le immagini vengono ridimensionate a 800px (lato lungo) e salvate in <code style="color: #FACC15;">storage/app/public/corpi-celesti/</code>.</li>
            <li>• Il pulsante <strong style="color: #22D3EE;">Importa da NASA</strong> appare solo per i corpi senza immagine.</li>
            <li>• Il pulsante <strong style="color: #F97316;">Forza import</strong> sostituisce l'immagine esistente.</li>
        </ul>
    </div>

    <div x-show="modalOpen"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="background-color: rgba(0, 0, 0, 0.6);"
         @click.away="modalOpen = false">
        <div class="w-full max-w-md rounded-xl p-6"
             style="background-color: #111128; border: 1px solid rgba(249, 115, 22, 0.3);"
             @click.stop>
            <h3 class="text-lg font-semibold mb-2" style="color: #F0F0FA;">Force Import All</h3>
            <p class="text-sm mb-6" style="color: #9CA3AF;">
                Vuoi davvero importare le immagini dalla NASA per <strong style="color: #F0F0FA;">tutti</strong> i corpi celesti?<br>
                Le immagini esistenti verranno sovrascritte.
            </p>
            <div class="flex justify-end gap-3">
                <button type="button"
                        @click="modalOpen = false"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                        style="color: #9CA3AF; background-color: rgba(107, 114, 128, 0.15);"
                        onmouseover="this.style.backgroundColor='rgba(107,114,128,0.25)';"
                        onmouseout="this.style.backgroundColor='rgba(107,114,128,0.15)';">
                    Annulla
                </button>
                <form method="POST" action="{{ route('admin.nasa-import.import-all') }}">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                            style="background-color: #F97316; color: #fff;"
                            onmouseover="this.style.backgroundColor='#ea580c';"
                            onmouseout="this.style.backgroundColor='#F97316';">
                        Avvia importazione
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
