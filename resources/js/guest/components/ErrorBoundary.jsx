import { Component } from 'react';
import { Link } from 'react-router-dom';
import { ArrowLeft, AlertTriangle } from 'lucide-react';

export default class ErrorBoundary extends Component {
    state = { hasError: false, error: null };

    static getDerivedStateFromError(error) {
        return { hasError: true, error };
    }

    componentDidCatch(error, info) {
        console.error('ErrorBoundary caught:', error, info);
    }

    render() {
        if (this.state.hasError) {
            return (
                <div className="max-w-5xl mx-auto px-4 py-20 text-center">
                    <AlertTriangle size={64} style={{ color: '#F97316' }} className="mx-auto mb-4" />
                    <h2 className="text-2xl font-bold mb-2" style={{ color: '#F0F0FA' }}>Qualcosa è andato storto</h2>
                    <p className="mb-6" style={{ color: '#B8B8D0' }}>Si è verificato un errore imprevisto. Ricarica la pagina o torna alla home.</p>
                    <Link to="/" className="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all"
                        style={{ backgroundColor: 'rgba(34, 211, 238, 0.15)', color: '#22D3EE' }}>
                        <ArrowLeft size={16} /> Torna alla home
                    </Link>
                </div>
            );
        }

        return this.props.children;
    }
}
