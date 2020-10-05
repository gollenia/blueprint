const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.postCss('./assets/src/css/style.css', './assets/css/style.css',
	tailwindcss('./tailwind.config.js')
);
