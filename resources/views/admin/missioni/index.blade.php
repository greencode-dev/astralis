@extends('admin.layouts.app')

@section('title', 'Missioni')
@section('page_title', 'Missioni')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <p class="text-sm text-gray-400">Gestisci le missioni spaziali</p>
        <a href="{{ route('admin.missioni.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-primary text-admin-bg hover:brightness-90">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuova Missione
        </a>
    </div>

    @include('admin.partials.flash')

    @include('admin.partials.search', ['action' => route('admin.missioni.index'), 'placeholder' => 'Cerca per nome...', 'extraFilters' => ['agenzia', 'stato']])

    <div class="rounded-xl overflow-x-auto bg-admin-card border border-admin-primary/10">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-admin-primary/10">
                    <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Logo</th>
                    <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Nome</th>
                    <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Agenzia</th>
                    <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Lancio</th>
                    <th scope="col" class="text-center py-3 px-4 font-medium text-gray-400">Stato</th>
                    <th scope="col" class="text-right py-3 px-4 font-medium text-gray-400">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($missioni as $missione)
                    <tr class="border-b border-admin-primary/5 hover:bg-admin-primary/3">
                        <td class="py-3 px-4">
                            @if ($missione->logo)
                                <img loading="lazy" src="{{ Storage::url('missioni/' . $missione->logo) }}" alt="{{ $missione->nome }}" class="w-8 h-8 rounded-lg object-cover border border-admin-primary/20">
                            @else
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm bg-admin-primary/10 text-admin-primary" role="img" aria-label="{{ $missione->nome }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.missioni.show', $missione) }}" class="font-medium transition-colors duration-150 text-admin-text hover:text-admin-primary">{{ $missione->nome }}</a>
                        </td>
                        <td class="py-3 px-4 text-gray-400">{{ $missione->agenzia ?? '—' }}</td>
                        <td class="py-3 px-4 text-gray-400">{{ $missione->data_lancio ? $missione->data_lancio->format('d/m/Y') : '—' }}</td>
                        <td class="py-3 px-4 text-center">
                            @include('admin.partials.mission-stato-badge', ['missione' => $missione])
                        </td>
                        <td class="py-3 px-4 text-right">
                            @include('admin.partials.index-actions', ['showRoute' => route('admin.missioni.show', $missione), 'editRoute' => route('admin.missioni.edit', $missione), 'deleteRoute' => route('admin.missioni.destroy', $missione), 'entityName' => $missione->nome])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <p class="text-lg mb-2 text-gray-500">Nessuna missione trovata</p>
                            <a href="{{ route('admin.missioni.create') }}" class="text-sm font-medium transition-colors duration-150 text-admin-primary hover:text-admin-secondary">Crea la prima missione</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $missioni->links() }}
    </div>
@endsection
