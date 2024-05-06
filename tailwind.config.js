const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {

    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './index.html',
        './src/**/*.{vue,js,ts,jsx,tsx}'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            screens: {
                print: { raw: 'print' },
                screen: { raw: 'screen' },
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
