@extends('admin.layouts.app')

@section('title', $curiositum->titolo)
@section('page_title', $curiositum->titolo)

@section('content')
    <div class="max-w-3xl">
        @include('admin.partials.back-link', ['route' => 'admin.curiosita.index'])

        <div class="rounded-xl overflow-hidden bg-admin-card border border-admin-primary/10">
            <div class="p-6 space-y-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-400 mb-1">Corpo Celeste</h3>
                    <a href="{{ route('admin.corpi-celesti.show', $curiositum->corpoCeleste) }}"
                       class="text-admin-primary hover:text-admin-secondary transition-colors duration-150">
                        {{ $curiositum->corpoCeleste->nome }}
                    </a>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-400 mb-1">Descrizione</h3>
                    <p class="text-admin-text leading-relaxed">{{ $curiositum->descrizione }}</p>
                </div>

                @if ($curiositum->fonte)
                    <div>
                        <h3 class="text-sm font-medium text-gray-400 mb-1">Fonte</h3>
                        <p class="text-admin-text">{{ $curiositum->fonte }}</p>
                    </div>
                @endif
            </div>

            <div class="px-6 py-4 border-t border-admin-primary/10">
                @include('admin.partials.show-actions', ['editRoute' => route('admin.curiosita.edit', $curiositum), 'deleteRoute' => route('admin.curiosita.destroy', $curiositum), 'entityName' => $curiositum->titolo])
            </div>
        </div>
    </div>
@endsection
