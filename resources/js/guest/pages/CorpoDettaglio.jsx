import { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';
import { ArrowLeft, Ruler, Weight, Thermometer, Gauge, MapPin, Calendar, User, Star, Rocket, Lightbulb, Orbit as OrbitIcon } from 'lucide-react';
import { fetchCorpoCeleste, fetchSimili } from '../apiClient';
import { useFetch } from '../hooks/useFetch';
import { categoryIcons, categoryGradients } from '../constants';
import { formatScientific, formatNumber, formatDistance } from '../utils';
import CategoriaBadge from '../components/CategoriaBadge';
import LightboxGalleria from '../components/LightboxGalleria';
import TimelineMissioni from '../components/TimelineMissioni';
import CorpoCard from '../components/CorpoCard';

const metriche = [
    { key: 'massa_kg', label: 'Massa', icon: Weight, format: v => formatScientific(v) + ' kg' },
    { key: 'diametro_km', label: 'Diametro', icon: Ruler, format: v => formatNumber(v) + ' km' },
    { key: 'distanza_km', label: 'Distanza dal Sole', icon: MapPin, format: v => formatDistance(v) },
    { key: 'gravita', label: 'Gravità', icon: Gauge, format: v => Number(v) + ' m/s²' },
    { key: 'temperatura', label: 'Temperatura', icon: Thermometer, format: v => Number(v) + ' °C' },
    { key: 'periodo_orbitale', label: 'Periodo Orbitale', icon: OrbitIcon, format: v => formatNumber(v) + ' giorni' },
];

export default function CorpoDettaglio() {
    const { slug } = useParams();

    const [heroImgError, setHeroImgError] = useState(false);
    const [simili, setSimili] = useState([]);

    const { data: corpoData, loading, error } = useFetch(
        signal => fetchCorpoCeleste(slug, signal), [slug]
    );
    const corpo = corpoData?.data || corpoData;

    useEffect(() => {
        if (!corpo?.slug) return;
        const controller = new AbortController();
        fetchSimili(corpo.slug, controller.signal)
            .then(res => setSimili(res?.data || []))
            .catch(() => {});
        return () => controller.abort();
    }, [corpo?.slug]);

    useEffect(() => {
        document.title = 'Astralis — Corpo Celeste';
    }, []);

    useEffect(() => {
        if (corpo?.nome_display || corpo?.nome) {
            document.title = `${corpo.nome_display || corpo.nome} — Astralis`;
        }
    }, [corpo]);

    if (loading) {
        return (
            <div className="max-w-5xl mx-auto px-4 py-10">
                <div className="animate-pulse space-y-6">
                    <div className="h-64 rounded-xl bg-admin-card" />
                    <div className="h-8 w-1/3 rounded bg-admin-card" />
                    <div className="h-4 w-2/3 rounded bg-admin-card" />
                </div>
            </div>
        );
    }

    if (error || !corpo) {
        return (
            <div className="max-w-5xl mx-auto px-4 py-20 text-center">
                <Rocket size={64} className="mx-auto mb-4 text-admin-accent" />
                <h2 className="text-2xl font-bold mb-2 text-admin-text">Corpo celeste non trovato</h2>
                <p className="mb-6 text-admin-dim">Il corpo celeste che cerchi non esiste o è stato rimosso.</p>
                <Link to="/corpi-celesti" className="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all bg-admin-primary/15 text-admin-primary">
                    <ArrowLeft size={16} /> Torna alla lista
                </Link>
            </div>
        );
    }

    const FallbackIcon = categoryIcons[corpo.categoria?.nome] || OrbitIcon;
    const gradient = categoryGradients[corpo.categoria?.nome] || 'linear-gradient(135deg, #4B5563, #6B7280)';

    return (
        <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <Link to="/corpi-celesti" className="inline-flex items-center gap-2 text-sm font-medium mb-6 transition-all hover:opacity-70 text-admin-primary">
                <ArrowLeft size={16} /> Torna alla lista
            </Link>

            <div className="animate-fade-up relative rounded-2xl overflow-hidden mb-8 min-h-[300px]">
                {corpo.immagine_url && !heroImgError ? (
                    <img loading="lazy" src={corpo.immagine_url} alt={corpo.nome_display || corpo.nome}
                        className="w-full h-64 lg:h-80 object-cover"
                        onError={() => setHeroImgError(true)} />
                ) : (
                    <div className="w-full h-64 lg:h-80 flex items-center justify-center"
                        style={{ background: gradient }}
                        role="img"
                        aria-label={corpo.nome_display || corpo.nome}>
                        <FallbackIcon size={96} className="text-white/40" aria-hidden="true" />
                    </div>
                )}
                <div className="absolute inset-0" style={{ background: 'linear-gradient(transparent 40%, #0A0A1A)' }} />
                <div className="absolute bottom-0 left-0 right-0 p-6 lg:p-8">
                    <div className="flex items-center gap-3 mb-2">
                        <CategoriaBadge categoria={corpo.categoria} />
                        {corpo.in_evidenza && (
                            <span className="text-xs font-bold px-2 py-0.5 rounded bg-admin-warning/15 text-admin-warning">
                                ★ In evidenza
                            </span>
                        )}
                    </div>
                    <h1 className="text-3xl lg:text-5xl font-extrabold text-admin-text">{corpo.nome_display || corpo.nome}</h1>
                    {corpo.tipo && <p className="text-lg mt-1 text-admin-dim">{corpo.tipo}</p>}
                </div>
            </div>

            <div className="grid lg:grid-cols-3 gap-8">
                <div className="lg:col-span-2 space-y-8">
                    <section className="animate-fade-up" style={{ animationDelay: '0.2s' }}>
                        <p className="text-base leading-relaxed text-admin-dim">{corpo.descrizione}</p>
                    </section>

                    <section className="animate-fade-up" style={{ animationDelay: '0.3s' }}>
                        <h2 className="text-xl font-bold mb-4 flex items-center gap-2 text-admin-text">
                            <Ruler size={20} className="text-admin-primary" /> Dati Scientifici
                        </h2>
                        <div className="grid grid-cols-2 md:grid-cols-3 gap-4">
                            {metriche.filter(m => corpo[m.key] !== null && corpo[m.key] !== undefined).map(m => (
                                <div key={m.key} className="rounded-xl p-4 bg-admin-card border border-admin-primary/8">
                                    <div className="flex items-center gap-2 mb-2">
                                        <m.icon size={14} className="text-admin-primary" />
                                        <span className="text-xs font-medium text-admin-muted">{m.label}</span>
                                    </div>
                                    <p className="text-sm font-semibold text-admin-text">{m.format(corpo[m.key])}</p>
                                </div>
                            ))}
                        </div>
                    </section>

                    {(corpo.scopritore || corpo.anno_scoperta) && (
                        <section className="animate-fade-up flex gap-6 flex-wrap" style={{ animationDelay: '0.35s' }}>
                            {corpo.scopritore && (
                                <div className="flex items-center gap-2 text-sm text-admin-dim">
                                    <User size={14} className="text-admin-secondary" />
                                    Scoperto da: <span className="font-medium text-admin-text">{corpo.scopritore}</span>
                                </div>
                            )}
                            {corpo.anno_scoperta && (
                                <div className="flex items-center gap-2 text-sm text-admin-dim">
                                    <Calendar size={14} className="text-admin-secondary" />
                                    Anno: <span className="font-medium text-admin-text">{corpo.anno_scoperta}</span>
                                </div>
                            )}
                        </section>
                    )}

                    {corpo.galleria && corpo.galleria.length > 0 && (
                        <section className="animate-fade-up" style={{ animationDelay: '0.4s' }}>
                            <h2 className="text-xl font-bold mb-4 flex items-center gap-2 text-admin-text">
                                <Star size={20} className="text-admin-primary" /> Galleria
                            </h2>
                            <LightboxGalleria immagini={corpo.galleria} />
                        </section>
                    )}

                    {corpo.curiosita && corpo.curiosita.length > 0 && (
                        <section className="animate-fade-up" style={{ animationDelay: '0.45s' }}>
                            <h2 className="text-xl font-bold mb-4 flex items-center gap-2 text-admin-text">
                                <Lightbulb size={20} className="text-admin-warning" /> Curiosità
                            </h2>
                            <div className="space-y-4">
                                {corpo.curiosita.map(cur => (
                                    <div key={cur.id} className="rounded-xl p-4 bg-admin-card border border-admin-primary/8">
                                        <h3 className="font-semibold mb-1 text-admin-text">{cur.titolo}</h3>
                                        <p className="text-sm leading-relaxed text-admin-dim">{cur.descrizione}</p>
                                        {cur.fonte && (
                                            <p className="text-xs mt-2 text-admin-muted">Fonte: {cur.fonte}</p>
                                        )}
                                    </div>
                                ))}
                            </div>
                        </section>
                    )}
                </div>

                <div className="space-y-8">
                    {corpo.missioni && corpo.missioni.length > 0 && (
                        <section className="animate-slide-right" style={{ animationDelay: '0.4s' }}>
                            <h2 className="text-xl font-bold mb-4 flex items-center gap-2 text-admin-text">
                                <Rocket size={20} className="text-admin-accent" /> Missioni
                            </h2>
                            <TimelineMissioni missioni={corpo.missioni} />
                        </section>
                    )}

                    {corpo.categoria?.nome === 'Pianeta' && (
                        <div className="animate-slide-right" style={{ animationDelay: '0.5s' }}>
                            <Link to={`/confronta?primo=${corpo.slug}`}
                                className="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 hover:bg-[rgba(168,85,247,0.2)] hover:border-[rgba(168,85,247,0.4)] bg-admin-secondary/10 text-admin-secondary border border-admin-secondary/20">
                                <OrbitIcon size={16} /> Confronta con un altro pianeta
                            </Link>
                        </div>
                    )}
                </div>
            </div>

            {simili.length > 0 && (
                <section className="animate-fade-up mt-12" style={{ animationDelay: '0.5s' }}>
                    <h2 className="text-xl font-bold mb-6 flex items-center gap-2 text-admin-text">
                        <Star size={20} className="text-admin-primary" /> Corpi Simili
                    </h2>
                    <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        {simili.map(s => (
                            <CorpoCard key={s.id} corpo={s} />
                        ))}
                    </div>
                </section>
            )}
        </div>
    );
}
