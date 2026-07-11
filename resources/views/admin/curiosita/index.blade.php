@extends('admin.layouts.app')

@section('title', 'Curiosità')
@section('page_title', 'Curiosità')

@section('content')
    @include('admin.partials.index-header', ['description' => 'Gestisci le curiosità sui corpi celesti', 'createRoute' => 'admin.curiosita.create', 'createLabel' => 'Nuova Curiosità'])

    @include('admin.partials.search', ['action' => route('admin.curiosita.index'), 'placeholder' => 'Cerca per nome...'])

    <div class="rounded-xl overflow-x-auto bg-admin-card border border-admin-primary/10">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-admin-primary/10">
                    <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Titolo</th>
                    <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Corpo Celeste</th>
                    <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Descrizione</th>
                    <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Fonte</th>
                    <th scope="col" class="text-right py-3 px-4 font-medium text-gray-400">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($curiosita as $curiositum)
                    <tr class="border-b border-admin-primary/5 hover:bg-admin-primary/3">
                        <td class="py-3 px-4 font-medium text-admin-text">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4 shrink-0 text-admin-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $curiositum->titolo }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.corpi-celesti.show', $curiositum->corpoCeleste) }}"
                               class="transition-colors duration-150 text-admin-primary hover:text-admin-secondary">
                                {{ $curiositum->corpoCeleste->nome }}
                            </a>
                        </td>
                        <td class="py-3 px-4 text-gray-400 max-w-[300px]">{{ Str::limit($curiositum->descrizione, 80) }}</td>
                        <td class="py-3 px-4 text-gray-500 max-w-[150px]">{{ $curiositum->fonte ? Str::limit($curiositum->fonte, 40) : '—' }}</td>
                        <td class="py-3 px-4 text-right">
                            @include('admin.partials.index-actions', ['showRoute' => route('admin.curiosita.show', $curiositum), 'editRoute' => route('admin.curiosita.edit', $curiositum), 'deleteRoute' => route('admin.curiosita.destroy', $curiositum), 'entityName' => $curiositum->titolo])
                        </td>
                    </tr>
                @empty
                    @include('admin.partials.empty-table-row', ['colspan' => 5, 'message' => 'Nessuna curiosità trovata', 'createRoute' => 'admin.curiosita.create', 'createLabel' => 'Crea la prima curiosità'])
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $curiosita->links() }}
    </div>
@endsection
