import { render, screen, waitFor } from '@testing-library/react';
import { MemoryRouter } from 'react-router-dom';
import HomePage from '../pages/HomePage';
import { mockStats, terra, marte } from './fixtures';

vi.mock('../apiClient', () => ({
    fetchCorpiCelesti: vi.fn(),
    fetchDashboardStats: vi.fn(),
}));

import { fetchCorpiCelesti, fetchDashboardStats } from '../apiClient';

function renderPage() {
    return render(
        <MemoryRouter>
            <HomePage />
        </MemoryRouter>
    );
}

const mockCorpi = (overrides = {}) => ({
    data: [
        { ...terra, ...overrides },
        { ...marte, in_evidenza: true, ...overrides },
    ],
    meta: { total: 2, last_page: 1 },
});

describe('HomePage', () => {
    beforeEach(() => {
        vi.clearAllMocks();
    });

    it('renders hero section with title', () => {
        fetchCorpiCelesti.mockResolvedValue(mockCorpi());
        fetchDashboardStats.mockResolvedValue(mockStats);
        renderPage();

        const esploraElements = screen.getAllByText(/Esplora/);
        expect(esploraElements.length).toBeGreaterThanOrEqual(1);
        expect(screen.getByText("l'Universo")).toBeInTheDocument();
        expect(screen.getByText(/con Astralis/)).toBeInTheDocument();
    });

    it('shows loading skeleton initially', () => {
        fetchCorpiCelesti.mockImplementation(() => new Promise(() => {}));
        fetchDashboardStats.mockImplementation(() => new Promise(() => {}));
        renderPage();

        const skeletons = document.querySelectorAll('.animate-pulse');
        expect(skeletons.length).toBeGreaterThanOrEqual(3);
    });

    it('renders "In Evidenza" section with corpi cards after loading', async () => {
        fetchCorpiCelesti.mockResolvedValue(mockCorpi());
        fetchDashboardStats.mockResolvedValue(mockStats);
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Terra')).toBeInTheDocument();
        });

        expect(screen.getAllByText('Marte').length).toBeGreaterThanOrEqual(1);
        expect(screen.getByText('Il terzo pianeta del sistema solare.')).toBeInTheDocument();
        expect(screen.getByText('Il pianeta rosso.')).toBeInTheDocument();
    });

    it('displays dashboard stats after loading', async () => {
        fetchCorpiCelesti.mockResolvedValue(mockCorpi());
        fetchDashboardStats.mockResolvedValue(mockStats);
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('150')).toBeInTheDocument();
        });

        expect(screen.getByText('8')).toBeInTheDocument();
        expect(screen.getByText('25')).toBeInTheDocument();
        expect(screen.getByText('Corpi Celesti')).toBeInTheDocument();
        expect(screen.getByText('Categorie')).toBeInTheDocument();
        expect(screen.getByText('Missioni')).toBeInTheDocument();
    });

    it('shows empty state message when no corpi in evidenza', async () => {
        fetchCorpiCelesti.mockResolvedValue({ data: [], meta: { total: 0, last_page: 0 } });
        fetchDashboardStats.mockResolvedValue(mockStats);
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Nessun corpo celeste in evidenza al momento.')).toBeInTheDocument();
        });
    });

    it('calls fetchCorpiCelesti with in_evidenza filter on mount', async () => {
        fetchCorpiCelesti.mockResolvedValue({ data: [] });
        fetchDashboardStats.mockResolvedValue(mockStats);
        renderPage();

        await waitFor(() => {
            expect(fetchCorpiCelesti).toHaveBeenCalledWith({ in_evidenza: true, per_page: 6 }, expect.any(AbortSignal));
        });
    });

    it('calls fetchDashboardStats on mount', async () => {
        fetchCorpiCelesti.mockResolvedValue({ data: [] });
        fetchDashboardStats.mockResolvedValue(mockStats);
        renderPage();

        await waitFor(() => {
            expect(fetchDashboardStats).toHaveBeenCalledOnce();
        });
    });

    it('renders "Esplora i Corpi Celesti" CTA button', () => {
        fetchCorpiCelesti.mockResolvedValue(mockCorpi());
        fetchDashboardStats.mockResolvedValue(mockStats);
        renderPage();

        const cta = screen.getByText('Esplora i Corpi Celesti');
        expect(cta).toBeInTheDocument();
        expect(cta.closest('a')).toHaveAttribute('href', '/corpi-celesti');
    });

    it('renders "Vedi tutti i corpi celesti" link', async () => {
        fetchCorpiCelesti.mockResolvedValue(mockCorpi());
        fetchDashboardStats.mockResolvedValue(mockStats);
        renderPage();

        await waitFor(() => {
            const link = screen.getByText('Vedi tutti i corpi celesti →');
            expect(link).toBeInTheDocument();
            expect(link.closest('a')).toHaveAttribute('href', '/corpi-celesti');
        });
    });

    it('handles API errors gracefully', async () => {
        fetchCorpiCelesti.mockRejectedValue(new Error('Network error'));
        fetchDashboardStats.mockRejectedValue(new Error('Network error'));
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Nessun corpo celeste in evidenza al momento.')).toBeInTheDocument();
        });
    });
});
