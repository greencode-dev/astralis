import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                admin: {
                    bg: '#0A0A1A',
                    card: '#111128',
                    text: '#F0F0FA',
                    dim: '#B8B8D0',
                    muted: '#7A7A9A',
                    primary: '#22D3EE',
                    secondary: '#A855F7',
                    accent: '#F97316',
                    warning: '#FACC15',
                },
            },
        },
    },

    plugins: [forms],
};
