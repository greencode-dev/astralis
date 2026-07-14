@section('title', 'Profilo')
@section('page_title', 'Profilo')

<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-8">
        @include('profile.partials.update-profile-information-form')

        <div class="border-t border-admin-primary/10"></div>

        @include('profile.partials.update-password-form')

        <div class="border-t border-admin-primary/10"></div>

        @include('profile.partials.delete-user-form')
    </div>
</x-app-layout>
