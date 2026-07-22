@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
    {{-- Grafici --}}
    @if($corpiPerCategoria->isNotEmpty() || $corpiPerTipo->isNotEmpty() || !empty(array_filter($missioniPerStato)))
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            @if($corpiPerCategoria->isNotEmpty())
                <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
                    <h3 class="text-lg font-semibold mb-4 text-admin-text">Corpi per Categoria</h3>
                    <div class="h-64">
                        <canvas id="chart-categorie" role="img" aria-label="Grafico a ciambella: distribuzione corpi celesti per categoria"></canvas>
                    </div>
                </div>
            @endif

            @if($corpiPerTipo->isNotEmpty())
                <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
                    <h3 class="text-lg font-semibold mb-4 text-admin-text">Corpi per Tipo</h3>
                    <div class="h-64">
                        <canvas id="chart-tipi" role="img" aria-label="Grafico a barre: corpi celesti per tipo"></canvas>
                    </div>
                </div>
            @endif

            @if(!empty(array_filter($missioniPerStato)))
                <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
                    <h3 class="text-lg font-semibold mb-4 text-admin-text">Missioni per Stato</h3>
                    <div class="h-64">
                        <canvas id="chart-missioni" role="img" aria-label="Grafico a barre orizzontali: missioni per stato"></canvas>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @include('admin.partials.dashboard-stat', ['color' => 'primary', 'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'value' => $stats['corpi_celesti'], 'label' => 'Corpi Celesti', 'route' => 'admin.corpi-celesti.index', 'meta' => $statMeta['corpi_celesti']])
        @include('admin.partials.dashboard-stat', ['color' => 'secondary', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z', 'value' => $stats['categorie'], 'label' => 'Categorie', 'route' => 'admin.categorie.index', 'meta' => $statMeta['categorie']])
        @include('admin.partials.dashboard-stat', ['color' => 'accent', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'value' => $stats['missioni'], 'label' => 'Missioni', 'route' => 'admin.missioni.index', 'meta' => $statMeta['missioni']])
        @include('admin.partials.dashboard-stat', ['color' => 'warning', 'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'value' => $stats['curiosita'], 'label' => 'Curiosità', 'route' => 'admin.curiosita.index', 'meta' => $statMeta['curiosita']])
    </div>

    <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
        <h3 class="text-lg font-semibold mb-4 text-admin-text">Ultimi Corpi Celesti</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-admin-primary/10">
                        <th scope="col" class="text-left py-3 px-4 font-medium text-admin-dim">Nome</th>
                        <th scope="col" class="text-left py-3 px-4 font-medium text-admin-dim">Categoria</th>
                        <th scope="col" class="text-left py-3 px-4 font-medium text-admin-dim">Tipo</th>
                        <th scope="col" class="text-left py-3 px-4 font-medium text-admin-dim">Distanza (km)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ultimiCorpi as $corpo)
                        <tr class="border-b border-admin-primary/5">
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.corpi-celesti.show', $corpo) }}" class="text-admin-text hover:text-admin-primary transition-colors">
                                    {{ $corpo->nome }}
                                </a>
                            </td>
                            <td class="py-3 px-4">
                                  @include('admin.partials.category-badge', ['color' => $corpo->categoria?->colore, 'name' => $corpo->categoria?->nome ?? '-'])
                            </td>
                            <td class="py-3 px-4 text-admin-dim">{{ $corpo->tipo }}</td>
                            <td class="py-3 px-4 text-admin-dim">{{ $corpo->distanza_km ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-admin-dim">Nessun corpo celeste trovato.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') return;

            var rootStyle = getComputedStyle(document.documentElement);
            var chartText = rootStyle.getPropertyValue('--color-admin-chart-text').trim() || '#9CA3AF';
            var gridColor = 'rgba(255, 255, 255, 0.05)';
            var cardColor = rootStyle.getPropertyValue('--color-admin-card').trim() || '#111128';
            var primary = rootStyle.getPropertyValue('--color-admin-primary').trim() || '#22D3EE';
            var secondary = rootStyle.getPropertyValue('--color-admin-secondary').trim() || '#A855F7';
            var accent = rootStyle.getPropertyValue('--color-admin-accent').trim() || '#F97316';
            var success = rootStyle.getPropertyValue('--color-admin-success').trim() || '#22C55E';
            var warning = rootStyle.getPropertyValue('--color-admin-warning').trim() || '#FACC15';

            Chart.defaults.color = chartText;
            Chart.defaults.borderColor = gridColor;

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
                            borderColor: cardColor,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
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
                            backgroundColor: [primary, secondary, accent],
                            borderRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: chartText } },
                            x: { grid: { display: false }, ticks: { color: chartText } }
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
                            backgroundColor: [success, primary, warning],
                            borderRadius: 6,
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: chartText } },
                            y: { grid: { display: false }, ticks: { color: chartText } }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            }
        });
    </script>
@endpush
