const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.postCss('./assets/src/css/style.css', './assets/dist/style.css',
	tailwindcss('./tailwind.config.js')
);

mix.postCss('./assets/src/css/admin.css', './assets/dist/admin.css');

mix.js('./assets/src/js/app.js', './assets/dist/app.js');
