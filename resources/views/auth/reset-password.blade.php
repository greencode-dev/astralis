<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <h2 class="text-2xl font-bold text-center text-admin-text">Reimposta password</h2>

        <div>
            <label for="email" class="block text-sm font-medium mb-2 text-admin-dim">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', request()->email) }}" required autofocus autocomplete="username"
                   class="admin-input" placeholder="nome@esempio.it">
            @error('email')
                <p class="mt-2 text-sm text-admin-accent">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-2 text-admin-dim">Nuova Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="admin-input" placeholder="Minimo 8 caratteri">
            @error('password')
                <p class="mt-2 text-sm text-admin-accent">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium mb-2 text-admin-dim">Conferma Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="admin-input" placeholder="Ripeti la password">
            @error('password_confirmation')
                <p class="mt-2 text-sm text-admin-accent">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="admin-btn-primary w-full py-3">
            Reimposta password
        </button>
    </form>
</x-guest-layout>
