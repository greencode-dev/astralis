import { render, screen } from '@testing-library/react';
import CategoriaBadge from '../components/CategoriaBadge';

describe('CategoriaBadge', () => {
    it('returns null when categoria is null', () => {
        const { container } = render(<CategoriaBadge categoria={null} />);
        expect(container.innerHTML).toBe('');
    });

    it('returns null when categoria is undefined', () => {
        const { container } = render(<CategoriaBadge />);
        expect(container.innerHTML).toBe('');
    });

    it('renders the categoria name', () => {
        const categoria = { nome: 'Pianeta' };
        render(<CategoriaBadge categoria={categoria} />);
        expect(screen.getByText('Pianeta')).toBeInTheDocument();
    });

    it('applies correct color for known category', () => {
        const categoria = { nome: 'Stella' };
        render(<CategoriaBadge categoria={categoria} />);
        const badge = screen.getByText('Stella');
        expect(badge).toHaveStyle({ color: '#F97316' });
    });

    it('falls back to default color for unknown category', () => {
        const categoria = { nome: 'Sconosciuto' };
        render(<CategoriaBadge categoria={categoria} />);
        const badge = screen.getByText('Sconosciuto');
        expect(badge).toHaveStyle({ color: '#6B7280' });
    });
});
