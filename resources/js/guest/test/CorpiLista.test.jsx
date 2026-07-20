import { render, screen, waitFor, fireEvent } from '@testing-library/react';
import { MemoryRouter } from 'react-router-dom';
import CorpiLista from '../pages/CorpiLista';
import { mockCategorie, terra, marte, makeCorpiResponse } from './fixtures';

vi.mock('../apiClient', () => ({
    fetchCorpiCelesti: vi.fn(),
    fetchCategorie: vi.fn(),
}));

import { fetchCorpiCelesti, fetchCategorie } from '../apiClient';

function renderPage() {
    return render(
        <MemoryRouter>
            <CorpiLista />
        </MemoryRouter>
    );
}

const mockCorpi = makeCorpiResponse([terra, marte]);

describe('CorpiLista', () => {
    beforeEach(() => {
        vi.clearAllMocks();
    });

    it('renders page title and description', () => {
        fetchCategorie.mockResolvedValue(mockCategorie);
        fetchCorpiCelesti.mockResolvedValue(mockCorpi);
        renderPage();

        expect(screen.getByText('Corpi Celesti')).toBeInTheDocument();
    });

    it('shows loading skeleton initially', () => {
        fetchCategorie.mockImplementation(() => new Promise(() => {}));
        fetchCorpiCelesti.mockImplementation(() => new Promise(() => {}));
        renderPage();

        const skeletons = document.querySelectorAll('.animate-pulse');
        expect(skeletons.length).toBeGreaterThanOrEqual(8);
    });

    it('loads and displays corpi cards', async () => {
        fetchCategorie.mockResolvedValue(mockCategorie);
        fetchCorpiCelesti.mockResolvedValue(mockCorpi);
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Terra')).toBeInTheDocument();
        });

        expect(screen.getByText('Marte')).toBeInTheDocument();
    });

    it('loads and displays category filter buttons with counts', async () => {
        fetchCategorie.mockResolvedValue(mockCategorie);
        fetchCorpiCelesti.mockResolvedValue(mockCorpi);
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('(8)')).toBeInTheDocument();
        });

        expect(screen.getByText('(5)')).toBeInTheDocument();
    });

    it('displays total count in description', async () => {
        fetchCategorie.mockResolvedValue(mockCategorie);
        fetchCorpiCelesti.mockResolvedValue(mockCorpi);
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Esplora 2 corpi celesti nel nostro catalogo')).toBeInTheDocument();
        });
    });

    it('shows "Nessun risultato trovato" when list is empty', async () => {
        fetchCategorie.mockResolvedValue({ data: [] });
        fetchCorpiCelesti.mockResolvedValue({ data: [], meta: { total: 0, last_page: 0 } });
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Nessun risultato trovato')).toBeInTheDocument();
        });
    });

    it('calls fetchCategorie on mount', async () => {
        fetchCategorie.mockResolvedValue({ data: [] });
        fetchCorpiCelesti.mockResolvedValue({ data: [], meta: { total: 0, last_page: 0 } });
        renderPage();

        await waitFor(() => {
            expect(fetchCategorie).toHaveBeenCalledOnce();
        });
    });

    it('calls fetchCorpiCelesti with default params on mount', async () => {
        fetchCategorie.mockResolvedValue({ data: [] });
        fetchCorpiCelesti.mockResolvedValue({ data: [], meta: { total: 0, last_page: 0 } });
        renderPage();

        await waitFor(() => {
            expect(fetchCorpiCelesti).toHaveBeenCalledWith({ per_page: 12, page: 1 }, expect.any(AbortSignal));
        });
    });

    it('shows type filter buttons', () => {
        fetchCategorie.mockResolvedValue(mockCategorie);
        fetchCorpiCelesti.mockResolvedValue(mockCorpi);
        renderPage();

        expect(screen.getByText('Pianeta')).toBeInTheDocument();
        expect(screen.getByText('Stella')).toBeInTheDocument();
        expect(screen.getByText('Galassia')).toBeInTheDocument();
        expect(screen.getByText('Nebulosa')).toBeInTheDocument();
    });

    it('shows pagination when lastPage > 1', async () => {
        const manyCorpi = {
            data: Array.from({ length: 12 }, (_, i) => ({
                id: i + 1,
                nome: `Corpo ${i + 1}`,
                slug: `corpo-${i + 1}`,
                descrizione: '...',
                immagine_url: null,
                tipo: 'Stella',
                distanza_km: null,
                in_evidenza: false,
                categoria: { nome: 'Stella' },
            })),
            meta: { total: 24, last_page: 2, current_page: 1 },
        };

        fetchCategorie.mockResolvedValue({ data: [] });
        fetchCorpiCelesti.mockResolvedValue(manyCorpi);
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Successiva →')).toBeInTheDocument();
        });
        expect(screen.getByText('← Precedente')).toBeInTheDocument();
        expect(screen.getByText('1')).toBeInTheDocument();
        expect(screen.getByText('2')).toBeInTheDocument();
    });

    it('calls fetchCorpiCelesti with search param when searching', async () => {
        fetchCategorie.mockResolvedValue({ data: [] });
        fetchCorpiCelesti.mockResolvedValue({ data: [], meta: { total: 0, last_page: 0 } });
        renderPage();

        const searchInput = screen.getByPlaceholderText('Cerca per nome o descrizione...');
        fireEvent.change(searchInput, { target: { value: 'Marte' } });

        await waitFor(() => {
            expect(fetchCorpiCelesti).toHaveBeenCalledWith({ per_page: 12, page: 1, search: 'Marte' }, expect.any(AbortSignal));
        });
    });

    it('shows reset filters button when filters are active', async () => {
        fetchCategorie.mockResolvedValue(mockCategorie);
        fetchCorpiCelesti.mockResolvedValue(mockCorpi);
        renderPage();

        const searchInput = screen.getByPlaceholderText('Cerca per nome o descrizione...');
        fireEvent.change(searchInput, { target: { value: 'Marte' } });

        await waitFor(() => {
            expect(screen.getByText('Reset filtri')).toBeInTheDocument();
        });
    });

    it('handles API errors gracefully', async () => {
        fetchCategorie.mockRejectedValue(new Error('Network error'));
        fetchCorpiCelesti.mockRejectedValue(new Error('Network error'));
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Errore nel caricamento dei dati')).toBeInTheDocument();
        });
    });
});
