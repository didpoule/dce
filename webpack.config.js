var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .enableSourceMaps(!Encore.isProduction())
    //.cleanupOutputBeforeBuild()
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    .addEntry('js/app', './assets/js/app.js')
    .addStyleEntry('css/app_front', './assets/css/app_front.sass')
    .addStyleEntry('css/app_back', './assets/css/app_back.sass')

    // uncomment if you use Sass/SCSS files
    .enableSassLoader(function (options) {
        options.relativeUrls = false;
    })

    // uncomment for legacy applications that require $/jQuery as a global variable
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
