@extends('admin.layouts.app')

@section('title', 'Modifica Corpo Celeste')
@section('page_title', 'Modifica ' . $corpoCeleste->nome)

@section('content')
    <div>
        @include('admin.partials.back-link', ['route' => 'admin.corpi-celesti.index'])

        <div class="rounded-xl p-4 sm:p-6 bg-admin-card border border-admin-primary/10">
            @include('admin.corpi-celesti._form', ['entity' => $corpoCeleste, 'categorie' => $categorie])
        </div>
    </div>
@endsection
@include('admin.partials.nasa-suggest-js')
