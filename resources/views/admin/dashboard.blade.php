@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/15">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-admin-primary/15">
                    <svg class="w-6 h-6 text-admin-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-admin-primary">{{ $stats['corpi_celesti'] }}</p>
            <p class="text-sm mt-1 text-gray-400">Corpi Celesti</p>
        </div>

        <div class="rounded-xl p-6 bg-admin-card border border-admin-secondary/15">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-admin-secondary/15">
                    <svg class="w-6 h-6 text-admin-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-admin-secondary">{{ $stats['categorie'] }}</p>
            <p class="text-sm mt-1 text-gray-400">Categorie</p>
        </div>

        <div class="rounded-xl p-6 bg-admin-card border border-admin-accent/15">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-admin-accent/15">
                    <svg class="w-6 h-6 text-admin-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-admin-accent">{{ $stats['missioni'] }}</p>
            <p class="text-sm mt-1 text-gray-400">Missioni</p>
        </div>

        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/15">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-admin-primary/15">
                    <svg class="w-6 h-6 text-admin-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-admin-primary">{{ $stats['curiosita'] }}</p>
            <p class="text-sm mt-1 text-gray-400">Curiosità</p>
        </div>
    </div>

    <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
        <h3 class="text-lg font-semibold mb-4 text-admin-text">Ultimi Corpi Celesti</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-admin-primary/10">
                        <th class="text-left py-3 px-4 font-medium text-gray-400">Nome</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-400">Categoria</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-400">Tipo</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-400">Distanza (km)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ultimiCorpi as $corpo)
                        <tr class="border-b border-admin-primary/5">
                            <td class="py-3 px-4 text-admin-text">{{ $corpo->nome }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                      style="background-color: {{ $corpo->categoria?->colore ?? '#22D3EE' }}20; color: {{ $corpo->categoria?->colore ?? '#22D3EE' }};">
                                    {{ $corpo->categoria?->nome ?? '-' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-400">{{ $corpo->tipo }}</td>
                            <td class="py-3 px-4 text-gray-400">{{ $corpo->distanza_km ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-gray-400">Nessun corpo celeste trovato.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
