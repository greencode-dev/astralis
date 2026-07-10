import { useState, useEffect } from 'react';
import { useSearchParams, Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { ArrowLeft, Ruler, RotateCcw } from 'lucide-react';
import { fetchCorpiCelesti, fetchCorpoCeleste } from '../apiClient';
import { useFetch } from '../hooks/useFetch';
import CategoriaBadge from '../components/CategoriaBadge';

const campi = [
    { key: 'tipo', label: 'Tipo' },
    { key: 'massa_kg', label: 'Massa', format: v => formatScientific(v) + ' kg' },
    { key: 'diametro_km', label: 'Diametro', format: v => formatNumber(v) + ' km' },
    { key: 'distanza_km', label: 'Distanza dal Sole', format: v => formatDistance(v) },
    { key: 'gravita', label: 'Gravità', format: v => v + ' m/s²' },
    { key: 'temperatura', label: 'Temperatura', format: v => v + ' °C' },
    { key: 'periodo_orbitale', label: 'Periodo Orbitale', format: v => formatNumber(v) + ' giorni' },
];

export default function Comparatore() {
    const [searchParams, setSearchParams] = useSearchParams();
    const [primoSlug, setPrimoSlug] = useState(searchParams.get('primo') || '');
    const [secondoSlug, setSecondoSlug] = useState(searchParams.get('secondo') || '');

    const { data: corpiData } = useFetch(
        signal => fetchCorpiCelesti({ per_page: 100 }, signal), []
    );
    const { data: primoData, loading: loadingPrimo } = useFetch(
        signal => primoSlug ? fetchCorpoCeleste(primoSlug, signal) : Promise.resolve(null),
        [primoSlug]
    );
    const { data: secondoData, loading: loadingSecondo } = useFetch(
        signal => secondoSlug ? fetchCorpoCeleste(secondoSlug, signal) : Promise.resolve(null),
        [secondoSlug]
    );

    useEffect(() => {
        document.title = 'Confronta Pianeti — Astralis';
    }, []);

    useEffect(() => {
        const params = {};
        if (primoSlug) params.primo = primoSlug;
        if (secondoSlug) params.secondo = secondoSlug;
        setSearchParams(params, { replace: true });
    }, [primoSlug, secondoSlug]);

    const loading = loadingPrimo || loadingSecondo;
    const corpi = corpiData?.data || [];
    const primo = primoData?.data || primoData || null;
    const secondo = secondoData?.data || secondoData || null;

    const hasBoth = primo && secondo;
    const pianeti = corpi.filter(c => c.categoria?.nome === 'Pianeta');

    return (
        <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <Link to="/corpi-celesti" className="inline-flex items-center gap-2 text-sm font-medium mb-6 transition-all hover:opacity-70"
                style={{ color: '#22D3EE' }}>
                <ArrowLeft size={16} /> Torna alla lista
            </Link>

            <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ duration: 0.6 }}>
                <h1 className="text-3xl font-extrabold mb-2" style={{ color: '#F0F0FA' }}>Confronta Pianeti</h1>
                <p className="mb-8" style={{ color: '#B8B8D0' }}>Seleziona due pianeti per confrontare i loro dati scientifici.</p>

                {/* Selettori */}
                <div className="grid md:grid-cols-2 gap-6 mb-8">
                    {['primo', 'secondo'].map(pos => {
                        const isPrimo = pos === 'primo';
                        const slug = isPrimo ? primoSlug : secondoSlug;
                        const setSlug = isPrimo ? setPrimoSlug : setSecondoSlug;
                        const corpo = isPrimo ? primo : secondo;

                        return (
                            <div key={pos}>
                                <label className="block text-sm font-medium mb-2" style={{ color: '#B8B8D0' }}>
                                    {isPrimo ? 'Primo pianeta' : 'Secondo pianeta'}
                                </label>
                                <div className="relative">
                                    <select
                                        value={slug}
                                        onChange={e => setSlug(e.target.value)}
                                        className="w-full px-4 py-3 rounded-xl text-sm outline-none appearance-none transition-all duration-200"
                                        style={{
                                            backgroundColor: '#111128',
                                            color: '#F0F0FA',
                                            border: '1px solid rgba(34, 211, 238, 0.2)',
                                        }}
                                        onFocus={e => e.target.style.borderColor = 'rgba(34, 211, 238, 0.5)'}
                                        onBlur={e => e.target.style.borderColor = 'rgba(34, 211, 238, 0.2)'}
                                    >
                                        <option value="">Seleziona un pianeta...</option>
                                        {pianeti.filter(p => {
                                            const altroSlug = isPrimo ? secondoSlug : primoSlug;
                                            return p.slug !== altroSlug;
                                        }).map(p => (
                                            <option key={p.slug} value={p.slug}>{p.nome}</option>
                                        ))}
                                    </select>
                                    {slug && (
                                        <button
                                            onClick={() => setSlug('')}
                                            className="absolute right-3 top-1/2 -translate-y-1/2 transition-all hover:text-[#F97316]"
                                            style={{ color: '#7A7A9A' }}
                                            aria-label="Resetta selezione"
                                        >
                                            <RotateCcw size={16} aria-hidden="true" />
                                        </button>
                                    )}
                                </div>
                            </div>
                        );
                    })}
                </div>

                {/* Tabella confronto */}
                {loading ? (
                    <div className="animate-pulse space-y-4">
                        {Array.from({ length: 7 }).map((_, i) => (
                            <div key={i} className="h-12 rounded-xl" style={{ backgroundColor: '#111128' }} />
                        ))}
                    </div>
                ) : hasBoth ? (
                    <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} transition={{ delay: 0.3 }}
                        className="rounded-2xl overflow-hidden" style={{ border: '1px solid rgba(34, 211, 238, 0.1)' }}>

                        {/* Intestazione */}
                        <div className="grid grid-cols-3 gap-4 p-4" style={{ backgroundColor: '#111128', borderBottom: '1px solid rgba(34, 211, 238, 0.1)' }}>
                            <div />
                            <div className="text-center">
                                <p className="font-bold text-lg" style={{ color: '#22D3EE' }}>{primo.nome}</p>
                                <CategoriaBadge categoria={primo.categoria} />
                            </div>
                            <div className="text-center">
                                <p className="font-bold text-lg" style={{ color: '#A855F7' }}>{secondo.nome}</p>
                                <CategoriaBadge categoria={secondo.categoria} />
                            </div>
                        </div>

                        {/* Righe dati */}
                        {campi.map((campo, idx) => {
                            const valPrimo = primo[campo.key];
                            const valSecondo = secondo[campo.key];
                            const format = campo.format || (v => v || '—');

                            return (
                                <div key={campo.key}
                                    className="grid grid-cols-3 gap-4 p-4 items-center"
                                    style={{
                                        backgroundColor: idx % 2 === 0 ? '#0E0E24' : '#111128',
                                        borderBottom: idx < campi.length - 1 ? '1px solid rgba(34, 211, 238, 0.05)' : 'none',
                                    }}>
                                    <div className="text-sm font-medium" style={{ color: '#7A7A9A' }}>{campo.label}</div>
                                    <div className="text-center text-sm font-semibold" style={{ color: valPrimo ? '#F0F0FA' : '#7A7A9A' }}>
                                        {valPrimo ? format(valPrimo) : '—'}
                                    </div>
                                    <div className="text-center text-sm font-semibold" style={{ color: valSecondo ? '#F0F0FA' : '#7A7A9A' }}>
                                        {valSecondo ? format(valSecondo) : '—'}
                                    </div>
                                </div>
                            );
                        })}
                    </motion.div>
                ) : (
                    <div className="text-center py-16" style={{ color: '#7A7A9A' }}>
                        <Ruler size={48} className="mx-auto mb-4" style={{ color: '#7A7A9A' }} />
                        <p>Seleziona due pianeti per vedere il confronto</p>
                    </div>
                )}
            </motion.div>
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