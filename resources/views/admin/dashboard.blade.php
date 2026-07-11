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
                                       style="background-color: {{ $corpo->categoria?->colore ?? 'var(--admin-primary)' }}20; color: {{ $corpo->categoria?->colore ?? 'var(--admin-primary)' }};">
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

    {{-- Grafici --}}
    @if($corpiPerCategoria->isNotEmpty() || $corpiPerTipo->isNotEmpty())
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
            @if($corpiPerCategoria->isNotEmpty())
                <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
                    <h3 class="text-lg font-semibold mb-4 text-admin-text">Corpi per Categoria</h3>
                    <canvas id="chart-categorie" height="250" role="img" aria-label="Grafico a ciambella: distribuzione corpi celesti per categoria"></canvas>
                </div>
            @endif

            @if($corpiPerTipo->isNotEmpty())
                <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
                    <h3 class="text-lg font-semibold mb-4 text-admin-text">Corpi per Tipo</h3>
                    <canvas id="chart-tipi" height="250" role="img" aria-label="Grafico a barre: corpi celesti per tipo"></canvas>
                </div>
            @endif

            @if(!empty(array_filter($missioniPerStato)))
                <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10 {{ $corpiPerTipo->isNotEmpty() && $corpiPerCategoria->isNotEmpty() ? 'lg:col-span-2 max-w-md mx-auto w-full' : '' }}">
                    <h3 class="text-lg font-semibold mb-4 text-admin-text">Missioni per Stato</h3>
                    <canvas id="chart-missioni" height="200" role="img" aria-label="Grafico a barre orizzontali: missioni per stato"></canvas>
                </div>
            @endif
        </div>
    @endif
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"
            onerror="this.onerror=null;var s=document.createElement('script');s.src='https://unpkg.com/chart.js@4.4.7/dist/chart.umd.min.js';document.head.appendChild(s);"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Chart.defaults.color = 'var(--admin-chart-text)';
            Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.05)';

            var chartCategorie = document.getElementById('chart-categorie');
            if (chartCategorie) {
                new Chart(chartCategorie, {
                    type: 'doughnut',
                    data: {
                        labels: @json($corpiPerCategoria->pluck('nome')),
                        datasets: [{
                            data: @json($corpiPerCategoria->pluck('count')),
                            backgroundColor: @json($corpiPerCategoria->pluck('colore')),
                            borderWidth: 2,
                            borderColor: 'var(--admin-card)',
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'right', labels: { padding: 12, usePointStyle: true } }
                        }
                    }
                });
            }

            var chartTipi = document.getElementById('chart-tipi');
            if (chartTipi) {
                new Chart(chartTipi, {
                    type: 'bar',
                    data: {
                        labels: @json($corpiPerTipo->pluck('tipo')),
                        datasets: [{
                            label: 'Corpi Celesti',
                            data: @json($corpiPerTipo->pluck('count')),
                            backgroundColor: ['var(--admin-primary)', 'var(--admin-secondary)', 'var(--admin-accent)'],
                            borderRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: 'var(--admin-chart-text)' } },
                            x: { grid: { display: false }, ticks: { color: 'var(--admin-chart-text)' } }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            }

            var chartMissioni = document.getElementById('chart-missioni');
            if (chartMissioni) {
                new Chart(chartMissioni, {
                    type: 'bar',
                    data: {
                        labels: @json(array_keys($missioniPerStato)),
                        datasets: [{
                            label: 'Missioni',
                            data: @json(array_values($missioniPerStato)),
                            backgroundColor: ['var(--admin-success)', 'var(--admin-warning)', 'var(--admin-neutral)'],
                            borderRadius: 6,
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        scales: {
                            x: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: 'var(--admin-chart-text)' } },
                            y: { grid: { display: false }, ticks: { color: 'var(--admin-chart-text)' } }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            }
        });
    </script>
@endpush
