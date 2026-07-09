import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { Sparkles, Telescope, Rocket } from 'lucide-react';
import SolarSystem from '../components/SolarSystem';
import CorpoCard from '../components/CorpoCard';
import { fetchCorpiCelesti, fetchDashboardStats } from '../apiClient';

export default function HomePage() {
    const [corpiEvidenza, setCorpiEvidenza] = useState([]);
    const [stats, setStats] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        document.title = 'Astralis — Catalogo di Corpi Celesti';
    }, []);

    useEffect(() => {
        async function loadData() {
            try {
                const [corpiRes, statsData] = await Promise.all([
                    fetchCorpiCelesti({ in_evidenza: true, per_page: 6 }),
                    fetchDashboardStats(),
                ]);
                setCorpiEvidenza(corpiRes.data || []);
                setStats(statsData);
            } catch (err) {
                console.error('Errore caricamento homepage:', err);
            } finally {
                setLoading(false);
            }
        }
        loadData();
    }, []);

    return (
        <div>
            {/* Hero */}
            <section className="relative overflow-hidden" style={{ backgroundColor: '#0A0A1A' }}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
                    <div className="grid lg:grid-cols-2 gap-12 items-center">
                        <motion.div
                            initial={{ opacity: 0, x: -30 }}
                            animate={{ opacity: 1, x: 0 }}
                            transition={{ duration: 0.8 }}
                        >
                            <div className="flex items-center gap-2 mb-4">
                                <Sparkles size={20} style={{ color: '#A855F7' }} />
                                <span className="text-sm font-medium" style={{ color: '#A855F7' }}>
                                    Catalogo Astronomico
                                </span>
                            </div>
                            <h1 className="text-4xl lg:text-6xl font-extrabold leading-tight mb-6" style={{ color: '#F0F0FA' }}>
                                Esplora{' '}
                                <span style={{ color: '#22D3EE' }}>l'Universo</span>
                                <br />
                                con Astralis
                            </h1>
                            <p className="text-lg lg:text-xl mb-8 leading-relaxed" style={{ color: '#B8B8D0' }}>
                                Un catalogo interattivo di pianeti, stelle, galassie e nebulose.
                                Scopri i segreti del cosmo attraverso dati scientifici e immagini spettacolari.
                            </p>
                            <div className="flex flex-wrap gap-4">
                                <Link
                                    to="/corpi-celesti"
                                    className="inline-flex items-center gap-2 px-6 py-3 rounded-lg font-semibold transition-all duration-200 hover:bg-[#1CB8D0]"
                                    style={{
                                        backgroundColor: '#22D3EE',
                                        color: '#0A0A1A',
                                    }}
                                >
                                    <Telescope size={20} />
                                    Esplora i Corpi Celesti
                                </Link>
                            </div>

                            {/* Stats */}
                            {stats && (
                                <div className="flex flex-wrap gap-6 mt-10">
                                    <div>
                                        <div className="text-2xl font-bold" style={{ color: '#22D3EE' }}>
                                            {stats.totale_corpi_celesti}
                                        </div>
                                        <div className="text-sm" style={{ color: '#7A7A9A' }}>Corpi Celesti</div>
                                    </div>
                                    <div>
                                        <div className="text-2xl font-bold" style={{ color: '#A855F7' }}>
                                            {stats.totale_categorie}
                                        </div>
                                        <div className="text-sm" style={{ color: '#7A7A9A' }}>Categorie</div>
                                    </div>
                                    <div>
                                        <div className="text-2xl font-bold" style={{ color: '#F97316' }}>
                                            {stats.totale_missioni}
                                        </div>
                                        <div className="text-sm" style={{ color: '#7A7A9A' }}>Missioni</div>
                                    </div>
                                </div>
                            )}
                        </motion.div>

                        <motion.div
                            initial={{ opacity: 0, scale: 0.9 }}
                            animate={{ opacity: 1, scale: 1 }}
                            transition={{ duration: 1, delay: 0.3 }}
                            className="hidden lg:block"
                        >
                            <SolarSystem />
                        </motion.div>
                    </div>
                </div>
            </section>

            {/* In Evidenza */}
            <section style={{ backgroundColor: '#0A0A1A' }}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                    <motion.div
                        initial={{ opacity: 0, y: 20 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        transition={{ duration: 0.6 }}
                        viewport={{ once: true }}
                        className="flex items-center gap-3 mb-10"
                    >
                        <Rocket size={24} style={{ color: '#FACC15' }} />
                        <h2 className="text-2xl lg:text-3xl font-bold" style={{ color: '#F0F0FA' }}>
                            In Evidenza
                        </h2>
                    </motion.div>

                    {loading ? (
                        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            {Array.from({ length: 3 }).map((_, i) => (
                                <div
                                    key={i}
                                    className="rounded-xl animate-pulse"
                                    style={{ backgroundColor: '#111128', height: 300 }}
                                />
                            ))}
                        </div>
                    ) : corpiEvidenza.length > 0 ? (
                        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            {corpiEvidenza.map(corpo => (
                                <motion.div
                                    key={corpo.id}
                                    initial={{ opacity: 0, y: 20 }}
                                    whileInView={{ opacity: 1, y: 0 }}
                                    transition={{ duration: 0.5 }}
                                    viewport={{ once: true }}
                                >
                                    <CorpoCard corpo={corpo} />
                                </motion.div>
                            ))}
                        </div>
                    ) : (
                        <p style={{ color: '#7A7A9A' }}>Nessun corpo celeste in evidenza al momento.</p>
                    )}

                    <div className="text-center mt-10">
                        <Link
                            to="/corpi-celesti"
                            className="inline-flex items-center gap-2 px-6 py-3 rounded-lg font-medium transition-all duration-200 hover:bg-[rgba(34,211,238,0.1)] hover:border-[rgba(34,211,238,0.6)]"
                            style={{
                                color: '#22D3EE',
                                border: '1px solid rgba(34, 211, 238, 0.3)',
                            }}
                        >
                            Vedi tutti i corpi celesti →
                        </Link>
                    </div>
                </div>
            </section>
        </div>
    );
}