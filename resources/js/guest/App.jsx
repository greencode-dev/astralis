import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Navbar from './components/Navbar';
import Footer from './components/Footer';
import ErrorBoundary from './components/ErrorBoundary';
import HomePage from './pages/HomePage';
import CorpiLista from './pages/CorpiLista';
import CorpoDettaglio from './pages/CorpoDettaglio';
import Comparatore from './pages/Comparatore';
import NotFound from './pages/NotFound';

export default function App() {
    return (
        <BrowserRouter>
            <div className="min-h-screen flex flex-col" style={{ backgroundColor: '#0A0A1A' }}>
                <Navbar />
                <main className="flex-1">
                    <ErrorBoundary>
                    <Routes>
                        <Route path="/" element={<HomePage />} />
                        <Route path="/corpi-celesti" element={<CorpiLista />} />
                        <Route path="/corpi-celesti/:slug" element={<CorpoDettaglio />} />
                        <Route path="/confronta" element={<Comparatore />} />
                        <Route path="*" element={<NotFound />} />
                    </Routes>
                    </ErrorBoundary>
                </main>
                <Footer />
            </div>
        </BrowserRouter>
    );
}