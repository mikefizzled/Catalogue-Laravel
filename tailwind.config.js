import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],
    safelist:[
        'bg-conservationAmber',
        'dark:bg-conservationAmber-dark',
        'bg-conservationGreen',
        'dark:bg-conservationGreen-dark',
        'bg-conservationRed',
        'dark:bg-conservationRed-dark',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                conservationAmber: {
                  DEFAULT: '#f4960c',
                  dark:    '#b77209',
                },
                conservationGreen: {
                  DEFAULT: '#38a169',
                  dark:    '#08712b',
                },
                conservationRed: {
                  DEFAULT: '#e53e3e',
                  dark:    '#b80f19',
                },
              },
        },
    },

    plugins: [
        forms,
        require('flowbite/plugin')
    ],
};
