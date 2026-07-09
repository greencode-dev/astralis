import { useEffect } from 'react';
import { Link } from 'react-router-dom';
import { ArrowLeft, Telescope } from 'lucide-react';

export default function NotFound() {
    useEffect(() => {
        document.title = 'Pagina non trovata — Astralis';
    }, []);

    return (
        <div className="max-w-5xl mx-auto px-4 py-20 text-center">
            <Telescope size={64} style={{ color: '#7A7A9A' }} className="mx-auto mb-4" />
            <h2 className="text-2xl font-bold mb-2" style={{ color: '#F0F0FA' }}>Pagina non trovata</h2>
            <p className="mb-6" style={{ color: '#B8B8D0' }}>La pagina che cerchi non esiste o è stata spostata.</p>
            <Link to="/" className="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all"
                style={{ backgroundColor: 'rgba(34, 211, 238, 0.15)', color: '#22D3EE' }}>
                <ArrowLeft size={16} /> Torna alla home
            </Link>
        </div>
    );
}
