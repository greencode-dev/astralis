import { useEffect } from 'react';
import { Link } from 'react-router-dom';
import { ArrowLeft, Telescope } from 'lucide-react';

export default function NotFound() {
    useEffect(() => {
        document.title = 'Pagina non trovata — Astralis';
    }, []);

    return (
        <div className="max-w-5xl mx-auto px-4 py-20 text-center">
            <Telescope size={64} className="mx-auto mb-4 text-admin-muted" />
            <h2 className="text-2xl font-bold mb-2 text-admin-text">Pagina non trovata</h2>
            <p className="mb-6 text-admin-dim">La pagina che cerchi non esiste o è stata spostata.</p>
            <Link to="/" className="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all bg-admin-primary/15 text-admin-primary">
                <ArrowLeft size={16} /> Torna alla home
            </Link>
        </div>
    );
}
