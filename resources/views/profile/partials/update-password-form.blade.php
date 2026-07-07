<section class="space-y-6">
    <header>
        <h3 class="text-lg font-semibold" style="color: #F0F0FA;">Aggiorna Password</h3>
        <p class="text-sm mt-1" style="color: #9CA3AF;">Assicurati di usare una password lunga e sicura.</p>
    </header>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        @method('put')

        <div>
            <label for="current_password" class="block text-sm font-medium mb-2" style="color: #B8B8D0;">Password Attuale</label>
            <input id="current_password" type="password" name="current_password" required autocomplete="current-password"
                   class="w-full px-4 py-3 rounded-lg text-sm focus:outline-none focus:ring-2 transition-all duration-200"
                   style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                   onfocus="this.style.borderColor='#22D3EE'"
                   onblur="this.style.borderColor='rgba(34,211,238,0.2)'">
            @error('current_password')
                <p class="mt-2 text-sm" style="color: #F97316;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-2" style="color: #B8B8D0;">Nuova Password</label>
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

        <div class="flex items-center gap-4">
            <button type="submit"
                    class="py-3 px-4 rounded-lg text-sm font-bold transition-all duration-200"
                    style="background-color: #22D3EE; color: #0A0A1A;"
                    onmouseover="this.style.backgroundColor='#1BBFE0'"
                    onmouseout="this.style.backgroundColor='#22D3EE'">
                Salva
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-sm" style="color: #22C55E;">Salvato.</p>
            @endif
        </div>
    </form>
</section>
