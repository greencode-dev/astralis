import { render, screen, waitFor } from '@testing-library/react';
import { MemoryRouter } from 'react-router-dom';
import CorpoCard from '../components/CorpoCard';
import { baseCorpo } from './fixtures';

function renderCard(corpo) {
    return render(
        <MemoryRouter>
            <CorpoCard corpo={corpo} />
        </MemoryRouter>
    );
}

describe('CorpoCard', () => {

    it('renders nome_display and descrizione', () => {
        renderCard(baseCorpo);
        expect(screen.getByText('Terra')).toBeInTheDocument();
        expect(screen.getByText('Il nostro pianeta.')).toBeInTheDocument();
    });

    it('renders image when immagine_url is present', async () => {
        renderCard({ ...baseCorpo, immagine_url: 'https://example.com/earth.jpg' });
        const img = screen.getByRole('img');
        await waitFor(() => {
            expect(img).toHaveAttribute('src', 'https://example.com/earth.jpg');
        });
        expect(img).toHaveAttribute('alt', 'Terra');
    });

    it('renders gradient fallback when no image', () => {
        const { container } = renderCard(baseCorpo);
        const fallback = container.querySelector('[role="img"]');
        expect(fallback).toBeInTheDocument();
        expect(fallback).toHaveAttribute('aria-label', 'Pianeta — Terra');
    });

    it('shows in_evidenza badge when true', () => {
        renderCard({ ...baseCorpo, in_evidenza: true });
        expect(screen.getByText('★ In evidenza')).toBeInTheDocument();
    });

    it('hides in_evidenza badge when false', () => {
        renderCard(baseCorpo);
        expect(screen.queryByText('★ In evidenza')).not.toBeInTheDocument();
    });

    it('renders categoria badge', () => {
        renderCard(baseCorpo);
        expect(screen.getByText('Pianeta')).toBeInTheDocument();
    });

    it('links to the correct detail page', () => {
        renderCard(baseCorpo);
        const link = screen.getByRole('link');
        expect(link).toHaveAttribute('href', '/corpi-celesti/terra');
    });

    it('shows tipo when present', () => {
        renderCard(baseCorpo);
        expect(screen.getByText('roccioso')).toBeInTheDocument();
    });

    it('shows formatted distance when present', () => {
        renderCard({ ...baseCorpo, distanza_km: '778500000' });
        expect(screen.getByText('778.5 Mln km')).toBeInTheDocument();
    });

    it('uses nome as fallback when nome_display is null', () => {
        renderCard({ ...baseCorpo, nome_display: null, nome: 'Marte', immagine_url: 'https://example.com/marte.jpg' });
        const img = screen.getByRole('img');
        expect(img).toHaveAttribute('alt', 'Marte');
    });
});
