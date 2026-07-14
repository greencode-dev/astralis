export default function Footer() {
    return (
        <footer className="bg-admin-card border-t border-admin-primary/10">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div className="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div className="flex items-center gap-2">
                        <img src="/favicon.svg" alt="" className="h-8 w-8" />
                        <span className="font-bold font-orbitron text-admin-primary">Astralis</span>
                        <span className="text-sm text-admin-muted">— Catalogo di Corpi Celesti</span>
                    </div>
                    <p className="text-sm text-admin-muted">
                        Esplora l'universo attraverso i nostri dati
                    </p>
                </div>
            </div>
        </footer>
    );
}
