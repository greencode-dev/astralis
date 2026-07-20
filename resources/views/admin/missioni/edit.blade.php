@extends('admin.layouts.app')

@section('title', 'Modifica Missione')
@section('page_title', 'Modifica ' . $missione->nome)

@section('content')
    <div class="w-full max-w-3xl mx-auto">
        @include('admin.partials.back-link', ['route' => 'admin.missioni.index'])

        <div class="rounded-xl p-4 sm:p-6 bg-admin-card border border-admin-primary/10">
            @include('admin.missioni._form', ['entity' => $missione])
        </div>
    </div>
@endsection
