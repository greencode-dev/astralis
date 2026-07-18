@extends('admin.layouts.app')

@section('title', 'Corpi Celesti')
@section('page_title', 'Corpi Celesti')

@section('content')
    @include('admin.partials.index-header', ['description' => 'Gestisci i corpi celesti del catalogo', 'createRoute' => 'admin.corpi-celesti.create', 'createLabel' => 'Nuovo Corpo Celeste'])

    @include('admin.partials.search', ['action' => route('admin.corpi-celesti.index'), 'placeholder' => 'Cerca per nome...'])

    <div class="rounded-xl overflow-x-auto bg-admin-card border border-admin-primary/10">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-admin-primary/10">
                    <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Nome</th>
                    <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Categoria</th>
                    <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Tipo</th>
                    <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Distanza (km)</th>
                    <th scope="col" class="text-center py-3 px-4 font-medium text-gray-400">Evidenza</th>
                    <th scope="col" class="text-right py-3 px-4 font-medium text-gray-400">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($corpi as $corpo)
                    <tr class="border-b border-admin-primary/5 hover:bg-admin-primary/3">
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                @if ($corpo->immagine)
                                    <img loading="lazy" src="{{ $corpo->immagine_url }}"
                                         alt="{{ $corpo->nome_display }}"
                                          class="w-8 h-8 rounded-full object-cover border border-admin-primary/20">
                                @else
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm bg-admin-primary/10 text-admin-primary" role="img" aria-label="{{ $corpo->nome_display }}">
                                        ★
                                    </div>
                                @endif
                                <a href="{{ route('admin.corpi-celesti.show', $corpo) }}" class="font-medium transition-colors duration-150 text-admin-text hover:text-admin-primary">
                                    {{ $corpo->nome_display }}
                                </a>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            @include('admin.partials.category-badge', ['color' => $corpo->categoria->colore ?? null, 'name' => $corpo->categoria->nome ?? null])
                        </td>
                        <td class="py-3 px-4 text-gray-400">{{ $corpo->tipo ?? '—' }}</td>
                        <td class="py-3 px-4 text-gray-400 font-mono text-[0.8rem]">{{ $corpo->distanza_km ?? '—' }}</td>
                        <td class="py-3 px-4 text-center">
                            @include('admin.partials.in-evidenza-badge', ['show' => $corpo->in_evidenza])
                            @if (! $corpo->in_evidenza)
                                <span class="text-gray-500">—</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-right">
                            @include('admin.partials.index-actions', ['showRoute' => route('admin.corpi-celesti.show', $corpo), 'editRoute' => route('admin.corpi-celesti.edit', $corpo), 'deleteRoute' => route('admin.corpi-celesti.destroy', $corpo), 'entityName' => $corpo->nome_display])
                        </td>
                    </tr>
                @empty
                    @include('admin.partials.empty-table-row', ['colspan' => 6, 'message' => 'Nessun corpo celeste trovato', 'createRoute' => 'admin.corpi-celesti.create', 'createLabel' => 'Crea il primo corpo celeste'])
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $corpi->links() }}
    </div>
@endsection
