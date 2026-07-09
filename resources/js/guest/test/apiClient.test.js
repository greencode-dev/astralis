const mockGet = vi.fn();

vi.mock('axios', () => ({
    default: {
        create: vi.fn(() => ({ get: mockGet })),
    },
}));

import axios from 'axios';
import {
    fetchCorpiCelesti,
    fetchCategorie,
    fetchCorpoCeleste,
    fetchSimili,
    fetchMissioni,
    fetchDashboardStats,
} from '../apiClient';

describe('apiClient', () => {
    beforeEach(() => {
        mockGet.mockReset();
    });

    afterEach(() => {
        vi.clearAllMocks();
    });

    describe('fetchCorpiCelesti', () => {
        it('calls GET /corpi-celesti with params', async () => {
            const mockData = { data: [{ id: 1, nome: 'Terra' }], meta: { total: 1 } };
            mockGet.mockResolvedValue({ data: mockData });

            const result = await fetchCorpiCelesti({ categoria: 'pianeti', per_page: 12 });

            expect(mockGet).toHaveBeenCalledWith('/corpi-celesti', { params: { categoria: 'pianeti', per_page: 12 } });
            expect(result).toEqual(mockData);
        });

        it('calls with default empty params', async () => {
            mockGet.mockResolvedValue({ data: { data: [] } });

            await fetchCorpiCelesti();

            expect(mockGet).toHaveBeenCalledWith('/corpi-celesti', { params: {} });
        });

        it('unwraps res.data correctly on success', async () => {
            const response = { data: { data: [{ id: 1, nome: 'Marte' }], meta: { last_page: 1, total: 1 } } };
            mockGet.mockResolvedValue(response);

            const result = await fetchCorpiCelesti();

            expect(result).toEqual(response.data);
        });
    });

    describe('fetchCategorie', () => {
        it('calls GET /categorie and unwraps data', async () => {
            const categorie = { data: [{ id: 1, nome: 'Pianeta', slug: 'pianeti' }] };
            mockGet.mockResolvedValue({ data: categorie });

            const result = await fetchCategorie();

            expect(mockGet).toHaveBeenCalledWith('/categorie');
            expect(result).toEqual(categorie);
        });
    });

    describe('fetchCorpoCeleste', () => {
        it('calls GET /corpi-celesti/{slug}', async () => {
            const corpo = { data: { id: 1, nome: 'Terra', slug: 'terra' } };
            mockGet.mockResolvedValue({ data: corpo });

            const result = await fetchCorpoCeleste('terra');

            expect(mockGet).toHaveBeenCalledWith('/corpi-celesti/terra');
            expect(result).toEqual(corpo);
        });

        it('handles different slugs correctly', async () => {
            mockGet.mockResolvedValue({ data: { data: { id: 2, slug: 'giove' } } });

            await fetchCorpoCeleste('giove');

            expect(mockGet).toHaveBeenCalledWith('/corpi-celesti/giove');
        });
    });

    describe('fetchSimili', () => {
        it('calls GET /corpi-celesti/{id}/simili', async () => {
            const simili = { data: [{ id: 2, nome: 'Marte' }] };
            mockGet.mockResolvedValue({ data: simili });

            const result = await fetchSimili(1);

            expect(mockGet).toHaveBeenCalledWith('/corpi-celesti/1/simili');
            expect(result).toEqual(simili);
        });

        it('uses numeric id in URL', async () => {
            mockGet.mockResolvedValue({ data: { data: [] } });

            await fetchSimili(42);

            expect(mockGet).toHaveBeenCalledWith('/corpi-celesti/42/simili');
        });
    });

    describe('fetchMissioni', () => {
        it('calls GET /missioni with params', async () => {
            const missioni = { data: [{ id: 1, nome: 'Apollo 11' }] };
            mockGet.mockResolvedValue({ data: missioni });

            const result = await fetchMissioni({ stato: 'completata' });

            expect(mockGet).toHaveBeenCalledWith('/missioni', { params: { stato: 'completata' } });
            expect(result).toEqual(missioni);
        });

        it('calls with default empty params', async () => {
            mockGet.mockResolvedValue({ data: { data: [] } });

            await fetchMissioni();

            expect(mockGet).toHaveBeenCalledWith('/missioni', { params: {} });
        });
    });

    describe('fetchDashboardStats', () => {
        it('calls GET /dashboard/stats', async () => {
            const stats = { totale_corpi_celesti: 150, totale_categorie: 8, totale_missioni: 25 };
            mockGet.mockResolvedValue({ data: stats });

            const result = await fetchDashboardStats();

            expect(mockGet).toHaveBeenCalledWith('/dashboard/stats');
            expect(result).toEqual(stats);
        });
    });
});
