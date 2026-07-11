@extends('admin.layouts.app')

@section('title', 'Modifica Categoria')
@section('page_title', 'Modifica Categoria')

@section('content')
    <div class="max-w-2xl">
        @include('admin.partials.back-link', ['route' => 'admin.categorie.index'])

        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
            @include('admin.categorie._form', ['entity' => $categoria])
        </div>
    </div>
@endsection

@include('admin.partials.color-picker-js')
