@extends('admin.layouts.app')

@section('title', 'Corpi Celesti')
@section('page_title', 'Corpi Celesti')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <p class="text-sm text-gray-400">Gestisci i corpi celesti del catalogo</p>
        <a href="{{ route('admin.corpi-celesti.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-primary text-admin-bg hover:brightness-90">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuovo Corpo Celeste
        </a>
    </div>

    @include('admin.partials.flash')

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
                            @if ($corpo->categoria)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                      style="background-color: {{ $corpo->categoria->colore }}20; color: {{ $corpo->categoria->colore }};">
                                    {{ $corpo->categoria->nome }}
                                </span>
                            @else
                                <span class="text-gray-500">—</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-gray-400">{{ $corpo->tipo ?? '—' }}</td>
                        <td class="py-3 px-4 text-gray-400 font-mono text-[0.8rem]">{{ $corpo->distanza_km ?? '—' }}</td>
                        <td class="py-3 px-4 text-center">
                            @if ($corpo->in_evidenza)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-400/15 text-yellow-400">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    In evidenza
                                </span>
                            @else
                                <span class="text-gray-500">—</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-right">
                            @include('admin.partials.index-actions', ['showRoute' => route('admin.corpi-celesti.show', $corpo), 'editRoute' => route('admin.corpi-celesti.edit', $corpo), 'deleteRoute' => route('admin.corpi-celesti.destroy', $corpo), 'entityName' => $corpo->nome_display])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <p class="text-lg mb-2 text-gray-500">Nessun corpo celeste trovato</p>
                            <a href="{{ route('admin.corpi-celesti.create') }}" class="text-sm font-medium transition-colors duration-150 text-admin-primary hover:text-admin-secondary">Crea il primo corpo celeste</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $corpi->links() }}
    </div>
@endsection
