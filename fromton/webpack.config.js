var Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables Sass/SCSS support
    .enableSassLoader()

    .configureFilenames({
        css: 'css/[name].css',
        js: 'js/[name].js',
        images: '[path][name].[hash:8].[ext]'
    })
    .addEntry('fromton', [
        './assets/js/app.js',
        './assets/sass/app.sass',
    ])

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

    .addPlugin(new CopyWebpackPlugin([
        // copies to {output}/static
        { from: './assets/pacman', to: 'pacman' }
    ]))
;

module.exports = Encore.getWebpackConfig();
