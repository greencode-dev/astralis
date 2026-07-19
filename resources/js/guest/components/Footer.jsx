export default function Footer() {
    return (
        <footer className="border-t bg-admin-card border-admin-primary/10">
            <div className="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div className="flex flex-col items-center justify-between gap-4 md:flex-row">
                    <div className="flex items-center gap-2">
                        <img src="/astralis_solo_logo_bianco.png" alt="Astralis" className="w-10 h-10" />
                        <span className="font-bold font-orbitron text-admin-primary">
                            Astralis
                        </span>
                        <span className="text-sm text-admin-muted">
                            — Catalogo di Corpi Celesti
                        </span>
                    </div>
                    <p className="text-sm text-admin-muted">
                        Esplora l'universo attraverso i nostri dati
                    </p>
                </div>
            </div>
        </footer>
    );
}
