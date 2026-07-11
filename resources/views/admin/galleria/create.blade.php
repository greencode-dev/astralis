@extends('admin.layouts.app')

@section('title', 'Nuova Immagine')
@section('page_title', 'Nuova Immagine')

@section('content')
    <div class="max-w-2xl">
        @include('admin.partials.back-link', ['route' => 'admin.galleria.index'])

        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
            @include('admin.galleria._form', ['corpiCelesti' => $corpi])
        </div>
    </div>
@endsection
