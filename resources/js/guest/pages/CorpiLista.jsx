import { useState, useEffect } from 'react';
import { motion } from 'framer-motion';
import { Filter } from 'lucide-react';
import CorpoCard from '../components/CorpoCard';
import SearchBar from '../components/SearchBar';
import { fetchCorpiCelesti, fetchCategorie } from '../apiClient';

export default function CorpiLista() {
    const [corpi, setCorpi] = useState([]);
    const [categorie, setCategorie] = useState([]);
    const [loading, setLoading] = useState(true);
    const [search, setSearch] = useState('');
    const [categoriaSlug, setCategoriaSlug] = useState('');
    const [tipo, setTipo] = useState('');
    const [page, setPage] = useState(1);

    useEffect(() => {
        document.title = 'Corpi Celesti — Astralis';
    }, []);
    const [lastPage, setLastPage] = useState(1);
    const [total, setTotal] = useState(0);

    const tipi = ['Pianeta', 'Stella', 'Luna', 'Galassia', 'Nebulosa', 'Asteroide', 'Cometa', 'Pianeta Nano'];

    useEffect(() => {
        fetchCategorie().then(res => setCategorie(res.data || [])).catch(err => console.error('Errore caricamento categorie:', err));
    }, []);

    useEffect(() => {
        async function load() {
            setLoading(true);
            try {
                const params = { per_page: 12, page };
                if (categoriaSlug) params.categoria = categoriaSlug;
                if (tipo) params.tipo = tipo;
                if (search) params.search = search;

                const res = await fetchCorpiCelesti(params);
                setCorpi(res.data || []);
                setLastPage(res.meta?.last_page || 1);
                setTotal(res.meta?.total || 0);
            } catch (err) {
                console.error('Errore caricamento corpi celesti:', err);
            } finally {
                setLoading(false);
            }
        }
        load();
    }, [page, categoriaSlug, tipo, search]);

    function handleSearch(value) {
        setSearch(value);
        setPage(1);
    }

    function handleCategoria(slug) {
        setCategoriaSlug(slug === categoriaSlug ? '' : slug);
        setPage(1);
    }

    function handleTipo(value) {
        setTipo(value === tipo ? '' : value);
        setPage(1);
    }

    function resetFilters() {
        setSearch('');
        setCategoriaSlug('');
        setTipo('');
        setPage(1);
    }

    const hasFilters = search || categoriaSlug || tipo;

    return (
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            {/* Header */}
            <div className="mb-8">
                <h1 className="text-3xl font-bold mb-2" style={{ color: '#F0F0FA' }}>
                    Corpi Celesti
                </h1>
                <p style={{ color: '#B8B8D0' }}>
                    {total > 0
                        ? `Esplora ${total} corpi celesti nel nostro catalogo`
                        : 'Esplora il catalogo dei corpi celesti'}
                </p>
            </div>

            {/* Filtri */}
            <div className="mb-8 space-y-4">
                {/* Search + reset */}
                <div className="flex flex-col sm:flex-row gap-4">
                    <div className="flex-1">
                        <SearchBar value={search} onChange={handleSearch} placeholder="Cerca per nome o descrizione..." />
                    </div>
                    {hasFilters && (
                        <button
                            onClick={resetFilters}
                            className="px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-[rgba(249,115,22,0.1)]"
                            style={{ color: '#F97316', border: '1px solid rgba(249, 115, 22, 0.3)' }}
                        >
                            Reset filtri
                        </button>
                    )}
                </div>

                {/* Categorie */}
                <div className="flex items-center gap-2 flex-wrap">
                    <Filter size={16} style={{ color: '#7A7A9A' }} />
                    {categorie.map(cat => (
                        <button
                            key={cat.id}
                            onClick={() => handleCategoria(cat.slug)}
                            className="px-3 py-1.5 rounded-full text-xs font-medium transition-all duration-200 hover:bg-[rgba(34,211,238,0.08)] hover:text-[#22D3EE]"
                            style={{
                                backgroundColor: categoriaSlug === cat.slug ? 'rgba(34, 211, 238, 0.15)' : 'rgba(255, 255, 255, 0.05)',
                                color: categoriaSlug === cat.slug ? '#22D3EE' : '#B8B8D0',
                                border: categoriaSlug === cat.slug ? '1px solid rgba(34, 211, 238, 0.4)' : '1px solid transparent',
                            }}

                        >
                            {cat.nome}
                            {cat.corpi_count !== undefined && (
                                <span className="ml-1 opacity-60">({cat.corpi_count})</span>
                            )}
                        </button>
                    ))}
                </div>

                {/* Tipo */}
                <div className="flex items-center gap-2 flex-wrap">
                    <span className="text-xs font-medium" style={{ color: '#7A7A9A' }}>Tipo:</span>
                    {tipi.map(t => (
                        <button
                            key={t}
                            onClick={() => handleTipo(t)}
                            className="px-3 py-1.5 rounded-full text-xs font-medium transition-all duration-200 hover:bg-[rgba(168,85,247,0.08)] hover:text-[#A855F7]"
                            style={{
                                backgroundColor: tipo === t ? 'rgba(168, 85, 247, 0.15)' : 'rgba(255, 255, 255, 0.05)',
                                color: tipo === t ? '#A855F7' : '#B8B8D0',
                                border: tipo === t ? '1px solid rgba(168, 85, 247, 0.4)' : '1px solid transparent',
                            }}

                        >
                            {t}
                        </button>
                    ))}
                </div>
            </div>

            {/* Griglia */}
            {loading ? (
                <div className="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    {Array.from({ length: 8 }).map((_, i) => (
                        <div key={i} className="rounded-xl animate-pulse" style={{ backgroundColor: '#111128', height: 320 }} />
                    ))}
                </div>
            ) : corpi.length > 0 ? (
                <>
                    <div className="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        {corpi.map(corpo => (
                            <motion.div
                                key={corpo.id}
                                initial={{ opacity: 0, y: 20 }}
                                whileInView={{ opacity: 1, y: 0 }}
                                transition={{ duration: 0.4 }}
                                viewport={{ once: true }}
                            >
                                <CorpoCard corpo={corpo} />
                            </motion.div>
                        ))}
                    </div>

                    {/* Paginazione */}
                    {lastPage > 1 && (
                        <div className="flex items-center justify-center gap-2 mt-10">
                            <button
                                onClick={() => setPage(p => Math.max(1, p - 1))}
                                disabled={page === 1}
                                className="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 disabled:opacity-30 hover:bg-[rgba(34,211,238,0.1)]"
                                style={{
                                    color: '#22D3EE',
                                    border: '1px solid rgba(34, 211, 238, 0.3)',
                                }}
                            >
                                ← Precedente
                            </button>

                            <div className="flex items-center gap-1">
                                {Array.from({ length: lastPage }, (_, i) => i + 1)
                                    .filter(p => p === 1 || p === lastPage || Math.abs(p - page) <= 1)
                                    .map((p, idx, arr) => (
                                        <span key={p} className="flex items-center">
                                            {idx > 0 && arr[idx - 1] !== p - 1 && (
                                                <span className="px-1" style={{ color: '#7A7A9A' }}>...</span>
                                            )}
                                            <button
                                                onClick={() => setPage(p)}
                                                className="w-9 h-9 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-[rgba(34,211,238,0.08)]"
                                                style={{
                                                    backgroundColor: p === page ? 'rgba(34, 211, 238, 0.15)' : 'transparent',
                                                    color: p === page ? '#22D3EE' : '#B8B8D0',
                                                }}

                                            >
                                                {p}
                                            </button>
                                        </span>
                                    ))}
                            </div>

                            <button
                                onClick={() => setPage(p => Math.min(lastPage, p + 1))}
                                disabled={page === lastPage}
                                className="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 disabled:opacity-30 hover:bg-[rgba(34,211,238,0.1)]"
                                style={{
                                    color: '#22D3EE',
                                    border: '1px solid rgba(34, 211, 238, 0.3)',
                                }}
                            >
                                Successiva →
                            </button>
                        </div>
                    )}
                </>
            ) : (
                <div className="text-center py-20">
                    <p className="text-lg" style={{ color: '#B8B8D0' }}>Nessun risultato trovato</p>
                    <p className="text-sm mt-2" style={{ color: '#7A7A9A' }}>Prova a modificare i filtri di ricerca</p>
                </div>
            )}
        </div>
    );
}