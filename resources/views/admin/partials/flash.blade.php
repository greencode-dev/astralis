@if (session('success'))
    <div class="mb-6 p-4 rounded-lg text-sm bg-green-500/15 text-green-500 border border-green-500/20">
        {{ session('success') }}
    </div>
@endif

@if (session('warning'))
    <div class="mb-6 p-4 rounded-lg text-sm bg-admin-accent/15 text-admin-accent border border-admin-accent/20">
        {{ session('warning') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-6 p-4 rounded-lg text-sm bg-red-500/15 text-red-500 border border-red-500/20">
        {{ session('error') }}
    </div>
@endif
