@extends('admin.layouts.app')

@section('title', 'Categorie')
@section('page_title', 'Categorie')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <p class="text-sm text-gray-400">Gestisci le categorie di corpi celesti</p>
        <a href="{{ route('admin.categorie.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-primary text-admin-bg hover:brightness-90">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuova Categoria
        </a>
    </div>

    @include('admin.partials.flash')

    @include('admin.partials.search', ['action' => route('admin.categorie.index'), 'placeholder' => 'Cerca per nome...'])

    <div class="rounded-xl overflow-x-auto bg-admin-card border border-admin-primary/10">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-admin-primary/10">
                    <th class="text-left py-3 px-4 font-medium text-gray-400">Icona</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-400">Nome</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-400">Colore</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-400">Descrizione</th>
                    <th class="text-center py-3 px-4 font-medium text-gray-400">Corpi</th>
                    <th class="text-right py-3 px-4 font-medium text-gray-400">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categorie as $categoria)
                    <tr class="border-b border-admin-primary/5 hover:bg-admin-primary/3">
                        <td class="py-3 px-4 text-lg">{{ $categoria->icona ?? '📂' }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.categorie.show', $categoria) }}" class="font-medium transition-colors duration-150 text-admin-text hover:text-admin-primary">
                                {{ $categoria->nome }}
                            </a>
                        </td>
                        <td class="py-3 px-4">
                            @if ($categoria->colore)
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium"
                                      style="background-color: {{ $categoria->colore }}20; color: {{ $categoria->colore }};">
                                    <span class="w-2 h-2 rounded-full" style="background-color: {{ $categoria->colore }};"></span>
                                    {{ $categoria->colore }}
                                </span>
                            @else
                                <span class="text-gray-500">—</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-gray-400 max-w-[300px]">{{ Str::limit($categoria->descrizione, 60) ?? '—' }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold bg-admin-primary/15 text-admin-primary">
                                {{ $categoria->corpi_celesti_count }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            @include('admin.partials.index-actions', ['showRoute' => route('admin.categorie.show', $categoria), 'editRoute' => route('admin.categorie.edit', $categoria), 'deleteRoute' => route('admin.categorie.destroy', $categoria), 'entityName' => $categoria->nome])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <p class="text-lg mb-2 text-gray-500">Nessuna categoria trovata</p>
                            <a href="{{ route('admin.categorie.create') }}" class="text-sm font-medium transition-colors duration-150 text-admin-primary hover:text-admin-secondary">Crea la prima categoria</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categorie->links() }}
    </div>
@endsection
