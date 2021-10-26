const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */


mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.styles([
    'resources/assets/css/main.css',
    'resources/assets/css/structure.css',
    'resources/assets/css/custom.css',
    'resources/css/custom-styles.css',
], 'public/css/admin.min.css').sourceMaps();


mix.styles([
    'resources/css/fonts.css',
    'resources/plugins/font-icons/fontawesome/css/regular.css',
    'resources/plugins/font-icons/fontawesome/css/fontawesome.css',
], 'public/css/fonts.min.css').sourceMaps();

mix.scripts([
    'resources/assets/js/app.js',
    'resources/assets/js/custom.js',
], 'public/js/admin.min.js').sourceMaps();

mix.styles([
    'resources/plugins/perfect-scrollbar/perfect-scrollbar.css',
    'resources/plugins/highlight/styles/monokai-sublime.css',
    'resources/plugins/izitoast/css/iziToast.min.css',
    'resources/assets/css/apps/notes.css',
    'resources/assets/css/forms/theme-checkbox-radio.css',
    'resources/plugins/bootstrap-select/bootstrap-select.min.css',

    'resources/assets/css/forms/switches.css'
], 'public/css/plugins.min.css').sourceMaps();


mix.scripts([
    'resources/plugins/perfect-scrollbar/perfect-scrollbar.min.js',
    'resources/plugins/izitoast/js/iziToast.min.js',
    'resources/assets/js/ie11fix/fn.fix-padStart.js',
    'resources/plugins/font-icons/feather/feather.js',
    'resources/plugins/bootstrap-select/bootstrap-select.min.js',
    'resources/js/fonts.js',
    'resources/js/eventos.js',
], 'public/js/plugins.min.js').sourceMaps();

mix.styles('resources/assets/css/elements/avatar.css', 'public/assets/css/elements/avatar.css').sourceMaps();
mix.styles('resources/assets/css/components/tabs-accordian/custom-tabs.css', 'public/assets/css/components/tabs-accordian/custom-tabs.css').sourceMaps();
mix.styles('resources/assets/css/tables/table-basic.css', 'public/assets/css/tables/table-basic.css').sourceMaps();
mix.styles('resources/assets/css/authentication/form-1.css', 'public/assets/css/authentication/form-1.css').sourceMaps();
mix.styles('resources/assets/css/scrollspyNav.css', 'public/assets/css/scrollspyNav.css').sourceMaps();
mix.styles('resources/assets/css/components/tabs-accordian/custom-accordions.css', 'public/assets/css/components/tabs-accordian/custom-accordions.css').sourceMaps();
mix.styles('resources/plugins/dropify/dropify.min.css', 'public/plugins/dropify/dropify.min.css').sourceMaps();
mix.js('resources/assets/js/authentication/form-1.js', 'public/assets/js/authentication/form-1.js').sourceMaps();
mix.js('resources/assets/js/scrollspyNav.js', 'public/assets/js/scrollspyNav.js').sourceMaps();
mix.js('resources/assets/js/components/ui-accordions.js', 'public/assets/js/components/ui-accordions.js').sourceMaps();
mix.styles('resources/assets/css/dashboard/dash_2.css', 'public/assets/css/dashboard/dash_2.css').sourceMaps();
mix.styles('resources/assets/css/dashboard/dash_1.css', 'public/assets/css/dashboard/dash_1.css').sourceMaps();
mix.copyDirectory('resources/assets/css/users', 'public/assets/css/users');
mix.copyDirectory('resources/fonts', 'public/fonts');
mix.copyDirectory('resources/assets/img', 'public/img');
mix.copyDirectory('resources/plugins/select2', 'public/plugins/select2');



mix.styles('resources/assets/css/elements/miscellaneous.css', 'public/assets/css/elements/miscellaneous.css').sourceMaps();
mix.styles('resources/assets/css/elements/breadcrumb.css', 'public/assets/css/elements/breadcrumb.css').sourceMaps();
mix.styles('resources/assets/css/structure-minimal.css', 'public/assets/css/structure-minimal.css').sourceMaps();

mix.styles('resources/plugins/apex/apexcharts.css', 'public/plugins/apex/apexcharts.css').sourceMaps();
mix.js('resources/plugins/apex/apexcharts.min.js', 'public/plugins/apex/apexcharts.min.js').sourceMaps();

mix.styles('resources/assets/css/pages/error/style-400.css', 'public/assets/css/pages/error/style-400.css').sourceMaps();
mix.styles('resources/assets/css/pages/privacy/privacy.css', 'public/assets/css/pages/privacy/privacy.css').sourceMaps();

mix.styles('resources/plugins/bootstrap-select/bootstrap-select.min.css', 'public/plugins/bootstrap-select/bootstrap-select.min.css').sourceMaps();

mix.styles('resources/assets/css/components/tabs-accordian/custom-accordions.css', 'public/assets/css/components/tabs-accordian/custom-accordions.css').sourceMaps();
