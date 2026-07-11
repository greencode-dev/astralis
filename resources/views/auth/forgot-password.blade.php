<x-guest-layout>
    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <h2 class="text-2xl font-bold text-center text-admin-text">Password dimenticata</h2>

        <p class="text-sm text-center text-gray-400">
            Riceverai un link per reimpostare la password via email.
        </p>

        <div>
            <label for="email" class="block text-sm font-medium mb-2 text-admin-dim">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="admin-input" placeholder="nome@esempio.it">
            @error('email')
                <p class="mt-2 text-sm text-admin-accent">{{ $message }}</p>
            @enderror
        </div>

        @if (session('status'))
            <p class="text-sm text-center text-green-500">{{ session('status') }}</p>
        @endif

        <button type="submit" class="admin-btn-primary w-full py-3">
            Invia link
        </button>

        <p class="text-center text-sm text-gray-400">
            <a href="{{ route('login') }}" class="font-medium hover:underline text-admin-secondary">Torna al login</a>
        </p>
    </form>
</x-guest-layout>
