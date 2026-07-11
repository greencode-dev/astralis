<section class="space-y-6">
    <header>
        <h3 class="text-lg font-semibold text-admin-accent">Elimina Account</h3>
        <p class="text-sm mt-1 text-gray-400">Una volta eliminato, tutti i dati verranno rimossi permanentemente.</p>
    </header>

    <div x-data="{ confirm: false }">
        <button type="button" @click="confirm = true"
                class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-accent/15 text-admin-accent hover:bg-admin-accent/25">
            Elimina Account
        </button>

        <div x-show="confirm" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black/60">
            <div @click.away="confirm = false" class="rounded-xl p-8 max-w-md w-full mx-4 bg-admin-card border border-admin-accent/20">
                <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                    @csrf
                    @method('delete')

                    <h3 class="text-lg font-semibold text-admin-text">Sei sicuro?</h3>
                    <p class="text-sm text-gray-400">Una volta eliminato l'account, tutti i dati verranno rimossi permanentemente. Inserisci la tua password per confermare.</p>

                    <div>
                        <label for="password" class="block text-sm font-medium mb-2 text-admin-dim">Password</label>
                        <input id="password" type="password" name="password" required
                               class="admin-input-danger">
                        @error('password')
                            <p class="mt-2 text-sm text-admin-accent">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="button" @click="confirm = false"
                                class="admin-btn-cancel">
                            Annulla
                        </button>
                        <button type="submit"
                                class="px-6 py-2.5 rounded-lg text-sm font-bold transition-all duration-200 bg-admin-accent text-admin-bg hover:brightness-90">
                            Elimina Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
