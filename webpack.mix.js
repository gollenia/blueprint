const mix = require('laravel-mix');


//mix.postCss('./assets/src/css/style.css', './assets/dist/style.css', [
//	require("tailwindcss"),
//]);


mix.js('./assets/src/js/app.js', './assets/dist/app.js');

mix.js('./assets/src/js/admin.js', './assets/dist/admin.js');
