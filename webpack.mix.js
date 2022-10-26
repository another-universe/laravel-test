const mix = require('laravel-mix');

mix.js('resources/js/register-page.js', 'public/assets/js/register-page.js');

mix.js('resources/js/login-page.js', 'public/assets/js/login-page.js');

mix.js('resources/js/create-recipe-page.js', 'public/assets/js/create-recipe-page.js');

mix.js('resources/js/edit-recipe-page.js', 'public/assets/js/edit-recipe-page.js');

mix.js('resources/js/show-recipe-page.js', 'public/assets/js/show-recipe-page.js');

mix.js('resources/js/bootstrap.js', 'public/assets/js/bootstrap.js');

mix.sass('resources/scss/styles.scss', 'public/assets/css/styles.css');

mix.extract();
mix.version();
mix.sourceMaps(false, 'source-map');
