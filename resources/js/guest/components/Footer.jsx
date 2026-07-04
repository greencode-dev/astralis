export default function Footer() {
    return (
        <footer style={{ backgroundColor: '#111128', borderTop: '1px solid rgba(34, 211, 238, 0.1)' }}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div className="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div className="flex items-center gap-2">
                        <span className="text-lg">🚀</span>
                        <span className="font-bold" style={{ color: '#22D3EE' }}>Astralis</span>
                        <span className="text-sm" style={{ color: '#7A7A9A' }}>— Catalogo di Corpi Celesti</span>
                    </div>
                    <p className="text-sm" style={{ color: '#7A7A9A' }}>
                        Esplora l'universo attraverso i nostri dati
                    </p>
                </div>
            </div>
        </footer>
    );
}