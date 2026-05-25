import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans:  ['DM Sans', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                cream:  '#FFEDCE',
                peach:  '#FFC193',
                coral:  '#FF8383',
                brand:  '#FF3737',
                dark:   '#1A0A00',
                darker: '#2E1500',
                text:   '#3D1F00',
                muted:  '#A0704A',
            },
        },
    },
    plugins: [forms],
};