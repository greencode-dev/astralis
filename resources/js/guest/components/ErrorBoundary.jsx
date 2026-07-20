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
        window.location.reload();
    };

    render() {
        if (this.state.hasError) {
            return (
                <div className="min-h-screen flex items-center justify-center bg-admin-bg">
                    <div className="max-w-md mx-auto px-4 py-20 text-center">
                        <AlertTriangle size={64} className="mx-auto mb-4 text-admin-accent" />
                        <h2 className="text-2xl font-bold mb-2 text-admin-text">Qualcosa è andato storto</h2>
                        <p className="mb-8 text-admin-dim">Si è verificato un errore imprevisto. Prova a riprovare o torna alla home.</p>
                        <div className="flex items-center justify-center gap-4">
                            <button onClick={this.handleRetry}
                                className="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all hover:bg-admin-primary/20 bg-admin-primary/15 text-admin-primary">
                                <RotateCcw size={16} /> Riprova
                            </button>
                            <Link to="/"
                                className="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all hover:bg-[rgba(168,85,247,0.2)] bg-admin-secondary/10 text-admin-secondary">
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
