const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                'primary': '#003D29',
                'secondary': '#20A220'
            },
            fontFamily: {
                sans: ['Raleway', ...defaultTheme.fontFamily.sans],
            },
            container: {
                center: true,
                padding: {
                    DEFAULT: '1rem',
                    lg: '2rem',
                },
                screens: {
                    sm: '100%',
                    md: '640px',
                    lg: '1024px',
                    xl: '1280px',
                    '2xl': '1440px',
                },
            },
            backgroundImage: {
                'hero-banner': "url('https://plus.unsplash.com/premium_photo-1719289799376-d3de0ca4ddbc?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')",
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
