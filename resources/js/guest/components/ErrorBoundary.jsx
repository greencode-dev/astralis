import { Component } from 'react';
import { Link } from 'react-router-dom';
import { ArrowLeft, AlertTriangle, RotateCcw } from 'lucide-react';

export default class ErrorBoundary extends Component {
    state = { hasError: false, error: null };

    static getDerivedStateFromError(error) {
        return { hasError: true, error };
    }

    componentDidCatch(error, info) {
        console.error('ErrorBoundary caught:', error, info);
    }

    handleRetry = () => {
        this.setState({ hasError: false, error: null });
    };

    render() {
        if (this.state.hasError) {
            return (
                <div className="min-h-screen flex items-center justify-center" style={{ backgroundColor: '#0A0A1A' }}>
                    <div className="max-w-md mx-auto px-4 py-20 text-center">
                        <AlertTriangle size={64} style={{ color: '#F97316' }} className="mx-auto mb-4" />
                        <h2 className="text-2xl font-bold mb-2" style={{ color: '#F0F0FA' }}>Qualcosa è andato storto</h2>
                        <p className="mb-8" style={{ color: '#B8B8D0' }}>Si è verificato un errore imprevisto. Prova a riprovare o torna alla home.</p>
                        <div className="flex items-center justify-center gap-4">
                            <button onClick={this.handleRetry}
                                className="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all hover:bg-[rgba(34,211,238,0.2)]"
                                style={{ backgroundColor: 'rgba(34, 211, 238, 0.15)', color: '#22D3EE' }}>
                                <RotateCcw size={16} /> Riprova
                            </button>
                            <Link to="/"
                                className="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all hover:bg-[rgba(168,85,247,0.2)]"
                                style={{ backgroundColor: 'rgba(168, 85, 247, 0.1)', color: '#A855F7' }}>
                                <ArrowLeft size={16} /> Torna alla home
                            </Link>
                        </div>
                    </div>
                </div>
            );
        }

        return this.props.children;
    }
}
