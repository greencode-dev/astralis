import axios from 'axios';

const apiClient = axios.create({
    baseURL: '/api',
    timeout: 30000,
    headers: {
        'Accept': 'application/json',
    },
});

apiClient.interceptors.response.use(
    response => response,
    async error => {
        if (axios.isCancel(error)) return Promise.reject(error);

        const config = error.config;
        if (!config) return Promise.reject(error);

        const retryCount = (config.retryCount || 0) + 1;
        const shouldRetry = !error.response || (error.response.status >= 500 && error.response.status < 600);

        if (shouldRetry && retryCount <= 2) {
            config.retryCount = retryCount;
            const delay = Math.pow(2, retryCount) * 500;
            await new Promise(resolve => setTimeout(resolve, delay));
            return apiClient.request(config);
        }

        if (error.response) {
            if (import.meta.env.DEV) {
                console.error(`API Error ${error.response.status}:`, error.response.data);
            }
        } else if (error.request) {
            if (import.meta.env.DEV) {
                console.error('API Network Error:', error.message);
            }
        }

        return Promise.reject(error);
    }
);

export function fetchCorpiCelesti(params = {}, signal) {
    return apiClient.get('/corpi-celesti', { params, signal }).then(res => res.data);
}

export function fetchCategorie(signal) {
    return apiClient.get('/categorie', { signal }).then(res => res.data);
}

export function fetchCorpoCeleste(slug, signal) {
    return apiClient.get(`/corpi-celesti/${slug}`, { signal }).then(res => res.data);
}

export function fetchSimili(id, signal) {
    return apiClient.get(`/corpi-celesti/${id}/simili`, { signal }).then(res => res.data);
}

export function fetchDashboardStats(signal) {
    return apiClient.get('/dashboard/stats', { signal }).then(res => res.data);
}