import { render, screen, waitFor } from '@testing-library/react';
import { MemoryRouter, Route, Routes } from 'react-router-dom';
import CorpoDettaglio from '../pages/CorpoDettaglio';
import { mockCorpoDettaglioDettaglio, marte, venere } from './fixtures';

vi.mock('../apiClient', () => ({
    fetchCorpoCeleste: vi.fn(),
    fetchSimili: vi.fn(),
}));

import { fetchCorpoCeleste, fetchSimili } from '../apiClient';

function renderPage(slug = 'terra') {
    return render(
        <MemoryRouter initialEntries={[`/corpi-celesti/${slug}`]}>
            <Routes>
                <Route path="/corpi-celesti/:slug" element={<CorpoDettaglio />} />
            </Routes>
        </MemoryRouter>
    );
}

const mockSimili = {
    data: [marte, venere],
};

describe('CorpoDettaglio', () => {
    beforeEach(() => {
        vi.clearAllMocks();
    });

    it('shows loading state initially', () => {
        fetchCorpoCeleste.mockImplementation(() => new Promise(() => {}));
        renderPage();

        const skeletons = document.querySelectorAll('.animate-pulse');
        expect(skeletons.length).toBeGreaterThanOrEqual(1);
    });

    it('loads and displays corpo detail', async () => {
        fetchCorpoCeleste.mockResolvedValue(mockCorpoDettaglio);
        fetchSimili.mockResolvedValue(mockSimili);
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Terra')).toBeInTheDocument();
        });

        expect(screen.getByText('Il terzo pianeta del sistema solare.')).toBeInTheDocument();
        expect(screen.getByText('roccioso')).toBeInTheDocument();
    });

    it('displays "in evidenza" badge', async () => {
        fetchCorpoCeleste.mockResolvedValue(mockCorpoDettaglio);
        fetchSimili.mockResolvedValue(mockSimili);
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('★ In evidenza')).toBeInTheDocument();
        });
    });

    it('displays categoria badge', async () => {
        fetchCorpoCeleste.mockResolvedValue(mockCorpoDettaglio);
        fetchSimili.mockResolvedValue(mockSimili);
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Pianeta')).toBeInTheDocument();
        });
    });

    it('displays scientific metrics', async () => {
        fetchCorpoCeleste.mockResolvedValue(mockCorpoDettaglio);
        fetchSimili.mockResolvedValue(mockSimili);
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Dati Scientifici')).toBeInTheDocument();
        });

        expect(screen.getByText(/12\.7/)).toBeInTheDocument();
        expect(screen.getByText(/150/)).toBeInTheDocument();
        expect(screen.getByText(/9\.81/)).toBeInTheDocument();
    });

    it('displays gallery section', async () => {
        fetchCorpoCeleste.mockResolvedValue(mockCorpoDettaglio);
        fetchSimili.mockResolvedValue(mockSimili);
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Galleria')).toBeInTheDocument();
        });
    });

    it('displays curiosities section', async () => {
        fetchCorpoCeleste.mockResolvedValue(mockCorpoDettaglio);
        fetchSimili.mockResolvedValue(mockSimili);
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Curiosità')).toBeInTheDocument();
        });

        expect(screen.getByText('Fatto interessante')).toBeInTheDocument();
    });

    it('displays missions section', async () => {
        fetchCorpoCeleste.mockResolvedValue(mockCorpoDettaglio);
        fetchSimili.mockResolvedValue(mockSimili);
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Missioni')).toBeInTheDocument();
        });
    });

    it('displays compare link for planets', async () => {
        fetchCorpoCeleste.mockResolvedValue(mockCorpoDettaglio);
        fetchSimili.mockResolvedValue(mockSimili);
        renderPage();

        await waitFor(() => {
            const link = screen.getByText('Confronta con un altro pianeta');
            expect(link).toBeInTheDocument();
            expect(link.closest('a')).toHaveAttribute('href', '/confronta?primo=terra');
        });
    });

    it('loads and displays simili section', async () => {
        fetchCorpoCeleste.mockResolvedValue(mockCorpoDettaglio);
        fetchSimili.mockResolvedValue(mockSimili);
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Corpi Simili')).toBeInTheDocument();
        });

        expect(screen.getByText('Marte')).toBeInTheDocument();
        expect(screen.getByText('Venere')).toBeInTheDocument();
    });

    it('calls fetchCorpoCeleste with the slug from URL', async () => {
        fetchCorpoCeleste.mockResolvedValue(mockCorpoDettaglio);
        fetchSimili.mockResolvedValue({ data: [] });
        renderPage('marte');

        await waitFor(() => {
            expect(fetchCorpoCeleste).toHaveBeenCalledWith('marte', expect.any(AbortSignal));
        });
    });

    it('calls fetchSimili with the id after corpo loads', async () => {
        fetchCorpoCeleste.mockResolvedValue(mockCorpoDettaglio);
        fetchSimili.mockResolvedValue(mockSimili);
        renderPage();

        await waitFor(() => {
            expect(fetchSimili).toHaveBeenCalledWith(1, expect.any(AbortSignal));
        });
    });

    it('shows not-found error when API call fails', async () => {
        fetchCorpoCeleste.mockRejectedValue(new Error('Not found'));
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Corpo celeste non trovato')).toBeInTheDocument();
        });

        expect(screen.getByText('Torna alla lista')).toBeInTheDocument();
    });

    it('shows not-found error when API returns null', async () => {
        fetchCorpoCeleste.mockResolvedValue(null);
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Corpo celeste non trovato')).toBeInTheDocument();
        });
    });

    it('does not show compare link for non-planets', async () => {
        const stella = {
            data: {
                ...mockCorpoDettaglio.data,
                categoria: { nome: 'Stella' },
                missioni: [],
                galleria: [],
                curiosita: [],
            },
        };
        fetchCorpoCeleste.mockResolvedValue(stella);
        fetchSimili.mockResolvedValue({ data: [] });
        renderPage('sole');

        await waitFor(() => {
            expect(screen.getByText('Terra')).toBeInTheDocument();
        });

        expect(screen.queryByText('Confronta con un altro pianeta')).not.toBeInTheDocument();
    });

    it('does not display scopritore/anno when absent', async () => {
        fetchCorpoCeleste.mockResolvedValue(mockCorpoDettaglio);
        fetchSimili.mockResolvedValue({ data: [] });
        renderPage();

        await waitFor(() => {
            expect(screen.getByText('Terra')).toBeInTheDocument();
        });

        expect(screen.queryByText('Scoperto da:')).not.toBeInTheDocument();
        expect(screen.queryByText('Anno:')).not.toBeInTheDocument();
    });

    it('displays scopritore and anno when present', async () => {
        const corpoConScoperta = {
            data: {
                ...mockCorpoDettaglio.data,
                scopritore: 'Galileo Galilei',
                anno_scoperta: 1610,
                missioni: [],
                galleria: [],
                curiosita: [],
            },
        };
        fetchCorpoCeleste.mockResolvedValue(corpoConScoperta);
        fetchSimili.mockResolvedValue({ data: [] });
        renderPage('giove');

        await waitFor(() => {
            expect(screen.getByText('Scoperto da:')).toBeInTheDocument();
        });

        expect(screen.getByText('Galileo Galilei')).toBeInTheDocument();
        expect(screen.getByText('Anno:')).toBeInTheDocument();
        expect(screen.getByText('1610')).toBeInTheDocument();
    });
});
