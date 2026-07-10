import { useState, memo } from 'react';
import { Rocket, Calendar, Building2, Globe } from 'lucide-react';

const statoColors = {
    'Completata': { bg: 'rgba(34, 197, 94, 0.15)', text: '#22C55E' },
    'In corso': { bg: 'rgba(34, 211, 238, 0.15)', text: '#22D3EE' },
    'Pianificata': { bg: 'rgba(250, 204, 21, 0.15)', text: '#FACC15' },
};

const LogoFallback = memo(function LogoFallback({ nome }) {
    return (
        <div className="w-10 h-10 rounded-lg flex items-center justify-center bg-admin-primary/10"
            role="img" aria-label={'Logo ' + nome}>
            <Rocket size={20} className="text-admin-primary" aria-hidden="true" />
        </div>
    );
});

const MissioneLogo = memo(function MissioneLogo({ missione }) {
    const [error, setError] = useState(false);

    if (!missione.logo_url || error) {
        return <LogoFallback nome={missione.nome} />;
    }

    return (
        <img src={missione.logo_url} alt={missione.nome} className="w-10 h-10 rounded-lg object-cover" onError={() => setError(true)} />
    );
});

export default memo(function TimelineMissioni({ missioni }) {
    if (!missioni || missioni.length === 0) return null;

    return (
        <div className="relative">
            {/* Linea temporale orizzontale */}
            <div className="flex gap-6 overflow-x-auto pb-4"
                style={{ scrollbarWidth: 'thin', scrollbarColor: '#22D3EE transparent' }}>
                {missioni.map((missione, index) => {
                    const colors = statoColors[missione.stato] || { bg: 'rgba(255,255,255,0.1)', text: '#B8B8D0' };
                    return (
                        <div key={missione.id} className="flex-shrink-0 w-[280px]">
                            <div className="relative">
                                {/* Punto sulla timeline */}
                                <div className="flex items-center mb-4">
                                    <div className="w-4 h-4 rounded-full flex-shrink-0" style={{ backgroundColor: colors.text }} />
                                    <div className="flex-1 h-0.5 ml-2 bg-admin-primary/15" />
                                </div>

                                {/* Card missione */}
                                <div
                                    className="rounded-xl p-4 transition-all duration-200 hover:-translate-y-0.5 hover:border-[rgba(34,211,238,0.4)] bg-admin-card"
                                >
                                    {/* Logo o icona */}
                                    <div className="flex items-center gap-3 mb-3">
                                        <MissioneLogo missione={missione} />
                                        <div>
                                            <h4 className="font-semibold text-sm text-admin-text">{missione.nome}</h4>
                                            <span className="text-xs font-medium px-2 py-0.5 rounded-full" style={{
                                                backgroundColor: colors.bg,
                                                color: colors.text,
                                            }}>
                                                {missione.stato}
                                            </span>
                                        </div>
                                    </div>

                                    {/* Dettagli */}
                                    <div className="space-y-2">
                                        {missione.agenzia && (
                                            <div className="flex items-center gap-2 text-xs text-admin-dim">
                                                <Building2 size={12} />
                                                <span>{missione.agenzia}</span>
                                            </div>
                                        )}
                                        {missione.data_lancio && (
                                            <div className="flex items-center gap-2 text-xs text-admin-dim">
                                                <Calendar size={12} />
                                                <span>{formatDate(missione.data_lancio)}</span>
                                            </div>
                                        )}
                                    </div>

                                    {/* Descrizione */}
                                    {missione.descrizione && (
                                        <p className="text-xs mt-3 leading-relaxed line-clamp-2 text-admin-muted">
                                            {missione.descrizione}
                                        </p>
                                    )}

                                    {/* Pivot data */}
                                    {missione.pivot && missione.pivot.tipo_esplorazione && (
                                        <div className="mt-3 flex items-center gap-2 text-xs text-admin-secondary">
                                            <Globe size={12} />
                                            <span>{missione.pivot.tipo_esplorazione}</span>
                                            {missione.pivot.anno_arrivo && <span>— {missione.pivot.anno_arrivo}</span>}
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>
                    );
                })}
            </div>
        </div>
    );
});

function formatDate(dateStr) {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return date.toLocaleDateString('it-IT', { year: 'numeric', month: 'long', day: 'numeric' });
}
