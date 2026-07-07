<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-8">
        @include('profile.partials.update-profile-information-form')

        <div style="border-top: 1px solid rgba(34, 211, 238, 0.1);"></div>

        @include('profile.partials.update-password-form')

        <div style="border-top: 1px solid rgba(34, 211, 238, 0.1);"></div>

        @include('profile.partials.delete-user-form')
    </div>

    @push('scripts')
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <style>[x-cloak] { display: none !important; }</style>
    @endpush
</x-app-layout>
