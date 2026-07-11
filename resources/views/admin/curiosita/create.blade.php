@extends('admin.layouts.app')

@section('title', 'Nuova Curiosità')
@section('page_title', 'Nuova Curiosità')

@section('content')
    <div class="max-w-2xl">
        @include('admin.partials.back-link', ['route' => 'admin.curiosita.index'])

        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
            @include('admin.curiosita._form', ['corpiCelesti' => $corpi])
        </div>
    </div>
@endsection
