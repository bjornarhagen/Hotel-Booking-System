const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js").version();
mix.sass("resources/sass/app.scss", "public/css").version();

mix.browserSync({
    proxy: "localhost:8000",
    open: false,
    notify: false
});

mix.disableSuccessNotifications();
