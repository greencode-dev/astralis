@extends('admin.layouts.app')

@section('title', 'Categorie')
@section('page_title', 'Categorie')

@section('content')
    @include('admin.partials.index-header', ['description' => 'Gestisci le categorie di corpi celesti', 'createRoute' => 'admin.categorie.create', 'createLabel' => 'Nuova Categoria'])

    @include('admin.partials.search', ['action' => route('admin.categorie.index'), 'placeholder' => 'Cerca per nome...'])

    <div class="rounded-xl overflow-x-auto bg-admin-card border border-admin-primary/10">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-admin-primary/10">
                    <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Icona</th>
                    <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Nome</th>
                    <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Colore</th>
                    <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Descrizione</th>
                    <th scope="col" class="text-center py-3 px-4 font-medium text-gray-400">Corpi</th>
                    <th scope="col" class="text-right py-3 px-4 font-medium text-gray-400">Azioni</th>
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
                    @include('admin.partials.empty-table-row', ['colspan' => 6, 'message' => 'Nessuna categoria trovata', 'createRoute' => 'admin.categorie.create', 'createLabel' => 'Crea la prima categoria'])
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categorie->links() }}
    </div>
@endsection
