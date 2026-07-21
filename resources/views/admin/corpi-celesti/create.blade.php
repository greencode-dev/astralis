@extends('admin.layouts.app')

@section('title', 'Nuovo Corpo Celeste')
@section('page_title', 'Nuovo Corpo Celeste')

@section('content')
    <div>
        @include('admin.partials.back-link', ['route' => 'admin.corpi-celesti.index'])

        <div class="rounded-xl p-4 sm:p-6 bg-admin-card border border-admin-primary/10">
            @include('admin.corpi-celesti._form', ['categorie' => $categorie])
        </div>
    </div>
@endsection


