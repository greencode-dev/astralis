import { useEffect } from 'react';
import { Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { Sparkles, Telescope, Rocket } from 'lucide-react';
import SolarSystem from '../components/SolarSystem';
import CorpoCard from '../components/CorpoCard';
import { fetchCorpiCelesti, fetchDashboardStats } from '../apiClient';
import { useFetch } from '../hooks/useFetch';

export default function HomePage() {
    const { data: corpiData, loading: corpiLoading } = useFetch(
        signal => fetchCorpiCelesti({ in_evidenza: true, per_page: 6 }, signal), []
    );
    const { data: stats, loading: statsLoading } = useFetch(
        signal => fetchDashboardStats(signal), []
    );

    const loading = corpiLoading || statsLoading;
    const corpiEvidenza = corpiData?.data || [];

    useEffect(() => {
        document.title = 'Astralis — Catalogo di Corpi Celesti';
    }, []);

    return (
        <div>
            {/* Hero */}
            <section className="relative overflow-hidden bg-admin-bg">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
                    <div className="grid lg:grid-cols-2 gap-12 items-center">
                        <motion.div
                            initial={{ opacity: 0, x: -30 }}
                            animate={{ opacity: 1, x: 0 }}
                            transition={{ duration: 0.8 }}
                        >
                            <div className="flex items-center gap-2 mb-4">
                                <Sparkles size={20} className="text-admin-secondary" />
                                <span className="text-sm font-medium text-admin-secondary">
                                    Catalogo Astronomico
                                </span>
                            </div>
                            <h1 className="text-4xl lg:text-6xl font-extrabold leading-tight mb-6 text-admin-text">
                                Esplora{' '}
                                <span className="text-admin-primary">l'Universo</span>
                                <br />
                                con Astralis
                            </h1>
                            <p className="text-lg lg:text-xl mb-8 leading-relaxed text-admin-dim">
                                Un catalogo interattivo di pianeti, stelle, galassie e nebulose.
                                Scopri i segreti del cosmo attraverso dati scientifici e immagini spettacolari.
                            </p>
                            <div className="flex flex-wrap gap-4">
                                <Link
                                    to="/corpi-celesti"
                                    className="inline-flex items-center gap-2 px-6 py-3 rounded-lg font-semibold transition-all duration-200 hover:bg-[#1CB8D0] bg-admin-primary text-admin-bg"
                                >
                                    <Telescope size={20} />
                                    Esplora i Corpi Celesti
                                </Link>
                            </div>

                            {/* Stats */}
                            {stats && (
                                <div className="flex flex-wrap gap-6 mt-10">
                                    <div>
                                        <div className="text-2xl font-bold text-admin-primary">
                                            {stats.totale_corpi_celesti}
                                        </div>
                                        <div className="text-sm text-admin-muted">Corpi Celesti</div>
                                    </div>
                                    <div>
                                        <div className="text-2xl font-bold text-admin-secondary">
                                            {stats.totale_categorie}
                                        </div>
                                        <div className="text-sm text-admin-muted">Categorie</div>
                                    </div>
                                    <div>
                                        <div className="text-2xl font-bold text-admin-accent">
                                            {stats.totale_missioni}
                                        </div>
                                        <div className="text-sm text-admin-muted">Missioni</div>
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
            <section className="bg-admin-bg">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                    <motion.div
                        initial={{ opacity: 0, y: 20 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        transition={{ duration: 0.6 }}
                        viewport={{ once: true }}
                        className="flex items-center gap-3 mb-10"
                    >
                        <Rocket size={24} className="text-admin-warning" />
                        <h2 className="text-2xl lg:text-3xl font-bold text-admin-text">
                            In Evidenza
                        </h2>
                    </motion.div>

                    {loading ? (
                        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            {Array.from({ length: 3 }).map((_, i) => (
                                <div
                                    key={i}
                                    className="rounded-xl animate-pulse bg-admin-card h-[300px]"
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
                        <p className="text-admin-muted">Nessun corpo celeste in evidenza al momento.</p>
                    )}

                    <div className="text-center mt-10">
                        <Link
                            to="/corpi-celesti"
                            className="inline-flex items-center gap-2 px-6 py-3 rounded-lg font-medium transition-all duration-200 hover:bg-[rgba(34,211,238,0.1)] hover:border-[rgba(34,211,238,0.6)] text-admin-primary border border-admin-primary/30"
                        >
                            Vedi tutti i corpi celesti →
                        </Link>
                    </div>
                </div>
            </section>
        </div>
    );
}
