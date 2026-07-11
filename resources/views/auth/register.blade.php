<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <h2 class="text-2xl font-bold text-center text-admin-text">Registrati</h2>

        <div>
            <label for="name" class="block text-sm font-medium mb-2 text-admin-dim">Nome</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="admin-input" placeholder="Il tuo nome">
            @error('name')
                <p class="mt-2 text-sm text-admin-accent">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium mb-2 text-admin-dim">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="admin-input" placeholder="nome@esempio.it">
            @error('email')
                <p class="mt-2 text-sm text-admin-accent">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-2 text-admin-dim">Password</label>
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
            Registrati
        </button>

        <p class="text-center text-sm text-gray-400">
            Hai già un account?
            <a href="{{ route('login') }}" class="font-medium hover:underline text-admin-secondary">Accedi</a>
        </p>
    </form>
</x-guest-layout>
