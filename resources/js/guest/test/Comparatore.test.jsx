import { render, screen, waitFor, fireEvent } from '@testing-library/react';
import { MemoryRouter } from 'react-router-dom';
import Comparatore from '../pages/Comparatore';
import { pianeti, makeCorpiResponse } from './fixtures';

vi.mock('../apiClient', () => ({
    fetchCorpiCelesti: vi.fn(),
    fetchCorpoCeleste: vi.fn(),
}));

import { fetchCorpiCelesti, fetchCorpoCeleste } from '../apiClient';

function renderPage(initialEntries = ['/confronta']) {
    return render(
        <MemoryRouter initialEntries={initialEntries}>
            <Comparatore />
        </MemoryRouter>
    );
}

const mockLista = makeCorpiResponse(pianeti);

const mockDettaglio = (slug) => {
    const p = pianeti.find(p => p.slug === slug);
    return { data: { ...p, nome_display: p.nome, descrizione: `Dettaglio di ${p.nome}` } };
};

describe('Comparatore', () => {
    beforeEach(() => {
        vi.clearAllMocks();
    });

    it('renders page title and description', () => {
        fetchCorpiCelesti.mockResolvedValue(mockLista);
        renderPage();

        expect(screen.getByText('Confronta Pianeti')).toBeInTheDocument();
        expect(screen.getByText('Seleziona due pianeti per confrontare i loro dati scientifici.')).toBeInTheDocument();
    });

    it('loads planets into dropdowns on mount', async () => {
        fetchCorpiCelesti.mockResolvedValue(mockLista);
        renderPage();

        await waitFor(() => {
            expect(fetchCorpiCelesti).toHaveBeenCalledWith({ categoria: 'pianeta', per_page: 100 }, expect.any(AbortSignal));
        });

        const selects = screen.getAllByRole('combobox');
        expect(selects.length).toBe(2);
    });

    it('shows placeholder when no planets selected', async () => {
        fetchCorpiCelesti.mockResolvedValue(mockLista);
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Seleziona due pianeti per vedere il confronto')).toBeInTheDocument();
        });
    });

    it('pre-fills primo from URL params and fetches its detail', async () => {
        fetchCorpiCelesti.mockResolvedValue(mockLista);
        fetchCorpoCeleste.mockImplementation((slug) => Promise.resolve(mockDettaglio(slug)));

        renderPage(['/confronta?primo=terra']);

        await waitFor(() => {
            expect(fetchCorpoCeleste).toHaveBeenCalledWith('terra', expect.any(AbortSignal));
        });
    });

    it('shows comparison table when both planets are selected', async () => {
        fetchCorpiCelesti.mockResolvedValue(mockLista);
        fetchCorpoCeleste.mockImplementation((slug) => Promise.resolve(mockDettaglio(slug)));

        renderPage(['/confronta?primo=terra&secondo=marte']);

        await waitFor(() => {
            expect(screen.getAllByText('Terra').length).toBeGreaterThanOrEqual(2);
        });

        expect(screen.getAllByText('Marte').length).toBeGreaterThanOrEqual(2);

        await waitFor(() => {
            expect(screen.getByText('Massa')).toBeInTheDocument();
            expect(screen.getByText('Diametro')).toBeInTheDocument();
            expect(screen.getByText('Gravità')).toBeInTheDocument();
            expect(screen.getByText('Temperatura')).toBeInTheDocument();
        });
    });

    it('displays scientific comparison data', async () => {
        fetchCorpiCelesti.mockResolvedValue(mockLista);
        fetchCorpoCeleste.mockImplementation((slug) => Promise.resolve(mockDettaglio(slug)));

        renderPage(['/confronta?primo=terra&secondo=marte']);

        await waitFor(() => {
            expect(screen.getByText(/12\.7/)).toBeInTheDocument();
            expect(screen.getByText(/6\.8/)).toBeInTheDocument();
        });
    });

    it('excludes already-selected planet from the other dropdown options', async () => {
        fetchCorpiCelesti.mockResolvedValue({
            data: pianeti.slice(0, 2),
            meta: { total: 2, last_page: 1 },
        });
        fetchCorpoCeleste.mockImplementation((slug) => Promise.resolve(mockDettaglio(slug)));

        renderPage(['/confronta?primo=mercurio']);

        const selects = await waitFor(() => {
            const allSelects = screen.getAllByRole('combobox');
            expect(allSelects.length).toBe(2);
            return allSelects;
        });

        const secondoSelect = selects[1];
        const options = Array.from(secondoSelect.querySelectorAll('option'));
        const optionValues = options.map(o => o.value);

        expect(optionValues).not.toContain('mercurio');
        expect(optionValues).toContain('venere');
    });

    it('shows loading skeleton while fetching details', async () => {
        fetchCorpiCelesti.mockResolvedValue(mockLista);
        fetchCorpoCeleste.mockImplementation(() => new Promise(() => {}));

        renderPage(['/confronta?primo=terra&secondo=marte']);

        const skeletons = document.querySelectorAll('.animate-pulse');
        expect(skeletons.length).toBeGreaterThanOrEqual(1);
    });

    it('renders back link to corpo list', () => {
        fetchCorpiCelesti.mockResolvedValue(mockLista);
        renderPage();

        const backLink = screen.getByText('Torna alla lista');
        expect(backLink).toBeInTheDocument();
        expect(backLink.closest('a')).toHaveAttribute('href', '/corpi-celesti');
    });
});
