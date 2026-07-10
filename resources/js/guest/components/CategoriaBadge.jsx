import { categoryColors } from '../constants';
import { memo } from 'react';

export default memo(function CategoriaBadge({ categoria }) {
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
});
