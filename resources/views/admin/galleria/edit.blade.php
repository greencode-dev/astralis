@extends('admin.layouts.app')

@section('title', 'Modifica Immagine')
@section('page_title', 'Modifica Immagine')

@section('content')
    <div class="max-w-2xl">
        @include('admin.partials.back-link', ['route' => 'admin.galleria.index'])

        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
            @include('admin.galleria._form', ['entity' => $galleriaCorpo, 'corpiCelesti' => $corpi])
        </div>
    </div>
@endsection
