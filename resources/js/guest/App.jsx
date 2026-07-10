import { lazy, Suspense } from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Navbar from './components/Navbar';
import Footer from './components/Footer';
import ErrorBoundary from './components/ErrorBoundary';

const HomePage = lazy(() => import('./pages/HomePage'));
const CorpiLista = lazy(() => import('./pages/CorpiLista'));
const CorpoDettaglio = lazy(() => import('./pages/CorpoDettaglio'));
const Comparatore = lazy(() => import('./pages/Comparatore'));
const NotFound = lazy(() => import('./pages/NotFound'));

function PageLoader() {
    return (
        <div className="flex items-center justify-center py-32" style={{ backgroundColor: '#0A0A1A' }}>
            <div className="w-8 h-8 rounded-full animate-spin" style={{ border: '3px solid rgba(34, 211, 238, 0.2)', borderTopColor: '#22D3EE' }} />
        </div>
    );
}

export default function App() {
    return (
        <BrowserRouter>
            <div className="min-h-screen flex flex-col" style={{ backgroundColor: '#0A0A1A' }}>
                <ErrorBoundary>
                    <Navbar />
                    <main className="flex-1">
                        <Suspense fallback={<PageLoader />}>
                            <Routes>
                                <Route path="/" element={<HomePage />} />
                                <Route path="/corpi-celesti" element={<CorpiLista />} />
                                <Route path="/corpi-celesti/:slug" element={<CorpoDettaglio />} />
                                <Route path="/confronta" element={<Comparatore />} />
                                <Route path="*" element={<NotFound />} />
                            </Routes>
                        </Suspense>
                    </main>
                    <Footer />
                </ErrorBoundary>
            </div>
        </BrowserRouter>
    );
}