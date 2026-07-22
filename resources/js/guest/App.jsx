// Routing React: 5 route (/, /corpi-celesti, /:slug, /confronta, /*). ErrorBoundary wrappa Routes
import { lazy, Suspense } from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Navbar from './components/Navbar';
import Footer from './components/Footer';
import ErrorBoundary from './components/ErrorBoundary';
import ScrollToTop from './components/ScrollToTop';

// Lazy imports: code splitting per pagina (solo quando navigata)
const HomePage = lazy(() => import('./pages/HomePage'));
const CorpiLista = lazy(() => import('./pages/CorpiLista'));
const CorpoDettaglio = lazy(() => import('./pages/CorpoDettaglio'));
const Comparatore = lazy(() => import('./pages/Comparatore'));
const NotFound = lazy(() => import('./pages/NotFound'));

// PageLoader: spinner animato durante caricamento lazy
function PageLoader() {
    return (
        <div className="flex items-center justify-center py-32 bg-admin-bg">
            <div className="w-8 h-8 rounded-full animate-spin border-[3px] border-admin-primary/20 border-t-admin-primary" />
        </div>
    );
}

export default function App() {
    return (
        // BrowserRouter: wrapper routing, include ScrollToTop per reset scroll su navigazione
        <BrowserRouter>
            <ScrollToTop />
            {/* Layout: min-h-screen flex col, bg dark */}
            <div className="min-h-screen flex flex-col bg-admin-bg">
                <Navbar />
                <main className="flex-1">
                    {/* ErrorBoundary + Suspense: doppio wrapping, fallback durante caricamento */}
                    <ErrorBoundary>
                        <Suspense fallback={<PageLoader />}>
                            {/* Routes: 5 route (/, /corpi-celesti, /:slug, /confronta, /*) */}
                            <Routes>
                                <Route path="/" element={<ErrorBoundary><HomePage /></ErrorBoundary>} />
                                <Route path="/corpi-celesti" element={<ErrorBoundary><CorpiLista /></ErrorBoundary>} />
                                <Route path="/corpi-celesti/:slug" element={<ErrorBoundary><CorpoDettaglio /></ErrorBoundary>} />
                                <Route path="/confronta" element={<ErrorBoundary><Comparatore /></ErrorBoundary>} />
                                <Route path="*" element={<NotFound />} />
                            </Routes>
                        </Suspense>
                    </ErrorBoundary>
                </main>
                <Footer />
            </div>
        </BrowserRouter>
    );
}
