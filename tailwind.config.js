/* eslint-env node */
/** @type {import('tailwindcss').Config} */
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
export default {
    mode: 'jit',
    darkMode: ['class', '[data-mode="dark"]'],
    content: [
            './resources/**/*.blade.php',
            './resources/**/*.js',
            './resources/**/*.scss',
            "./app/View/Components/**/**/*.php",
            "./app/Livewire/**/**/*.php",
            "./vendor/robsontenorio/mary/src/View/Components/**/*.php",
            './vendor/rappasoft/laravel-livewire-tables/resources/views/**/*.blade.php',
        ],
    theme: {
        extend: {
                fontFamily: {
                    'primary': 'Poppins, sans-serif',
                    'title': 'Poppins, sans-serif',
                },
                boxShadow: {
                    DEFAULT: '0 0 15px rgba(0, 0, 0, .15)',
                },
                borderRadius: {
                    'inherit': 'inherit',
                },
                lineHeight: {
                    'extra-tight': '1.1',
                },
                transitionTimingFunction: {
                    'out-back': 'cubic-bezier(0.34, 1.56, 0.64, 1)',
                },
        },

        },
        daisyui: {
            themes: [
                {
                mytheme: {
                    "primary": "#58587e",
                    "secondary": "#3b4a54",
                    "accent": "#f2f2f2",
                    "neutral": "#1c1e19",
                    "info": "#00c1ed",
                    "success": "#6cc440",
                    "warning": "#edb464",
                    "error": "#f77e7e",
                    "base-100": "#FFFFFF",
                    "base-200": "#e8e8e8",
                    "base-300": "#d8d8d8",
                },
                },
            ],
        },
        plugins: [
            require("daisyui"),
            require('@tailwindcss/aspect-ratio'),
            forms,
            typography,
    ],
}

