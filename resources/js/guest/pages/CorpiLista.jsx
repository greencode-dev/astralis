import { useState, useEffect } from 'react';
import { Filter } from 'lucide-react';
import CorpoCard from '../components/CorpoCard';
import SearchBar from '../components/SearchBar';
import { fetchCorpiCelesti, fetchCategorie } from '../apiClient';
import { useFetch } from '../hooks/useFetch';
import { useInView } from '../hooks/useInView';
import { useDebounce } from '../hooks/useDebounce';

export default function CorpiLista() {
    const [search, setSearch] = useState('');
    const [categoriaSlug, setCategoriaSlug] = useState('');
    const [tipo, setTipo] = useState('');
    const [page, setPage] = useState(1);
    const debouncedSearch = useDebounce(search);

    const { data: categorieData } = useFetch(
        signal => fetchCategorie(signal), []
    );
    const { data: corpiData, loading, error: corpiError } = useFetch(
        signal => {
            const params = { per_page: 12, page };
            if (categoriaSlug) params.categoria = categoriaSlug;
            if (tipo) params.tipo = tipo;
            if (debouncedSearch) params.search = debouncedSearch;
            return fetchCorpiCelesti(params, signal);
        },
        [page, categoriaSlug, tipo, debouncedSearch]
    );

    useEffect(() => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }, [page]);

    const [gridRef, gridVisible] = useInView();

    const categorie = categorieData?.data || [];
    const corpi = corpiData?.data || [];
    const total = corpiData?.meta?.total || 0;
    const lastPage = corpiData?.meta?.last_page || 1;

    useEffect(() => {
        document.title = 'Corpi Celesti — Astralis';
    }, []);

    const tipi = ['Pianeta', 'Stella', 'Luna', 'Galassia', 'Nebulosa', 'Asteroide', 'Cometa', 'Pianeta Nano'];

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
            <div className="mb-8">
                <h1 className="text-3xl font-bold mb-2 text-admin-text">
                    Corpi Celesti
                </h1>
                <p className="text-admin-dim">
                    {total > 0
                        ? `Esplora ${total} corpi celesti nel nostro catalogo`
                        : 'Esplora il catalogo dei corpi celesti'}
                </p>
            </div>

            <div className="mb-8 space-y-4">
                <div className="flex flex-col sm:flex-row gap-4">
                    <div className="flex-1">
                        <SearchBar value={search} onChange={handleSearch} placeholder="Cerca per nome o descrizione..." />
                    </div>
                    {hasFilters && (
                        <button
                            onClick={resetFilters}
                            className="px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-admin-accent/10 text-admin-accent border border-admin-accent/30"
                        >
                            Reset filtri
                        </button>
                    )}
                </div>

                <div className="flex items-center gap-2 flex-wrap">
                    <Filter size={16} className="text-admin-muted" />
                    {categorie.map(cat => (
                        <button
                            key={cat.id}
                            onClick={() => handleCategoria(cat.slug)}
                            aria-current={categoriaSlug === cat.slug ? 'page' : undefined}
                            className={`px-3 py-1.5 rounded-full text-xs font-medium transition-all duration-200 hover:bg-admin-primary/8 hover:text-admin-primary focus-visible:ring-2 focus-visible:ring-admin-primary focus-visible:outline-none ${categoriaSlug === cat.slug ? 'bg-admin-primary/15 text-admin-primary border border-admin-primary/40' : 'bg-white/5 text-admin-dim border border-transparent'}`}
                        >
                            {cat.nome}
                            {cat.corpi_count !== undefined && (
                                <span className="ml-1 opacity-60">({cat.corpi_count})</span>
                            )}
                        </button>
                    ))}
                </div>

                <div className="flex items-center gap-2 flex-wrap">
                    <span className="text-xs font-medium text-admin-muted">Tipo:</span>
                    {tipi.map(t => (
                        <button
                            key={t}
                            onClick={() => handleTipo(t)}
                            aria-current={tipo === t ? 'page' : undefined}
                            className={`px-3 py-1.5 rounded-full text-xs font-medium transition-all duration-200 hover:bg-admin-secondary/8 hover:text-admin-secondary focus-visible:ring-2 focus-visible:ring-admin-secondary focus-visible:outline-none ${tipo === t ? 'bg-admin-secondary/15 text-admin-secondary border border-admin-secondary/40' : 'bg-white/5 text-admin-dim border border-transparent'}`}
                        >
                            {t}
                        </button>
                    ))}
                </div>
            </div>

            {loading ? (
                <div className="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    {Array.from({ length: 8 }).map((_, i) => (
                        <div key={i} className="rounded-xl animate-pulse bg-admin-card h-[320px]" role="status" aria-label="Caricamento..." />
                    ))}
                </div>
            ) : corpiError ? (
                <div className="text-center py-20 rounded-xl bg-red-500/5 border border-red-500/20" role="alert">
                    <p className="text-lg font-medium text-red-400">Errore nel caricamento dei dati</p>
                    <p className="text-sm mt-2 text-admin-muted">Verifica la connessione e riprova</p>
                    <button onClick={() => window.location.reload()} className="mt-4 px-4 py-2 rounded-lg text-sm font-medium bg-admin-primary/10 text-admin-primary hover:bg-admin-primary/20 transition-all">
                        Riprova
                    </button>
                </div>
            ) : corpi.length > 0 ? (
                <>
                    <div ref={gridRef} className="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        {corpi.map((corpo, idx) => (
                            <div
                                key={corpo.id}
                                className={`animate-in-view ${gridVisible ? 'is-visible' : ''}`}
                                style={{ animationDelay: `${idx * 0.05}s` }}
                            >
                                <CorpoCard corpo={corpo} fetchPriority={idx < 3 ? 'high' : 'low'} />
                            </div>
                        ))}
                    </div>

                    {lastPage > 1 && (
                        <div className="flex items-center justify-center gap-2 mt-10">
                            <button
                                onClick={() => setPage(p => Math.max(1, p - 1))}
                                disabled={page === 1}
                                aria-label="Pagina precedente"
                                className="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 disabled:opacity-30 hover:bg-admin-primary/10 text-admin-primary border border-admin-primary/30 focus-visible:ring-2 focus-visible:ring-admin-primary focus-visible:outline-none"
                            >
                                ← Precedente
                            </button>

                            <div className="flex items-center gap-1">
                                {Array.from({ length: lastPage }, (_, i) => i + 1)
                                    .filter(p => p === 1 || p === lastPage || Math.abs(p - page) <= 1)
                                    .map((p, idx, arr) => (
                                        <span key={p} className="flex items-center">
                                            {idx > 0 && arr[idx - 1] !== p - 1 && (
                                                <span className="px-1 text-admin-muted">…</span>
                                            )}
                                            <button
                                                onClick={() => setPage(p)}
                                                aria-current={p === page ? 'page' : undefined}
                                                className={`w-9 h-9 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-admin-primary/8 ${p === page ? 'bg-admin-primary/15 text-admin-primary' : 'text-admin-dim'}`}
                                            >
                                                {p}
                                            </button>
                                        </span>
                                    ))}
                            </div>

                            <button
                                onClick={() => setPage(p => Math.min(lastPage, p + 1))}
                                disabled={page === lastPage}
                                aria-label="Pagina successiva"
                                className="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 disabled:opacity-30 hover:bg-admin-primary/10 text-admin-primary border border-admin-primary/30 focus-visible:ring-2 focus-visible:ring-admin-primary focus-visible:outline-none"
                            >
                                Successiva →
                            </button>
                        </div>
                    )}
                </>
            ) : (
                <div className="text-center py-20" role="alert">
                    <p className="text-lg text-admin-dim">Nessun risultato trovato</p>
                    <p className="text-sm mt-2 text-admin-muted">Prova a modificare i filtri di ricerca</p>
                </div>
            )}
        </div>
    );
}
