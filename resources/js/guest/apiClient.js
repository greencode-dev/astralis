// Client API: axios instance. Retry 2x, timeout 30s, proxy Vite /api → localhost:8000
import axios from 'axios';

// Axios instance: baseURL /api, timeout 30s, Accept JSON
const apiClient = axios.create({
    baseURL: '/api',
    timeout: 30000,
    headers: {
        'Accept': 'application/json',
    },
});

// Interceptor risposte: retry automatico su errori di rete/server (max 2x)
apiClient.interceptors.response.use(
    response => response,
    async error => {
        // Skip: se error è cancel di AbortController
        if (axios.isCancel(error)) return Promise.reject(error);

        // Config: copia config, verifica retryCount, shouldRetry se status >= 500
        const config = { ...error.config };
        if (!config) return Promise.reject(error);

        const retryCount = (config.retryCount || 0) + 1;
        const shouldRetry = !error.response || (error.response.status >= 500 && error.response.status < 600);

        // Retry con backoff: delay esponenziale 2^n * 500ms, verifica abort
        if (shouldRetry && retryCount <= 2) {
            if (config.signal?.aborted) return Promise.reject(error);
            const retryConfig = { ...config, retryCount };
            const delay = Math.pow(2, retryCount) * 500;
            await new Promise(resolve => setTimeout(resolve, delay));
            if (config.signal?.aborted) return Promise.reject(error);
            return apiClient.request(retryConfig);
        }

        // Error logging: solo in DEV mode (import.meta.env.DEV)
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

// fetchCorpiCelesti: GET /api/corpi-celesti con params + signal
export function fetchCorpiCelesti(params = {}, signal) {
    return apiClient.get('/corpi-celesti', { params, signal }).then(res => res.data);
}

// fetchCategorie: GET /api/categorie
export function fetchCategorie(signal) {
    return apiClient.get('/categorie', { signal }).then(res => res.data);
}

// fetchCorpoCeleste: GET /api/corpi-celesti/{slug}
export function fetchCorpoCeleste(slug, signal) {
    return apiClient.get(`/corpi-celesti/${slug}`, { signal }).then(res => res.data);
}

// fetchSimili: GET /api/corpi-celesti/{slug}/simili
export function fetchSimili(slug, signal) {
    return apiClient.get(`/corpi-celesti/${slug}/simili`, { signal }).then(res => res.data);
}

// fetchDashboardStats: GET /api/dashboard/stats
export function fetchDashboardStats(signal) {
    return apiClient.get('/dashboard/stats', { signal }).then(res => res.data);
}