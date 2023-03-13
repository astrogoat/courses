let mix = require('laravel-mix');

mix.postCss('resources/css/courses.css', 'public/css', [require("tailwindcss")])
