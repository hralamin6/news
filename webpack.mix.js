const mix = require("laravel-mix");
require("laravel-mix-tailwind");
// mix.webpackConfig({
//     stats: {
//         children: true,
//     },
// });
mix.js("resources/js/app.js", "public/js/app.js")
    .css("resources/css/app.css", "public/css/app.css")
    .tailwind("./tailwind.config.js")
    .sourceMaps();

if (mix.inProduction()) {
    mix.version();
}
