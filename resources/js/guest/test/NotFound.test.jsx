import { render, screen } from '@testing-library/react';
import { MemoryRouter } from 'react-router-dom';
import NotFound from '../pages/NotFound';

function renderNotFound() {
    return render(
        <MemoryRouter>
            <NotFound />
        </MemoryRouter>
    );
}

describe('NotFound', () => {
    it('renders page title', () => {
        renderNotFound();
        expect(screen.getByText('Pagina non trovata')).toBeInTheDocument();
    });

    it('renders description text', () => {
        renderNotFound();
        expect(screen.getByText(/la pagina che cerchi non esiste/i)).toBeInTheDocument();
    });

    it('renders home link', () => {
        renderNotFound();
        const link = screen.getByRole('link', { name: /torna alla home/i });
        expect(link).toHaveAttribute('href', '/');
    });

    it('sets document title', () => {
        renderNotFound();
        expect(document.title).toContain('non trovata');
    });
});
