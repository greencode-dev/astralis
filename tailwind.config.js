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
                    primary: '#22D3EE',
                    secondary: '#A855F7',
                    accent: '#F97316',
                },
            },
        },
    },

    plugins: [forms],
};
