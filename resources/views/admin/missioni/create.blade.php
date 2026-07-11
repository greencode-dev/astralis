@extends('admin.layouts.app')

@section('title', 'Nuova Missione')
@section('page_title', 'Nuova Missione')

@section('content')
    <div class="max-w-2xl">
        @include('admin.partials.back-link', ['route' => 'admin.missioni.index'])

        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
            @include('admin.missioni._form')
        </div>
    </div>
@endsection
