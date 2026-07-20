import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
const { gen } = require('./build-id.js');

gen();

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/guest/main.jsx',
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
