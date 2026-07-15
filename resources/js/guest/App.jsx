import { lazy, Suspense } from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Navbar from './components/Navbar';
import Footer from './components/Footer';
import ErrorBoundary from './components/ErrorBoundary';
import ScrollToTop from './components/ScrollToTop';

const HomePage = lazy(() => import('./pages/HomePage'));
const CorpiLista = lazy(() => import('./pages/CorpiLista'));
const CorpoDettaglio = lazy(() => import('./pages/CorpoDettaglio'));
const Comparatore = lazy(() => import('./pages/Comparatore'));
const NotFound = lazy(() => import('./pages/NotFound'));

function PageLoader() {
    return (
        <div className="flex items-center justify-center py-32 bg-admin-bg">
            <div className="w-8 h-8 rounded-full animate-spin border-[3px] border-admin-primary/20 border-t-admin-primary" />
        </div>
    );
}

export default function App() {
    return (
        <BrowserRouter>
            <ScrollToTop />
            <div className="min-h-screen flex flex-col bg-admin-bg">
                <Navbar />
                <main className="flex-1">
                    <ErrorBoundary>
                        <Suspense fallback={<PageLoader />}>
                            <Routes>
                                <Route path="/" element={<HomePage />} />
                                <Route path="/corpi-celesti" element={<CorpiLista />} />
                                <Route path="/corpi-celesti/:slug" element={<CorpoDettaglio />} />
                                <Route path="/confronta" element={<Comparatore />} />
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
