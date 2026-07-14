import { render, screen } from '@testing-library/react';
import { MemoryRouter, useLocation } from 'react-router-dom';
import Navbar from '../components/Navbar';

function renderNav(path = '/') {
    return render(
        <MemoryRouter initialEntries={[path]}>
            <Navbar />
        </MemoryRouter>
    );
}

describe('Navbar', () => {
    it('renders brand name', () => {
        renderNav();
        expect(screen.getByText('Astralis')).toBeInTheDocument();
    });

    it('renders nav links', () => {
        renderNav();
        expect(screen.getByRole('link', { name: 'Home' })).toBeInTheDocument();
        expect(screen.getByRole('link', { name: 'Corpi Celesti' })).toBeInTheDocument();
    });

    it('has aria-label on nav', () => {
        renderNav();
        expect(screen.getByRole('navigation')).toHaveAttribute('aria-label', 'Navigazione principale');
    });

    it('marks active link with aria-current', () => {
        renderNav('/corpi-celesti');
        const link = screen.getByRole('link', { name: 'Corpi Celesti' });
        expect(link).toHaveAttribute('aria-current', 'page');
    });

    it('does not mark inactive links with aria-current', () => {
        renderNav('/corpi-celesti');
        const homeLink = screen.getByRole('link', { name: 'Home' });
        expect(homeLink).not.toHaveAttribute('aria-current');
    });

    it('links to correct paths', () => {
        renderNav();
        expect(screen.getByRole('link', { name: 'Home' })).toHaveAttribute('href', '/');
        expect(screen.getByRole('link', { name: 'Corpi Celesti' })).toHaveAttribute('href', '/corpi-celesti');
    });
});
