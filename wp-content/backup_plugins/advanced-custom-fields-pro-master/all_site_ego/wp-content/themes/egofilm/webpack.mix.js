let mix = require('laravel-mix');
mix.setPublicPath('custom');

mix.js('src/js/app.js', 'js/app.js');

mix.sass('src/scss/app.scss', 'css/base.css').options({
  processCssUrls: false,
});

mix.browserSync({
  server: false,
  proxy: 'http://localhost:8888',
  files: ['template-parts/*.php', '*.php', 'custom/**/*'],
});
