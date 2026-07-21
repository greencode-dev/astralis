import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/guest/main.jsx',
                'resources/js/admin.js',
                'resources/css/app.css',
            ],
            refresh: true,
        }),
        react(),
    ],
    server: {
        host: '127.0.0.1',
        port: 5175,
        strictPort: true,
        proxy: {
            '/api': 'http://localhost:8000',
        },
    },
});
