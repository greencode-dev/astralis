<section class="space-y-6">
    <header>
        <h3 class="text-lg font-semibold" style="color: #F97316;">Elimina Account</h3>
        <p class="text-sm mt-1" style="color: #9CA3AF;">Una volta eliminato, tutti i dati verranno rimossi permanentemente.</p>
    </header>

    <div x-data="{ confirm: false }">
        <button type="button" @click="confirm = true"
                class="py-3 px-4 rounded-lg text-sm font-bold transition-all duration-200"
                style="background-color: rgba(249, 115, 22, 0.15); color: #F97316;"
                onmouseover="this.style.backgroundColor='rgba(249,115,22,0.3)'"
                onmouseout="this.style.backgroundColor='rgba(249,115,22,0.15)'">
            Elimina Account
        </button>

        <div x-show="confirm" x-cloak class="fixed inset-0 flex items-center justify-center z-50" style="background-color: rgba(0,0,0,0.6);">
            <div @click.away="confirm = false" class="rounded-xl p-8 max-w-md w-full mx-4" style="background-color: #111128; border: 1px solid rgba(249, 115, 22, 0.2);">
                <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                    @csrf
                    @method('delete')

                    <h3 class="text-lg font-semibold" style="color: #F0F0FA;">Sei sicuro?</h3>
                    <p class="text-sm" style="color: #9CA3AF;">Una volta eliminato l'account, tutti i dati verranno rimossi permanentemente. Inserisci la tua password per confermare.</p>

                    <div>
                        <label for="password" class="block text-sm font-medium mb-2" style="color: #B8B8D0;">Password</label>
                        <input id="password" type="password" name="password" required
                               class="w-full px-4 py-3 rounded-lg text-sm focus:outline-none focus:ring-2 transition-all duration-200"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(249, 115, 22, 0.3);"
                               onfocus="this.style.borderColor='#F97316'"
                               onblur="this.style.borderColor='rgba(249,115,22,0.3)'">
                        @error('password')
                            <p class="mt-2 text-sm" style="color: #F97316;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="button" @click="confirm = false"
                                class="py-3 px-4 rounded-lg text-sm font-medium transition-all duration-200"
                                style="color: #9CA3AF; border: 1px solid rgba(34, 211, 238, 0.2);"
                                onmouseover="this.style.color='#22D3EE'"
                                onmouseout="this.style.color='#9CA3AF'">
                            Annulla
                        </button>
                        <button type="submit"
                                class="py-3 px-4 rounded-lg text-sm font-bold transition-all duration-200"
                                style="background-color: #F97316; color: #0A0A1A;"
                                onmouseover="this.style.backgroundColor='#E8630A'"
                                onmouseout="this.style.backgroundColor='#F97316'">
                            Elimina Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
