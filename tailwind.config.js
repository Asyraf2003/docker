import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    safelist: [
        // icon colors
        'text-green-500', 'text-yellow-500', 'text-cyan-500', 'text-purple-500',
        // text colors (light)
        'text-green-600', 'text-yellow-600', 'text-cyan-600', 'text-purple-600',
        // text colors (dark variants) — tulis kelas lengkap yang dipakai
        'dark:text-green-400', 'dark:text-yellow-400', 'dark:text-cyan-400', 'dark:text-purple-400',
        // fallback
        'text-indigo-500', 'text-gray-900', 'dark:text-gray-100',
    ],
    
    plugins: [forms],
};

