const categoryColors = {
    'Pianeta': '#22D3EE',
    'Stella': '#F97316',
    'Luna': '#94A3B8',
    'Galassia': '#A855F7',
    'Nebulosa': '#F472B6',
    'Asteroide': '#78716C',
    'Cometa': '#22C55E',
    'Pianeta Nano': '#6B7280',
};

export default function CategoriaBadge({ categoria }) {
    if (!categoria) return null;

    const color = categoryColors[categoria.nome] || '#6B7280';

    return (
        <span
            className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
            style={{
                backgroundColor: `${color}20`,
                color: color,
                border: `1px solid ${color}40`,
            }}
        >
            {categoria.nome}
        </span>
    );
}