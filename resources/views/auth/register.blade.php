<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <h2 class="text-2xl font-bold text-center" style="color: #F0F0FA;">Registrati</h2>

        <div>
            <label for="name" class="block text-sm font-medium mb-2" style="color: #B8B8D0;">Nome</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="w-full px-4 py-3 rounded-lg text-sm focus:outline-none focus:ring-2 transition-all duration-200"
                   style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                   onfocus="this.style.borderColor='#22D3EE'"
                   onblur="this.style.borderColor='rgba(34,211,238,0.2)'">
            @error('name')
                <p class="mt-2 text-sm" style="color: #F97316;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium mb-2" style="color: #B8B8D0;">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="w-full px-4 py-3 rounded-lg text-sm focus:outline-none focus:ring-2 transition-all duration-200"
                   style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                   onfocus="this.style.borderColor='#22D3EE'"
                   onblur="this.style.borderColor='rgba(34,211,238,0.2)'">
            @error('email')
                <p class="mt-2 text-sm" style="color: #F97316;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-2" style="color: #B8B8D0;">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full px-4 py-3 rounded-lg text-sm focus:outline-none focus:ring-2 transition-all duration-200"
                   style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                   onfocus="this.style.borderColor='#22D3EE'"
                   onblur="this.style.borderColor='rgba(34,211,238,0.2)'">
            @error('password')
                <p class="mt-2 text-sm" style="color: #F97316;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium mb-2" style="color: #B8B8D0;">Conferma Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full px-4 py-3 rounded-lg text-sm focus:outline-none focus:ring-2 transition-all duration-200"
                   style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                   onfocus="this.style.borderColor='#22D3EE'"
                   onblur="this.style.borderColor='rgba(34,211,238,0.2)'">
            @error('password_confirmation')
                <p class="mt-2 text-sm" style="color: #F97316;">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full py-3 px-4 rounded-lg text-sm font-bold transition-all duration-200"
                style="background-color: #22D3EE; color: #0A0A1A;"
                onmouseover="this.style.backgroundColor='#1BBFE0'"
                onmouseout="this.style.backgroundColor='#22D3EE'">
            Registrati
        </button>

        <p class="text-center text-sm" style="color: #9CA3AF;">
            Hai già un account?
            <a href="{{ route('login') }}" class="font-medium hover:underline" style="color: #A855F7;">Accedi</a>
        </p>
    </form>
</x-guest-layout>
