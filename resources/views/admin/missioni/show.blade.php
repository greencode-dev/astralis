@extends('admin.layouts.app')

@section('title', $missione->nome)
@section('page_title', $missione->nome)

@section('content')
    <div class="max-w-4xl">
        @include('admin.partials.back-link', ['route' => 'admin.missioni.index'])

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="rounded-xl p-6 flex flex-col items-center text-center bg-admin-card border border-admin-primary/10">
                @if ($missione->logo)
                    <img loading="lazy" src="{{ Storage::url('missioni/' . $missione->logo) }}" alt="{{ $missione->nome }}" class="w-24 h-24 rounded-xl object-cover mb-4 border-2 border-admin-primary/20">
                @else
                    <div class="w-24 h-24 rounded-xl flex items-center justify-center text-3xl mb-4 bg-admin-primary/10 text-admin-primary" role="img" aria-label="{{ $missione->nome }}">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                @endif
                <h2 class="text-xl font-bold mb-1 text-admin-text">{{ $missione->nome }}</h2>
                <p class="text-sm text-gray-400">{{ $missione->agenzia ?? '—' }}</p>
                @include('admin.partials.mission-stato-badge', ['missione' => $missione, 'withDot' => true, 'class' => 'inline-flex items-center gap-1.5 mt-3 px-3 py-1 rounded-full text-xs font-medium'])
            </div>

            <div class="rounded-xl p-6 md:col-span-2 bg-admin-card border border-admin-primary/10">
                <h3 class="text-sm font-medium mb-3 uppercase tracking-wider text-gray-400">Descrizione</h3>
                <p class="text-admin-text leading-[1.7]">{{ $missione->descrizione ?? 'Nessuna descrizione disponibile.' }}</p>

                @include('admin.partials.show-actions', ['editRoute' => route('admin.missioni.edit', $missione), 'deleteRoute' => route('admin.missioni.destroy', $missione), 'entityName' => $missione->nome])
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            @include('admin.partials.stat-card', ['label' => 'Agenzia', 'value' => $missione->agenzia ?? '—'])
            @include('admin.partials.stat-card', ['label' => 'Data lancio', 'value' => $missione->data_lancio?->format('d/m/Y') ?? '—'])
            @include('admin.partials.stat-card', ['label' => 'Durata', 'value' => $missione->durata_giorni ? $missione->durata_giorni . ' giorni' : '—'])
            <div class="rounded-xl p-4 text-center bg-admin-card border border-admin-primary/10">
                <p class="text-xs uppercase tracking-wider mb-1 text-gray-400">Sito web</p>
                <p class="text-sm font-medium text-admin-text">
                    @if ($missione->sito_web)
                        <a href="{{ $missione->sito_web }}" target="_blank" rel="noopener" class="transition-colors duration-150 text-admin-primary hover:text-admin-secondary">Visita →</a>
                    @else
                        —
                    @endif
                </p>
            </div>
        </div>

        @if ($missione->corpiCelesti->count() > 0)
            <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
                <h3 class="text-lg font-semibold mb-4 text-admin-text">Corpi Celesti Esplorati ({{ $missione->corpiCelesti->count() }})</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-admin-primary/10">
                                <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Corpo Celeste</th>
                                <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Categoria</th>
                                <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Tipo esplorazione</th>
                                <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Anno arrivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($missione->corpiCelesti as $corpo)
                                <tr class="border-b border-admin-primary/5">
                                    <td class="py-3 px-4">
                                        <a href="{{ route('admin.corpi-celesti.show', $corpo) }}" class="transition-colors duration-150 text-admin-text hover:text-admin-primary">{{ $corpo->nome }}</a>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if ($corpo->categoria)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: {{ $corpo->categoria->colore }}20; color: {{ $corpo->categoria->colore }};">{{ $corpo->categoria->nome }}</span>
                                        @else
                                            <span class="text-gray-500">—</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-gray-400">{{ $corpo->pivot->tipo_esplorazione ?? '—' }}</td>
                                    <td class="py-3 px-4 text-gray-400">{{ $corpo->pivot->anno_arrivo ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
