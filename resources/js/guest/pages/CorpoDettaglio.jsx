import { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { ArrowLeft, Ruler, Weight, Thermometer, Gauge, Orbit, MapPin, Calendar, User, Star, Rocket, Lightbulb } from 'lucide-react';
import { fetchCorpoCeleste, fetchSimili } from '../apiClient';
import CategoriaBadge from '../components/CategoriaBadge';
import LightboxGalleria from '../components/LightboxGalleria';
import TimelineMissioni from '../components/TimelineMissioni';
import CorpoCard from '../components/CorpoCard';
import { Globe, Sun, Moon, Stars, Sparkles, Asterisk, Orbit as OrbitIcon } from 'lucide-react';

const categoryIcons = {
    'Pianeta': Globe,
    'Stella': Sun,
    'Luna': Moon,
    'Galassia': Stars,
    'Nebulosa': Sparkles,
    'Asteroide': Asterisk,
    'Cometa': Star,
    'Pianeta Nano': OrbitIcon,
};

const categoryGradients = {
    'Pianeta': 'linear-gradient(135deg, #0EA5E9, #06B6D4)',
    'Stella': 'linear-gradient(135deg, #F97316, #FB923C)',
    'Luna': 'linear-gradient(135deg, #64748B, #94A3B8)',
    'Galassia': 'linear-gradient(135deg, #7C3AED, #A855F7)',
    'Nebulosa': 'linear-gradient(135deg, #DB2777, #F472B6)',
    'Asteroide': 'linear-gradient(135deg, #57534E, #78716C)',
    'Cometa': 'linear-gradient(135deg, #16A34A, #22C55E)',
    'Pianeta Nano': 'linear-gradient(135deg, #4B5563, #6B7280)',
};

const metriche = [
    { key: 'massa_kg', label: 'Massa', icon: Weight, format: v => formatScientific(v) + ' kg' },
    { key: 'diametro_km', label: 'Diametro', icon: Ruler, format: v => formatNumber(v) + ' km' },
    { key: 'distanza_km', label: 'Distanza dal Sole', icon: MapPin, format: v => formatDistance(v) },
    { key: 'gravita', label: 'Gravità', icon: Gauge, format: v => v + ' m/s²' },
    { key: 'temperatura', label: 'Temperatura', icon: Thermometer, format: v => v + ' °C' },
    { key: 'periodo_orbitale', label: 'Periodo Orbitale', icon: Orbit, format: v => formatNumber(v) + ' giorni' },
];

export default function CorpoDettaglio() {
    const { slug } = useParams();
    const [corpo, setCorpo] = useState(null);
    const [simili, setSimili] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(false);

    useEffect(() => {
        async function load() {
            setLoading(true);
            setError(false);
            try {
                const data = await fetchCorpoCeleste(slug);
                setCorpo(data.data || data);
            } catch (err) {
                setError(true);
            } finally {
                setLoading(false);
            }
        }
        load();
    }, [slug]);

    useEffect(() => {
        if (corpo?.id) {
            fetchSimili(corpo.id)
                .then(res => setSimili(res.data || []))
                .catch(err => console.error('Errore caricamento simili:', err));
        }
    }, [corpo?.id]);

    if (loading) {
        return (
            <div className="max-w-5xl mx-auto px-4 py-10">
                <div className="animate-pulse space-y-6">
                    <div className="h-64 rounded-xl" style={{ backgroundColor: '#111128' }} />
                    <div className="h-8 w-1/3 rounded" style={{ backgroundColor: '#111128' }} />
                    <div className="h-4 w-2/3 rounded" style={{ backgroundColor: '#111128' }} />
                </div>
            </div>
        );
    }

    if (error || !corpo) {
        return (
            <div className="max-w-5xl mx-auto px-4 py-20 text-center">
                <Rocket size={64} style={{ color: '#7A7A9A' }} className="mx-auto mb-4" />
                <h2 className="text-2xl font-bold mb-2" style={{ color: '#F0F0FA' }}>Corpo celeste non trovato</h2>
                <p className="mb-6" style={{ color: '#B8B8D0' }}>Il corpo celeste che cerchi non esiste o è stato rimosso.</p>
                <Link to="/corpi-celesti" className="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all"
                    style={{ backgroundColor: 'rgba(34, 211, 238, 0.15)', color: '#22D3EE' }}>
                    <ArrowLeft size={16} /> Torna alla lista
                </Link>
            </div>
        );
    }

    const FallbackIcon = categoryIcons[corpo.categoria?.nome] || OrbitIcon;
    const gradient = categoryGradients[corpo.categoria?.nome] || 'linear-gradient(135deg, #4B5563, #6B7280)';

    return (
        <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {/* Back link */}
            <Link to="/corpi-celesti" className="inline-flex items-center gap-2 text-sm font-medium mb-6 transition-all"
                style={{ color: '#22D3EE' }}
                onMouseEnter={e => e.currentTarget.style.opacity = '0.7'}
                onMouseLeave={e => e.currentTarget.style.opacity = '1'}>
                <ArrowLeft size={16} /> Torna alla lista
            </Link>

            {/* Hero */}
            <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ duration: 0.6 }}
                className="relative rounded-2xl overflow-hidden mb-8" style={{ minHeight: 300 }}>
                {corpo.immagine_url ? (
                    <img loading="lazy" src={corpo.immagine_url} alt={corpo.nome_display || corpo.nome} className="w-full h-64 lg:h-80 object-cover" />
                ) : (
                    <div className="w-full h-64 lg:h-80 flex items-center justify-center" style={{ background: gradient }}
                        role="img"
                        aria-label={corpo.nome_display || corpo.nome}>
                        <FallbackIcon size={96} style={{ color: 'rgba(255,255,255,0.4)' }} aria-hidden="true" />
                    </div>
                )}
                <div className="absolute inset-0" style={{ background: 'linear-gradient(transparent 40%, #0A0A1A)' }} />
                <div className="absolute bottom-0 left-0 right-0 p-6 lg:p-8">
                    <div className="flex items-center gap-3 mb-2">
                        <CategoriaBadge categoria={corpo.categoria} />
                        {corpo.in_evidenza && (
                            <span className="text-xs font-bold px-2 py-0.5 rounded" style={{ backgroundColor: 'rgba(250, 204, 21, 0.15)', color: '#FACC15' }}>
                                ★ In evidenza
                            </span>
                        )}
                    </div>
                    <h1 className="text-3xl lg:text-5xl font-extrabold" style={{ color: '#F0F0FA' }}>{corpo.nome_display || corpo.nome}</h1>
                    {corpo.tipo && <p className="text-lg mt-1" style={{ color: '#B8B8D0' }}>{corpo.tipo}</p>}
                </div>
            </motion.div>

            <div className="grid lg:grid-cols-3 gap-8">
                {/* Colonna principale */}
                <div className="lg:col-span-2 space-y-8">
                    {/* Descrizione */}
                    <motion.section initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ delay: 0.2 }}>
                        <p className="text-base leading-relaxed" style={{ color: '#B8B8D0' }}>{corpo.descrizione}</p>
                    </motion.section>

                    {/* Metriche scientifiche */}
                    <motion.section initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ delay: 0.3 }}>
                        <h2 className="text-xl font-bold mb-4 flex items-center gap-2" style={{ color: '#F0F0FA' }}>
                            <Ruler size={20} style={{ color: '#22D3EE' }} /> Dati Scientifici
                        </h2>
                        <div className="grid grid-cols-2 md:grid-cols-3 gap-4">
                            {metriche.filter(m => corpo[m.key] !== null && corpo[m.key] !== undefined).map(m => (
                                <div key={m.key} className="rounded-xl p-4" style={{ backgroundColor: '#111128', border: '1px solid rgba(34, 211, 238, 0.08)' }}>
                                    <div className="flex items-center gap-2 mb-2">
                                        <m.icon size={14} style={{ color: '#22D3EE' }} />
                                        <span className="text-xs font-medium" style={{ color: '#7A7A9A' }}>{m.label}</span>
                                    </div>
                                    <p className="text-sm font-semibold" style={{ color: '#F0F0FA' }}>{m.format(corpo[m.key])}</p>
                                </div>
                            ))}
                        </div>
                    </motion.section>

                    {/* Scoperta */}
                    {(corpo.scopritore || corpo.anno_scoperta) && (
                        <motion.section initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ delay: 0.35 }}
                            className="flex gap-6 flex-wrap">
                            {corpo.scopritore && (
                                <div className="flex items-center gap-2 text-sm" style={{ color: '#B8B8D0' }}>
                                    <User size={14} style={{ color: '#A855F7' }} />
                                    Scoperto da: <span className="font-medium" style={{ color: '#F0F0FA' }}>{corpo.scopritore}</span>
                                </div>
                            )}
                            {corpo.anno_scoperta && (
                                <div className="flex items-center gap-2 text-sm" style={{ color: '#B8B8D0' }}>
                                    <Calendar size={14} style={{ color: '#A855F7' }} />
                                    Anno: <span className="font-medium" style={{ color: '#F0F0FA' }}>{corpo.anno_scoperta}</span>
                                </div>
                            )}
                        </motion.section>
                    )}

                    {/* Galleria */}
                    {corpo.galleria && corpo.galleria.length > 0 && (
                        <motion.section initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ delay: 0.4 }}>
                            <h2 className="text-xl font-bold mb-4 flex items-center gap-2" style={{ color: '#F0F0FA' }}>
                                <Star size={20} style={{ color: '#22D3EE' }} /> Galleria
                            </h2>
                            <LightboxGalleria immagini={corpo.galleria} />
                        </motion.section>
                    )}

                    {/* Curiosità */}
                    {corpo.curiosita && corpo.curiosita.length > 0 && (
                        <motion.section initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ delay: 0.45 }}>
                            <h2 className="text-xl font-bold mb-4 flex items-center gap-2" style={{ color: '#F0F0FA' }}>
                                <Lightbulb size={20} style={{ color: '#FACC15' }} /> Curiosità
                            </h2>
                            <div className="space-y-4">
                                {corpo.curiosita.map(cur => (
                                    <div key={cur.id} className="rounded-xl p-4" style={{ backgroundColor: '#111128', border: '1px solid rgba(34, 211, 238, 0.08)' }}>
                                        <h3 className="font-semibold mb-1" style={{ color: '#F0F0FA' }}>{cur.titolo}</h3>
                                        <p className="text-sm leading-relaxed" style={{ color: '#B8B8D0' }}>{cur.descrizione}</p>
                                        {cur.fonte && (
                                            <p className="text-xs mt-2" style={{ color: '#7A7A9A' }}>Fonte: {cur.fonte}</p>
                                        )}
                                    </div>
                                ))}
                            </div>
                        </motion.section>
                    )}
                </div>

                {/* Sidebar */}
                <div className="space-y-8">
                    {/* Missioni */}
                    {corpo.missioni && corpo.missioni.length > 0 && (
                        <motion.section initial={{ opacity: 0, x: 20 }} animate={{ opacity: 1, x: 0 }} transition={{ delay: 0.4 }}>
                            <h2 className="text-xl font-bold mb-4 flex items-center gap-2" style={{ color: '#F0F0FA' }}>
                                <Rocket size={20} style={{ color: '#F97316' }} /> Missioni
                            </h2>
                            <TimelineMissioni missioni={corpo.missioni} />
                        </motion.section>
                    )}

                    {/* Link a comparatore - solo per pianeti */}
                    {corpo.categoria?.nome === 'Pianeta' && (
                        <motion.div initial={{ opacity: 0, x: 20 }} animate={{ opacity: 1, x: 0 }} transition={{ delay: 0.5 }}>
                            <Link to={`/confronta?primo=${corpo.slug}`}
                                className="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200"
                                style={{ backgroundColor: 'rgba(168, 85, 247, 0.1)', color: '#A855F7', border: '1px solid rgba(168, 85, 247, 0.2)' }}
                                onMouseEnter={e => { e.currentTarget.style.backgroundColor = 'rgba(168, 85, 247, 0.2)'; e.currentTarget.style.borderColor = 'rgba(168, 85, 247, 0.4)'; }}
                                onMouseLeave={e => { e.currentTarget.style.backgroundColor = 'rgba(168, 85, 247, 0.1)'; e.currentTarget.style.borderColor = 'rgba(168, 85, 247, 0.2)'; }}>
                                <OrbitIcon size={16} /> Confronta con un altro pianeta
                            </Link>
                        </motion.div>
                    )}
                </div>
            </div>

            {/* Corpi simili */}
            {simili.length > 0 && (
                <motion.section initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ delay: 0.5 }}
                    className="mt-12">
                    <h2 className="text-xl font-bold mb-6 flex items-center gap-2" style={{ color: '#F0F0FA' }}>
                        <Star size={20} style={{ color: '#22D3EE' }} /> Corpi Simili
                    </h2>
                    <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        {simili.map(s => (
                            <CorpoCard key={s.id} corpo={s} />
                        ))}
                    </div>
                </motion.section>
            )}
        </div>
    );
}

function formatScientific(v) {
    if (!v) return '—';
    const num = parseFloat(v);
    if (num === 0) return '0';
    const exp = Math.floor(Math.log10(Math.abs(num)));
    const mant = num / Math.pow(10, exp);
    return `${mant.toFixed(2)} × 10^${exp}`;
}

function formatNumber(v) {
    if (!v) return '—';
    const num = parseFloat(v);
    if (num >= 1_000_000_000) return (num / 1_000_000_000).toFixed(1) + ' Mld';
    if (num >= 1_000_000) return (num / 1_000_000).toFixed(1) + ' Mln';
    if (num >= 1_000) return (num / 1_000).toFixed(1) + ' mila';
    return num.toLocaleString('it-IT');
}

function formatDistance(km) {
    if (!km) return '—';
    const num = parseFloat(km);
    if (num === 0) return '0 km';
    if (num >= 1_000_000_000) return (num / 1_000_000_000).toFixed(2) + ' Mld km';
    if (num >= 1_000_000) return (num / 1_000_000).toFixed(2) + ' Mln km';
    if (num >= 1_000) return (num / 1_000).toFixed(1) + ' mila km';
    return num.toLocaleString('it-IT') + ' km';
}