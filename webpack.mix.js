const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js").version();
mix.js("resources/js/user.js", "public/js").version();
mix.sass("resources/sass/app.scss", "public/css").version();
mix.sass("resources/sass/booking-step-2.scss", "public/css").version();
mix.sass("resources/sass/booking-step-3.scss", "public/css").version();
mix.sass("resources/sass/booking-step-4.scss", "public/css").version();
mix.copy("resources/icons", "public/icons");
mix.copy("resources/images", "public/images");

mix.browserSync({
    proxy: "localhost:8000",
    open: false,
    notify: false
});

mix.disableSuccessNotifications();
